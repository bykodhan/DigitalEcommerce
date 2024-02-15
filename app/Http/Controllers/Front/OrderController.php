<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\ProductOption;
use App\Models\ProductStock;
use Cache;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //Generate Order Id
    public function generate_order_id($id)
    {
        $order_id = rand(100, 999999);
        $order = Order::where('order_id', $order_id)->first();
        if ($order) {
            $this->generate_order_id();
        } else {
            return $order_id;
        }
    }
    //step_1
    public function step_1(Request $request)
    {
        $product = Product::where('id', $request->product_id)->first();
        if ($product) {
            $product_stock_type = ProductDetail::select('stock_type')->where('product_id', $product->id)->first()->stock_type;
            if ($product_stock_type == 3) {
                if ($product->stocks->count() < $request->qty) {
                    return redirect()->back()->with('error', 'En fazla ' . $product->stocks->count() . ' adet seçebilirsiniz.');
                }
            }
            if ($product->discount_price) {
                $product_price = $product->discount_price;
            } else {
                $product_price = $product->price;
            }
            $option = ProductOption::where('id', $request->option_id)->first();
            if ($option) {
                $total_price = $option->price * $request->qty;
            } else {
                $total_price = $product_price * $request->qty;
            }
            return view('front.orders.step_1', compact('product', 'request', 'option', 'total_price'));

        }
    }
    //Sipariş Oluşturma
    public function step_2(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email',
            'phone' => 'required|min:10|max:11',
            'product_id' => 'required',
            'qty' => 'required',
        ]);

        $product = Product::where('id', $request->product_id)->first();
        if ($product) {
            $product_detail = ProductDetail::where('product_id', $product->id)->first();
            $order = new Order;
            if ($product_detail->stock_type == 2) {
                $stock = ProductStock::where('product_id', $product->id)->first()->content;
                $order->stock_type = 2;
            }

            $option = ProductOption::where('id', $request->option_id)->first();
            $order->name = $request->name;
            $order->surname = $request->surname;
            $order->email = $request->email;
            $order->phone = $request->phone;
            $order->user_ip = $request->ip();
            $order->qty = $request->qty;
            $order->product_id = $product->id;
            $order->product_title = $product->title;
            if ($product->discount_price) {
                $product_price = $product->discount_price;
            } else {
                $product_price = $product->price;
            }
            $order->product_price = $product_price;
            $order->lead_time = $product->lead_time;

            if ($request->customer_fields) {
                $customer_answers = array_zip_combine(['field', 'answer'], $request->customer_fields, $request->customer_answers);
                $order->customer_answers = json_encode($customer_answers);
            }

            if ($option) {
                $order->option_name = $option->title;
                $order->option_price = $option->price;
                $order->amount_paid = $option->price * $request->qty;
            } else {
                $order->amount_paid = $product_price * $request->qty;
            }
            if ($request->coupon_code) {
                $coupon = Coupon::where('code', $request->coupon_code)->first();
                if ($coupon) {
                    $order->amount_paid = $order->amount_paid - $coupon->price;
                    $order->coupon_code = $request->coupon_code;
                }
            }
            $order->order_status = 0; //Ödeme Bekleniyor
            if ($request->note) {
                $order->note = $request->note;
            }
            $order->save();
            $order->order_id = $this->generate_order_id($order->id);
            if (isset($stock)) {
                $order->stock_content = $stock;

            }
            if ($order->save()) {
                if (Cache::get('telegram_bot_active') == 1) {
                    if ($order->option_name) {
                        $option_name = $order->option_name;
                    } else {
                        $option_name = '-';
                    }
                    $message = 'Yeni Sipariş Oluşturuldu: ' . $order->order_id . ' - ' . $order->product_title . ' - ' . $option_name . ' - ' . $order->qty . ' Adet - ' . $order->amount_paid . ' TL' . ' - ' . $order->name . ' ' . $order->surname . ' - ' . $order->email . ' - ' . $order->phone;
                    telegram_bot_send_message($message);
                }

                return redirect(route('order.step_3', ['order_id' => $order->order_id, 'email' => $order->email]));
            } else {
                return redirect()->back()->with('error', 'Sipariş oluşturulurken bir hata oluştu.');
            }
        }
    }

    public function step_3(Request $request)
    {
        $order = Order::where('order_id', $request->order_id)->where('email', $request->email)->first();

        if ($order) {
            if ($order->order_status == 0) {
                //Ödeme Bekleniyor
                return view('front.orders.step_3', compact('order'));
            }
            if ($order->order_status == 1 || $order->order_status == 2) {
                //Ödeme Onaylandı
                return redirect(route('order.ok', ['order_id' => $order->order_id, 'email' => $order->email]));
            }
        } else {
            return redirect()->route('index');
        }

    }

    public function check(Request $request)
    {

        $request->validate([
            'order_id' => 'required',
            'email' => 'required|email',
        ]);
        $order = Order::where('order_id', $request->order_id)->where('email', $request->email)->first();
        if ($order) {
            if ($order->order_status == 0) {
                //Ödeme Bekleniyor
                return redirect(route('order.step_3', ['order_id' => $order->order_id, 'email' => $order->email]));
            }
            if ($order->order_status == 1 || $order->order_status == 2) {
                //Ödeme Onaylandı
                return redirect(route('order.ok', ['order_id' => $order->order_id, 'email' => $order->email]));
            }
        } else {
            return redirect()->back()->with('error', 'Sipariş bulunamadı.');
        }
    }

    public function ok(Request $request)
    {
        $order = Order::where('order_id', $request->order_id)->where('email', $request->email)->first();
        if ($order) {
            //Ödeme Onaylanmış
            return view('front.orders.ok', compact('order'));

        } else {
            return redirect()->back()->with('error', 'Sipariş bulunamadı.');
        }
    }

    public function order_send_txt(Request $request)
    {
        $order = Order::where('order_id', $request->order_id)->first();
        if ($order) {
            header("Content-type: text/plain");
            header("Content-Disposition: attachment; filename=" . $order->order_id . ".txt");
            header("Pragma: no-cache");
            header("Expires: 0");
            foreach (explode(',', $order->stock_content) as $stock) {
                echo $stock . PHP_EOL;
            }
        } else {
            return redirect()->back()->with('error', 'Sipariş bulunamadı.');
        }
    }

    public function coupon_check(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required',
        ]);
        $coupon = Coupon::where('code', $request->coupon_code)->first();
        if ($coupon) {
            if ($coupon->max_count < $coupon->usage_count) {
                return response()->json(['error' => 'Kupon kullanım limiti dolmuştur.']);
            }
            $product = Product::where('id', $request->product_id)->first();
            if ($product) {
                if ($product->stock_type == 3) {
                    if ($product->stocks->count() < $request->qty) {
                        return response()->json(['error' => 'Stok yetersiz.']);
                    }
                }
                $option = ProductOption::where('id', $request->option_id)->first();
                if ($product->discount_price) {
                    $product_price = $product->discount_price;
                } else {
                    $product_price = $product->price;
                }
                if ($option) {
                    $total_price = $option->price * $request->qty;
                } else {
                    $total_price = $product_price * $request->qty;
                }
                if ($coupon->min_price > $total_price) {
                    return response()->json(['error' => 'Kuponu kullanabilmek en düşük fiyat: ' . money($coupon->min_price) . '₺ olmalıdır.']);
                }
                $total_price = $total_price - $coupon->price;
                return response()->json(['success' => true,
                    'coupon_code' => $coupon->code,
                    'total_price' => money($total_price), 'coupon_discount' => $coupon->price]);
            }
        } else {
            return response()->json(['error' => 'Kupon kodu geçersiz.']);
        }
    }

    public function auto_delete()
    {
        $orders = Order::where('order_status', 0)->where('payment_status', 0)->where('created_at', '<', now()->subMinutes(10))->get();
        foreach ($orders as $order) {
            if ($order->stock_type == 3 && $order->stock_content) {
                $stocks = [];
                foreach (explode(',', $order->stock_content) as $value) {
                    $item = [
                        'product_id' => $order->product_id,
                        'content' => $value,
                        'stock_type' => 3,
                    ];
                    array_push($stocks, $item);
                }
                ProductStock::insert($stocks);
            }
            $order->delete();
        }
    }
}

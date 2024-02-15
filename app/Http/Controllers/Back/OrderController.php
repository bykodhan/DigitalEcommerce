<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\ProductStock;
use App\Models\ProductDetail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index($order_status)
    {
        switch ($order_status) {
            case 0:
                $title = 'Onay Bekleyenler';
                break;
            case 1:
                $title = 'Stok Bekleyenler';
                break;
            case 2:
                $title = 'Tamamlananlar';
                break;
            case 3:
                $title = 'İptal Edilenler';
                break;
        }

        $orders = Order::where('order_status', $order_status)->orderBy('created_at', 'desc')->simplepaginate(100);
        return view('back.orders.index', compact('title', 'orders'));
    }

    public function ok(Request $request)
    {
        $order = Order::where('order_id', $request->order_id)->first();
        if ($order) {
            $product_detail = ProductDetail::where('product_id', $order->product_id)->first();

            if ($product_detail->stock_type == 3) {
                $stocks = ProductStock::where('product_id', $order->product_id);
                if ($stocks->count() >= $order->qty) {
                    $stock = $stocks->take($order->qty)->get()->pluck('content')->implode(',');
                    $order->stock_type = 3;
                }
            }
            if ($product_detail->stock_type == 3) {
                $stocks->delete();
            }
            if (isset($stock)) {
                $order->stock_content = $stock;
            }
            if ($order->stock_content) {
                $order->order_status = 2; //tamamlandı
            } else {
                //Eğer stok bekleyenlerdeyse tamamlandı olarak işaretle
                if ($order->order_status == 1) {
                    $order->order_status = 2; //Tamamlandı
                } else {
                    $order->order_status = 1; //Stok Bekleyenler

                }
            }
            if ($order->coupon_code) {
                $coupon = Coupon::where('code', $order->coupon_code)->first();
                if ($coupon) {
                    if ($order->order_status == 2) {
                        $coupon->usage_count = $coupon->usage_count + 1;
                        $coupon->save();
                    }
                }
            }
            $order->payment_status = 1; //Ödeme Onaylandı

            $order->save();
            return redirect()->back()->with('success', 'Sipariş onaylandı');
        } else {
            return redirect()->back()->with('error', 'Sipariş bulunamadı.');
        }
    }
    public function edit_stock(Request $request)
    {
        $order = Order::where('order_id', $request->order_id)->first();
        if ($order) {
            $order->stock_content = $request->stock_content;
            $order->lead_time = $request->lead_time;
            $order->save();
            return redirect()->back()->with('success', 'Sipariş güncellendi');
        } else {
            return redirect()->back()->with('error', 'Sipariş bulunamadı.');
        }
    }
    public function order_send_mail(Request $request)
    {
        $order = Order::where('order_id', $request->order_id)->first();
        if ($order) {
            $body = '<h1>Siparişiniz</h1>';
            $body .= '<p>Sipariş No: ' . $order->order_id . '</p>';
            $body .= '<p>Sipariş Tutarı: ' . money($order->amount_paid) . '₺</p>';
            $body .= '<p>Sipariş Tarihi: ' . $order->created_at . '</p>';

            $body .= '<p>Ürün Adı x Adet: ' . money($order->product_price) . ' ₺ ' . $order->product_title . ' x ' . $order->qty . '</p>';
            if ($order->option_name) {
                $body .= '<p>Seçili Seçenek: ' . $order->option_name . ' Fiyat : ' . money($order->option_price) . ' ₺ ' . '</p>';
            }
            if ($order->customer_answers) {
                $body .= '<ul>';
                foreach (json_decode($order->customer_answers, true) as $answer) {
                    $body .= '<li>' . $answer['field'] . ' : ' . $answer['answer'] . '</li>';
                }
                $body .= '</ul>';
            }
            if ($order->stock_content) {
                $body .= '<p>Stok Bilgileri:</p>';
                foreach (explode(',', $order->stock_content) as $stock) {
                    $body .= '<p>' . $stock . '</p>';
                }
            }
            $email = send_mail($order->email, $order->order_id . ' Siparişiniz Onaylandı', $body);
            if ($email) {
                return redirect()->back()->with('success', 'Sipariş Bilgileri ' . $order->email . ' adresine mail olarak gönderildi');
            } else {
                return $email;

            }
        } else {
            return redirect()->back()->with('error', 'Sipariş bulunamadı.');
        }
    }
    public function delete(Request $request)
    {
        $order = Order::where('id', $request->id)->first();
        if ($order) {
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
            return redirect()->back()->with('success', 'Sipariş silindi');
        } else {
            return redirect()->back()->with('error', 'Sipariş bulunamadı.');
        }
    }
    public function cancel(Request $request)
    {
        $order = Order::where('id', $request->id)->first();
        if ($order) {
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
            $order->stock_content = null;
            $order->order_status = 3; //iptal edildi
            $order->save();
            return redirect()->back()->with('success', 'Sipariş İptal Edildi');
        } else {
            return redirect()->back()->with('error', 'Sipariş bulunamadı.');
        }
    }
}

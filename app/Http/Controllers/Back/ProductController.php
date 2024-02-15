<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\ProductOption;
use App\Models\ProductStock;
use File;
use Illuminate\Http\Request;
use Image;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->simplepaginate(100);
        return view('back.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('sortable')->get();
        return view('back.products.create', compact('categories'));
    }

    public function edit($id)
    {
        $product = Product::where('id', $id)->first();
        if ($product) {
            $product_detail = ProductDetail::where('product_id', $id)->first();
            $product_stock = ProductStock::where('product_id', $id)->get();
            $product_options = ProductOption::where('product_id', $id)->get();
            $categories = Category::orderBy('sortable')->get();
            return view('back.products.edit', compact('product', 'categories', 'product_detail', 'product_stock', 'product_options'));
        } else {
            abort(404);
        }
    }

    public function image_upload(Request $request)
    {
        $imageFolder = "uploads/tinymce/";
        $temp = current($_FILES);
        $filetowrite = $imageFolder . $temp['name'];
        move_uploaded_file($temp['tmp_name'], $filetowrite);
        // Determine the base URL
        echo json_encode(array('location' => asset($filetowrite)));
    }

    public function store(Request $request)
    {
        $product = new Product;
        $product->category_id = $request->category_id;
        $product->title = $request->title;
        $product->slug = $request->slug;
        if ($request->img) {
            $path = 'uploads/products/p_' . uniqid() . '.webp';
            $img = Image::make($request->img)->encode('webp')->save($path);
            $img->destroy();
            $product->img = $path;
        }
        if ($request->discount) {
            $product->discount = $request->discount;
            $product->discount_price = $request->discount_price;
        }
        $product->price = $request->price;

        $product->accept_features = $request->accept_features;
        $product->unaccept_features = $request->unaccept_features;
        $product->lead_time = $request->lead_time;
        $product->favorite_index = $request->favorite_index;

        if ($product->save()) {
            $product_detail = new ProductDetail;
            $product_detail->product_id = $product->id;
            if ($request->button_title) {
                $result = array_zip_combine(['title', 'href', 'target', 'style'], $request->button_title, $request->button_href, $request->button_target, $request->buton_style);
                $product_detail->buttons = json_encode($result);
            }
            if ($request->customer_info_field) {
                $product_detail->customer_infos = implode(',', $request->customer_info_field);
            }

            $product_detail->stock_type = $request->stock_type;
            //1-adetli alım açık
            $product_detail->one_piece = $request->one_piece;
            $product_detail->wp = $request->wp;
            $product_detail->content = $request->content;
            if ($product_detail->save()) {

                // 1-Manuel Teslimat (sınırsız stok) 2-Herkese aynı stok teslim(sınırsız stok) 3-Kişiye Özel Stok (sınırlı stok)
                if ($request->stock_type == 2) {
                    $product_stock = new ProductStock;
                    $product_stock->product_id = $product->id;
                    $product_stock->content = $request->stock2;
                    $product_stock->stock_type = $request->stock_type;
                    $product_stock->save();
                }
                if ($request->stock_type == 3) {
                    foreach (preg_split('/\r\n|[\r\n]/', $request->stock3) as $data) {
                        $product_stock = new ProductStock;
                        $product_stock->product_id = $product->id;
                        $product_stock->content = $data;
                        $product_stock->stock_type = $request->stock_type;
                        $product_stock->save();
                    }
                }
                if ($request->option_title) {
                    $options = [];
                    foreach ($request->option_title as $key => $value) {
                        $item = [
                            'product_id' => $product->id,
                            'title' => $value,
                            'price' => $request->option_price[$key],
                        ];
                        array_push($options, $item);
                    }
                    ProductOption::insert($options);
                }
                return redirect()->back()->with('success', 'Ürün başarıyla eklendi.');
            }
        }
    }

    public function update(Request $request)
    {
        $product = Product::where('id', $request->product_id)->first();
        if ($product) {
            $product->category_id = $request->category_id;
            $product->title = $request->title;
            $product->slug = $request->slug;
            if ($request->img) {
                File::delete($product->img);
                $path = 'uploads/products/p_' . uniqid() . '.webp';
                $img = Image::make($request->img)->encode('webp')->save($path);
                $img->destroy();
                $product->img = $path;
            }
            $product->discount = $request->discount;
            $product->discount_price = $request->discount_price;
            $product->price = $request->price;

            $product->accept_features = $request->accept_features;
            $product->unaccept_features = $request->unaccept_features;
            $product->lead_time = $request->lead_time;
            $product->favorite_index = $request->favorite_index;

            if ($product->save()) {
                $product_detail = ProductDetail::where('product_id', $product->id)->first();
                $product_detail->product_id = $product->id;
                if ($request->button_title) {
                    $result = array_zip_combine(['title', 'href', 'target', 'style'], $request->button_title, $request->button_href, $request->button_target, $request->buton_style);
                    $product_detail->buttons = json_encode($result);
                } else {
                    $product_detail->buttons = null;
                }

                if ($request->customer_info_field) {
                    $product_detail->customer_infos = implode(',', $request->customer_info_field);
                } else {
                    $product_detail->customer_infos = null;
                }

                $product_detail->stock_type = $request->stock_type;
                //1-adetli alım açık
                $product_detail->one_piece = $request->one_piece;
                $product_detail->wp = $request->wp;

                $product_detail->content = $request->content;
                if ($product_detail->save()) {
                    $product_stock = ProductStock::where('product_id', $product->id);
                    if ($product_stock) {
                        $product_stock->delete();
                    }
                    // 1-Manuel Teslimat (sınırsız stok) 2-Herkese aynı stok teslim(sınırsız stok) 3-Kişiye Özel Stok (sınırlı stok)
                    if ($request->stock_type == 2) {
                        $product_stock = new ProductStock;
                        $product_stock->product_id = $product->id;
                        $product_stock->content = $request->stock2;
                        $product_stock->stock_type = 2;
                        $product_stock->save();
                    }
                    if ($request->stock_type == 3) {
                        if ($request->stock3) {
                            foreach (preg_split('/\r\n|[\r\n]/', $request->stock3) as $data) {
                                $product_stock = new ProductStock;
                                $product_stock->product_id = $product->id;
                                $product_stock->content = $data;
                                $product_stock->stock_type = 3;
                                $product_stock->save();
                            }
                        }
                    }
                    if ($request->option_title) {
                        $product_options = ProductOption::where('product_id', $product->id);
                        if ($product_options) {
                            $product_options->delete();
                        }
                        $options = [];
                        foreach ($request->option_title as $key => $value) {
                            $item = [
                                'product_id' => $product->id,
                                'title' => $value,
                                'price' => $request->option_price[$key],
                            ];
                            array_push($options, $item);
                        }
                        ProductOption::insert($options);
                    } else {
                        $product_options = ProductOption::where('product_id', $product->id);
                        if ($product_options) {
                            $product_options->delete();
                        }
                    }
                    return redirect()->back()->with('success', 'Ürün Güncellendi.');
                }
            }
        } else {
            return redirect()->back()->with('error', 'Ürün Bulunamadı.');
        }
    }

    public function delete(Request $request)
    {
        $product = Product::where('id', $request->id)->first();
        if ($product) {
            File::delete($product->img);
            $product_stock = ProductStock::where('product_id', $product->id)->delete();
            $product_option = ProductOption::where('product_id', $product->id)->delete();
            $product_detail = ProductDetail::where('product_id', $product->id)->delete();
            $product->delete();
            return redirect()->route('admin.products')->with('success', 'Ürün Silindi.');
        } else {
            return redirect()->route('admin.products')->with('error', 'Ürün Bulunamadı.');
        }
    }
}

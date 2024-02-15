<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\ProductOption;
use App\Models\ProductStock;
use File;
use Image;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('sortable')->get();
        return view('back.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:categories|max:255',
            'slug' => 'required',
            'img' => 'required',
        ]);
        $category = new Category;
        $category->title = $request->title;
        $category->slug = $request->slug;
        $category->description = $request->description;
        $category->sortable = $request->sortable;
        if ($request->img) {
            $path = 'uploads/categories/cat_' . time() . '.webp';
            $img = Image::make($request->img)->resize(100, 100)->encode('webp')->save($path);
            $img->destroy();
            $category->img = $path;
        }
        $category->save();
        return redirect()->back()->with('success', 'Kategori oluşturuldu.');
    }

    public function update(Request $request)
    {
        $category = Category::where('id', $request->id)->first();
        if ($category) {
            $category->title = $request->title;
            $category->slug = $request->slug;
            $category->description = $request->description;
            $category->sortable = $request->sortable;
            if ($request->img) {
                File::delete($category->img);
                $path = 'uploads/categories/cat_' . time() . '.webp';
                $img = Image::make($request->img)->resize(100, 100)->encode('webp')->save($path);
                $img->destroy();
                $category->img = $path;
            }
            $category->save();
            return redirect()->back()->with('success', 'Kategori güncellendi.');
        } else {
            return redirect()->back()->with('error', 'Kategori Bulunamadı.');
        }
    }

    //Kategori Sil
    public function delete(Request $request)
    {
        $category = Category::where('id', $request->id)->first();
        if ($category) {
            $products = Product::where('category_id', $category->id)->get();
            foreach ($products as $product) {
                $product_detail = ProductDetail::where('product_id', $product->id)->first();
                File::delete($product->img);
                if (isset($product_detail->slider)) {
                    foreach (explode(',', $product_detail->slider) as $image) {
                        File::delete($image);
                    }
                }
                $product_stock = ProductStock::where('product_id', $product->id)->delete();
                $product_option = ProductOption::where('product_id', $product->id)->delete();
                $product_detail = ProductDetail::where('product_id', $product->id)->delete();
                $product->delete();
            }
            File::delete($category->img);
            $category->delete();
            return redirect()->back()->with('success', 'Kategori ve ona bağlı ürünler silindi.');
        } else {
            return redirect()->back()->with('error', 'Kategori Bulunamadı.');
        }
    }
}

<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::orderBy('usage_count')->get();
        return view('back.coupons.index', compact('coupons'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required|unique:coupons|max:100',
        ]);
        $coupon = new Coupon;
        $coupon->code = $request->code;
        $coupon->max_count = $request->max_count;
        $coupon->usage_count = 0;
        $coupon->price = $request->price;
        $coupon->min_price = $request->min_price;
        $coupon->save();
        return redirect()->back()->with('success', 'Kupon oluşturuldu.');
    }


    public function delete(Request $request)
    {
        $coupon = Coupon::where('id', $request->id)->first();
        if ($coupon) {
            $coupon->delete();
            return redirect()->back()->with('success', 'Kupon silindi.');
        } else {
            return redirect()->back()->with('error', 'kupon Bulunamadı.');
        }
    }
}

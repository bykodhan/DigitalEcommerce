<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
class IndexController extends Controller
{
    public function index()
    {
        $orders = new Order;
        $total_amount_paid = $orders->where('order_status',2)->orWhere('order_status',1)->sum('amount_paid');
        $ok_orders_count = $orders->where('order_status',2)->count();
        $pending_stock_count = $orders->where('order_status',1)->count();
        $pending_paid = $orders->where('order_status',0)->count();
        $orders_5 = $orders->orderBy('id','desc')->paginate(5);
        return view('back.index', compact('orders_5','total_amount_paid','ok_orders_count','pending_stock_count','pending_paid'));
    }
}

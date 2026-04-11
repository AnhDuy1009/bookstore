<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->orderBy('ID', 'desc')->paginate(10);
        
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['user', 'details.book'])->findOrFail($id);
        
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
{
    
    $request->validate([
        'TrangThai' => 'required'
    ]);

    
    \Illuminate\Support\Facades\DB::table('don_hang') 
        ->where('ID', $id)
        ->update([
            'TrangThai' => $request->TrangThai
        ]);

  
    return redirect()->back()->with('success', 'Cập nhật trạng thái thành công!');
}

    public function print($id)
    {
      
        $order = Order::with('details.book')->findOrFail($id);
        return view('admin.orders.print', compact('order'));
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Book;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // --- XỬ LÝ BIỂU ĐỒ DOANH THU 7 NGÀY ---
        $days = [];
        $revenues = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $days[] = date('d/m', strtotime($date));
            
            $dailyRevenue = DB::table('don_hang')
                ->whereDate('NgayDat', $date)
                ->whereIn('TrangThai', ['PAID', 'DONE', 'Đã giao', 'Hoàn thành']) // Bổ sung chữ Hoàn thành cho chắc chắn
                ->sum('TongTien');
                
            $revenues[] = $dailyRevenue;
        }

        // --- XỬ LÝ 4 KHỐI THỐNG KÊ TRÊN CÙNG ---
        // 1. Doanh thu tháng hiện tại  
        $currentMonthRevenue = DB::table('don_hang')
            ->whereMonth('NgayDat', date('m'))
            ->whereYear('NgayDat', date('Y'))
            ->whereIn('TrangThai', ['PAID', 'DONE', 'Đã giao', 'Hoàn thành'])
            ->sum('TongTien');

        // 2. Số đơn hàng mới (Trạng thái đang xử lý) 
        $newOrdersCount = DB::table('don_hang')
            ->where('TrangThai', 'Đang xử lý')
            ->count();

        // 3. Số người dùng mới trong tháng 
        $newUsersCount = User::whereMonth('NgayTao', date('m'))->count();

        // 4. Tổng số lượng sách tồn kho 
        $totalStock = Book::sum('SoLuongTon');

        // --- XỬ LÝ BẢNG ĐƠN HÀNG GẦN ĐÂY ---
        // 5. Danh sách đơn hàng mới nhất để hiển thị bảng (Lấy 10 đơn)
        $recentOrders = Order::with('user')
            ->latest('NgayDat')
            ->take(10)
            ->get();

        return view('admin.dashboard.index', compact(
            'currentMonthRevenue', 'newOrdersCount', 'newUsersCount', 
            'totalStock', 'recentOrders', 'days', 'revenues'
        ));
    }
}
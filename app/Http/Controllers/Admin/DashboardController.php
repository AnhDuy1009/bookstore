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
        // --- 1. XỬ LÝ BIỂU ĐỒ DOANH THU 7 NGÀY GẦN NHẤT (Giữ nguyên logic fix) ---
        $days = [];
        $revenues = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $days[] = date('d/m', strtotime($date));
            
            $dailyRevenue = DB::table('don_hang')
                ->whereDate('NgayDat', $date)
                ->whereIn('TrangThai', ['PAID', 'DONE', 'Đã giao', 'Hoàn thành'])
                ->sum('TongTien');
                
            $revenues[] = $dailyRevenue;
        }

        // --- 2. XỬ LÝ 4 KHỐI THỐNG KÊ (Dữ liệu thật từ Database) ---
        
        // Tính tổng doanh thu từ trước đến nay (Tổng doanh thu thật)
        $currentMonthRevenue = DB::table('don_hang')
            ->whereIn('TrangThai', ['PAID', 'DONE', 'Đã giao', 'Hoàn thành'])
            ->sum('TongTien');

        // Đếm tổng số đơn hàng mới với trạng thái 'ChoDuyet'
        $newOrdersCount = DB::table('don_hang')
        ->where('TrangThai', 'Đang xử lý') 
        ->count();

        // Đếm tổng số người dùng có trong hệ thống
        $newUsersCount = User::count();

        // Đếm tổng số lượng đầu sách (Book::count()) - Đúng yêu cầu của bạn
        $totalStock = Book::count();

        // --- 3. XỬ LÝ BẢNG ĐƠN HÀNG GẦN ĐÂY ---
        
        // Lấy 5 đơn hàng mới nhất để hiển thị bảng nhanh
        $recentOrders = Order::with('user')
            ->latest('NgayDat')
            ->take(5)
            ->get();

        // --- 4. TRẢ DỮ LIỆU VỀ VIEW ---
        return view('admin.dashboard.index', compact(
            'currentMonthRevenue', 
            'newOrdersCount', 
            'newUsersCount', 
            'totalStock', 
            'recentOrders', 
            'days', 
            'revenues'
        ));
    }
}
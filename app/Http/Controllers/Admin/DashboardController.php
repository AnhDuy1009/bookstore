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
        // TODO: Đếm tổng số sách (Book::count())
        // TODO: Đếm tổng số đơn hàng mới (TrangThai = 'ChoDuyet')
        // TODO: Tính tổng doanh thu từ bảng don_hang
        // TODO: Lấy 5 đơn hàng mới nhất để hiển thị bảng nhanh
        


    // Lấy doanh thu 7 ngày gần nhất (code đã fix không đụng vào nha)
    // Gán giá trị giả để test giao diện (Fake Data)
    $currentMonthRevenue = 5000000; // 5 triệu
    $newOrdersCount = 12;
    $newUsersCount = 5;
    $totalStock = 150;
    
    // Tạo 1 mảng rỗng hoặc giả cho danh sách đơn hàng
    $recentOrders = [];
    $days = [];
    $revenues = [];
    for ($i = 6; $i >= 0; $i--) {
        $date = date('Y-m-d', strtotime("-$i days"));
        $days[] = date('d/m', strtotime($date));
        
        $dailyRevenue = DB::table('don_hang')
            ->whereDate('NgayDat', $date)
            ->whereIn('TrangThai', ['PAID', 'DONE'])
            ->sum('TongTien');
            
        $revenues[] = $dailyRevenue;
    }

    return view('admin.dashboard.index', compact(
        'currentMonthRevenue', 'newOrdersCount', 'newUsersCount', 
        'totalStock', 'recentOrders', 'days', 'revenues'
    ));
    }
}
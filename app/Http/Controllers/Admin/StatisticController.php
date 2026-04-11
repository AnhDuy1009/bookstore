<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\RevenueExport;
use Maatwebsite\Excel\Facades\Excel;

class StatisticController extends Controller
{
    public function index(Request $request)
    {
        // 1. Lấy ngày lọc (Mặc định từ đầu tháng đến hiện tại)
        $tu = $request->input('tu', date('Y-m-01'));
        $den = $request->input('den', date('Y-m-d'));

        // 2. Thống kê Doanh thu & Tổng đơn hàng
        $revenueData = DB::table('don_hang')
            ->where('TrangThai', 'Đã giao')
            ->whereBetween('NgayDat', [$tu . ' 00:00:00', $den . ' 23:59:59'])
            ->selectRaw('SUM(TongTien) as DoanhThu, COUNT(ID) as SoDon')
            ->first();

        // 3. Top 10 Sách bán chạy
        $bestSellers = DB::table('chi_tiet_don_hang as ct')
            ->join('sach as s', 'ct.IDSach', '=', 's.ID')
            ->join('don_hang as dh', 'ct.IDDonHang', '=', 'dh.ID')
            ->where('dh.TrangThai', 'Đã giao')
            ->select('s.TenSach', 's.GiaBan', DB::raw('SUM(ct.SoLuong) as TongBan'))
            ->groupBy('s.ID', 's.TenSach', 's.GiaBan')
            ->orderBy('TongBan', 'desc')
            ->limit(10)
            ->get();

        // 4. Khách hàng tích cực
        $topUsers = DB::table('don_hang as d')
            ->join('nguoi_dung as n', 'd.IDNguoiDung', '=', 'n.ID')
            ->where('d.TrangThai', 'Đã giao')
            ->select('n.HoTen', 'n.Email', DB::raw('COUNT(d.ID) as SoDon'), DB::raw('SUM(d.TongTien) as TongChi'))
            ->groupBy('n.ID', 'n.HoTen', 'n.Email')
            ->orderBy('SoDon', 'desc')
            ->limit(10)
            ->get();

        return view('admin.statistics.index', compact('revenueData', 'bestSellers', 'topUsers', 'tu', 'den'));
    }

    public function export(Request $request) 
    {
        $tu = $request->input('tu', date('Y-m-01'));
        $den = $request->input('den', date('Y-m-d'));
        
        return Excel::download(new RevenueExport($tu, $den), "Bao-cao-doanh-thu-{$tu}-to-{$den}.xlsx");
    }
}
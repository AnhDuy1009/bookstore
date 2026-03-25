<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RevenueExport implements FromCollection, WithHeadings, WithMapping
{
    protected $tu, $den;

    public function __construct($tu, $den) {
        $this->tu = $tu;
        $this->den = $den;
    }

    public function collection() {
        return DB::table('don_hang')
            ->where('TrangThai', 'Đã giao')
            ->whereBetween('NgayDat', [$this->tu . ' 00:00:00', $this->den . ' 23:59:59'])
            ->get();
    }

    public function headings(): array {
        return ["Mã Đơn", "Ngày Đặt", "Phương Thức", "Tổng Tiền (VNĐ)"];
    }

    public function map($order): array {
        return [
            "#" . $order->ID,
            date('d/m/Y', strtotime($order->NgayDat)),
            $order->PhuongThucThanhToan,
            number_format($order->TongTien) . " đ"
        ];
    }
}
<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function checkout()
    {
        // TODO: Kiểm tra giỏ hàng rỗng thì redirect về home
        // TODO: Hiển thị form thanh toán và danh sách món hàng cuối cùng
        return view('frontend.orders.checkout');
    }

    public function process(Request $request)
    {
        // TODO: Validate thông tin giao hàng (HoTen, SDT, DiaChi)
        // TODO: Lưu vào bảng don_hang (IDNguoiDung, TongTien, TrangThai)
        // TODO: Lưu vào bảng chi_tiet_don_hang (IDDonHang, IDSach, SoLuong, GiaBan)
        // TODO: Trừ Số_Lượng_Tồn trong bảng sach và xóa session cart
        return redirect()->route('order.success');
    }

    public function success($id)
    {
        // TODO: Hiển thị thông báo đặt hàng thành công cho ID đơn hàng này
        return view('frontend.orders.success');
    }

    public function list()
    {
        // TODO: Lấy danh sách đơn hàng của IDNguoiDung đang đăng nhập
        return view('frontend.orders.list');
    }

    public function track($id)
    {
        // TODO: Xem chi tiết trạng thái của 1 đơn hàng theo ID
        return view('frontend.orders.track');
    }

    public function cancel($id)
    {
        // TODO: Cập nhật TrangThai thành 'Đã hủy'
        // TODO: Hoàn lại Số_Lượng_Tồn cho các sách trong đơn hàng này
        return redirect()->back();
    }
}
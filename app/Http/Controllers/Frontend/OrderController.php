<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Book;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected $orderService;
    protected $paymentService;

    public function __construct(OrderService $orderService, \App\Services\PaymentService $paymentService)
    {
        $this->orderService = $orderService;
        $this->paymentService = $paymentService;
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);
        
        // Kiểm tra giỏ hàng rỗng thì redirect về home
        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        return view('frontend.orders.checkout', compact('cart'));
    }

    public function process(Request $request)
    {
        // 1. Validate thông tin giao hàng
        $request->validate([
            'HoTen' => 'required|string|max:255',
            'SDT' => 'required|numeric',
            'DiaChi' => 'required|string',
            'PhuongThucThanhToan' => 'required'
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) return redirect()->route('home');

        // Tính tổng tiền 
        $tongTien = 0;
        foreach($cart as $item) {
            $tongTien += $item['price'] * $item['quantity'];
        }

        // Phí vận chuyển cố định
        $shippingFee = 30000;

        // Xử lý Voucher (Nếu có)
        if ($request->filled('VoucherCode')) {
            $voucher = \Illuminate\Support\Facades\DB::table('vouchers')
                        ->where('ma_voucher', $request->VoucherCode)
                        ->first();
            
            if ($voucher) {
                $soTienGiam = ($tongTien * $voucher->phan_tram_giam) / 100;
                $tongTien -= $soTienGiam; 
                if ($tongTien < 0) $tongTien = 0; 
            } else {
                return back()->with('error', 'Mã giảm giá không hợp lệ hoặc đã hết hạn!');
            }
        }

        // Tổng tiền thanh toán bao gồm phí ship
        $tongTienThanhToan = $tongTien + $shippingFee;

        try {
            // 2. GỌI SERVICE TẠO ĐƠN HÀNG
            // Truyền trực tiếp session('cart') để đảm bảo dữ liệu mảng chuẩn nhất
            $order = $this->orderService->createOrder(Auth::id(), [
                'MaDonHang'      => 'DH' . time(),
                'total'          => $tongTienThanhToan,
                'shipping_fee'   => $shippingFee,
                'payment_method' => $request->PhuongThucThanhToan,
                'address'        => $request->DiaChi, // Lưu vào cột DiaChiGiaoHang qua Service
                'phone'          => $request->SDT     // Lưu vào cột SoDienThoai qua Service
            ], session('cart'));

            // 3. ĐIỀU HƯỚNG THEO PHƯƠNG THỨC THANH TOÁN
            switch ($request->PhuongThucThanhToan) {
                case 'vnpay':
                    // Đảm bảo bạn đã khai báo $paymentService trong __construct
                    $paymentUrl = $this->paymentService->createVnPayUrl($order);
                    return redirect()->away($paymentUrl);
                    
                case 'momo':
                    // Đảm bảo bạn đã khai báo $paymentService trong __construct
                    $paymentUrl = $this->paymentService->createMoMoUrl($order);
                    return redirect()->away($paymentUrl);

                case 'cod':
                default:
                    // Thanh toán khi nhận hàng: Xóa giỏ hàng và voucher
                    session()->forget(['cart', 'voucher']);
                    // Redirect về trang success (hoặc trang lịch sử đơn hàng tùy bạn)
                    return redirect()->route('order.success', $order->ID);
            }

        } catch (\Exception $e) {
            // Log lỗi để dễ debug nếu cần
            \Log::error('Lỗi đặt hàng: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra trong quá trình xử lý đơn hàng.');
        }
    }

    public function success($id)
    {
        $order = Order::findOrFail($id);
        
        return view('frontend.orders.success', [
            'order' => $order,
            'order_code' => $order->MaDonHang, 
            'method' => $order->PhuongThucThanhToan 
        ]);
    }
   public function list(\Illuminate\Http\Request $request)
    {
    $tab = $request->query('tab', 'Tất cả');

    // THAY ĐỔI: Thêm with('details.book') để lấy dữ liệu sách
    $query = \App\Models\Order::with('details.book')
                ->where('IDNguoiDung', \Illuminate\Support\Facades\Auth::id());

    if ($tab !== 'Tất cả') {
        $query->where('TrangThai', $tab);
    }

    $orders = $query->orderBy('NgayDat', 'desc')->get();

    $orders->each(function ($order) {
        $order->setAttribute('id', $order->ID);
        $order->setAttribute('created_at', $order->NgayDat);
    });

    return view('frontend.orders.list', compact('orders', 'tab'));
    }

   
    

    public function track($id)
    {
        // Xem chi tiết trạng thái và các món hàng bên trong
        $order = Order::with('details.book')->where('IDNguoiDung', Auth::id())->findOrFail($id);
        return view('frontend.orders.track', compact('order'));
    }

    public function cancel($id)
    {
        $order = Order::where('IDNguoiDung', Auth::id())->findOrFail($id);

        if ($order->TrangThai == 'Đang xử lý') {
            DB::transaction(function () use ($order) {
                // 1. Cập nhật TrangThai thành 'Đã hủy'
                $order->update(['TrangThai' => 'Đã hủy']);

                // 2. Hoàn lại Số_Lượng_Tồn cho các sách
                if ($order->details) {
                    foreach ($order->details as $item) {
                        \App\Models\Book::where('ID', $item->IDSach)->increment('SoLuongTon', $item->SoLuong);
                    }
                }
            });

            return redirect()->back()->with('success', 'Đã hủy đơn hàng thành công.');
        }

        return redirect()->back()->with('error', 'Không thể hủy đơn hàng đang giao hoặc đã hoàn thành.');
    }
}
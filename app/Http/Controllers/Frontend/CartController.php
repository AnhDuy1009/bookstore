<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CartService;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    // Hiển thị giỏ hàng
    public function index()
    {
        $cart = $this->cartService->get(); // Lấy mảng cart từ session
        $total = $this->cartService->getTotalPrice();

       return view('frontend.cart.index', compact('cart', 'total'));
    }

    // Thêm vào giỏ hàng
    public function add(Request $request, $id)
    {
        try {
            // Lấy số lượng từ form (mặc định là 1)
            $quantity = $request->input('quantity', 1); 
            
            // Gọi CartService để xử lý logic thêm vào giỏ
            $this->cartService->add($id, $quantity);

            // Nếu chạy trót lọt, quay lại trang trước và báo thành công
            return redirect()->back()->with('success', '🔔 Đã thêm sách vào giỏ hàng thành công!');
            
        } catch (\Exception $e) {
            // NẾU CÓ LỖI: Lôi cổ cái lỗi ra màn hình cho mình xem!
            dd(
                'Bắt được lỗi rồi Hương ơi:', 
                $e->getMessage(), 
                'Nằm ở dòng: ' . $e->getLine(), 
                'Trong file: ' . $e->getFile()
            );
        }
    }

    // Cập nhật số lượng
    public function update(Request $request)
    {
        // Fix: Lấy đúng 'id' từ input hidden trong form của View
        $bookId = $request->input('id'); 
        $quantity = $request->input('quantity');

        $this->cartService->update($bookId, $quantity);
        
        return redirect()->back()->with('success', 'Đã cập nhật số lượng thành công!');
    }

    // Xóa 1 sản phẩm khỏi giỏ
    public function remove($id)
    {
        $this->cartService->remove($id);
        
        return redirect()->back()->with('success', 'Đã xóa sách khỏi giỏ hàng!');
    }

    // Xóa sạch giỏ hàng
    public function clear()
    {
        $this->cartService->clear();
        
        return redirect()->back()->with('success', 'Đã làm sạch giỏ hàng!');
    }
}
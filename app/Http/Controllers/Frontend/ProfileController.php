<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * TODO 1: Hiển thị trang thông tin cá nhân (Dashboard User)
     * Nhiệm vụ:
     * - Lấy thông tin user hiện tại qua Auth::user().
     * - Có thể lấy thêm lịch sử 5 đơn hàng gần nhất để hiển thị tóm tắt.
     */
    public function index()
    {
        $user = Auth::user();
        // $recentOrders = $user->orders()->latest()->take(5)->get();

        return view('frontend.profile.index', compact('user'));
    }

    /**
     * TODO 2: Hiển thị form chỉnh sửa thông tin
     * Nhiệm vụ:
     * - Trả về view 'frontend.profile.edit' kèm dữ liệu user hiện tại.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('frontend.profile.edit', compact('user'));
    }

    /**
     * TODO 3: Xử lý cập nhật thông tin (Họ tên, Số điện thoại, Địa chỉ)
     * Nhiệm vụ:
     * - Validate dữ liệu đầu vào (tên không trống, phone đúng định dạng).
     * - Cập nhật vào DB và thông báo thành công.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // 1. TODO: Validate dữ liệu (Ví dụ: 'name' => 'required|string|max:255')
        
        // 2. TODO: Cập nhật thông tin (Trừ email và password thường sẽ làm riêng)
        // $user->update($request->only('name', 'phone', 'address'));

        return redirect()->route('profile.index')->with('success', 'Cập nhật hồ sơ thành công!');
    }

    /**
     * TODO 4: Hiển thị form đổi mật khẩu
     */
    public function password()
    {
        return view('frontend.profile.change-password');
    }

    /**
     * TODO 5: Xử lý đổi mật khẩu (Nên có thêm hàm này)
     * Nhiệm vụ:
     * - Kiểm tra mật khẩu cũ có khớp không (Hash::check).
     * - Kiểm tra mật khẩu mới và xác nhận mật khẩu có khớp nhau không.
     */
    public function updatePassword(Request $request)
    {
        // 1. TODO: Validate (mật khẩu mới tối thiểu 8 ký tự)
        
        // 2. TODO: Logic kiểm tra mật khẩu cũ và lưu mật khẩu mới đã Hash
        
        return redirect()->back()->with('success', 'Đổi mật khẩu thành công!');
    }
}
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
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Lấy 5 đơn hàng gần nhất dựa trên bảng 'don_hang' và cột 'IDNguoiDung'
        // Lưu ý: Bạn cần định nghĩa relationship 'orders' trong Model User
        $recentOrders = $user->orders()->latest('NgayDat')->take(5)->get();
        $order_count = $user->orders()->count();
        $total_spent = $user->orders()
                        ->where('TrangThai', 'Đã giao')
                        ->sum('TongTien');
        return view('frontend.profile.index', compact('user', 'recentOrders', 'order_count', 'total_spent'));
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
    /** @var \App\Models\User $user */
    $user = Auth::user();

    // 1. Validate dữ liệu bao gồm cả file ảnh (AnhDaiDien)
    $request->validate([
        'HoTen'       => 'required|string|max:255',
        'SoDienThoai' => 'nullable|numeric|digits_between:10,11',
        'DiaChi'      => 'nullable|string|max:500',
        'AnhDaiDien'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate định dạng ảnh
    ], [
        'HoTen.required' => 'Họ tên không được để trống.',
        'SoDienThoai.numeric' => 'Số điện thoại phải là chữ số.',
        'AnhDaiDien.image' => 'File tải lên phải là hình ảnh.',
    ]);

    // Lấy dữ liệu văn bản từ request
    $data = $request->only(['HoTen', 'SoDienThoai', 'DiaChi']);

    // 2. Xử lý Logic Upload Ảnh
    if ($request->hasFile('AnhDaiDien')) {
        // Lưu file vào storage/app/public/avatars
        $path = $request->file('AnhDaiDien')->store('avatars', 'public');
        
        // Thêm đường dẫn file (ví dụ: avatars/abc.jpg) vào mảng dữ liệu cập nhật
        $data['AnhDaiDien'] = $path;
        
        // (Tùy chọn) Xóa ảnh cũ nếu có để tránh đầy bộ nhớ server
        if ($user->AnhDaiDien && \Storage::disk('public')->exists($user->AnhDaiDien)) {
            \Storage::disk('public')->delete($user->AnhDaiDien);
        }
    }

    // 3. Thực hiện cập nhật vào bảng 'nguoi_dung'
    $user->update($data);

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
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 1. Validate mật khẩu mới
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed', // Yêu cầu trường new_password_confirmation
        ], [
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự.',
            'new_password.confirmed' => 'Xác nhận mật khẩu mới không khớp.',
        ]);

        // 2. Kiểm tra mật khẩu cũ (cột 'MatKhau' trong DB)
        if (!Hash::check($request->old_password, $user->MatKhau)) {
            return redirect()->back()->withErrors(['old_password' => 'Mật khẩu cũ không chính xác.']);
        }

        // 3. Lưu mật khẩu mới đã Hash vào cột 'MatKhau'
        $user->update([
            'MatKhau' => Hash::make($request->new_password)
        ]);

        //return redirect()->route('profile.index')->with('success', 'Đổi mật khẩu thành công!');
    
        return redirect()->back()->with('success', 'Đổi mật khẩu thành công!');
    }
}
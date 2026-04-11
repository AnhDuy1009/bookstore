<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Hiển thị danh sách người dùng
     */
    public function index(Request $request)
    {
        // Tiếp nhận từ khóa tìm kiếm 'q' từ Request
        $q = $request->query('q');

        // Truy vấn bảng người dùng tìm theo HoTen hoặc Email
        $users = User::when($q, function($query) use ($q) {
            return $query->where('HoTen', 'LIKE', "%$q%")
                         ->orWhere('Email', 'LIKE', "%$q%");
        })
        ->orderBy('ID', 'DESC') // Để người mới nhất lên đầu cho dễ quản lý
        ->paginate(10); 

        // Trả về view 'admin.users.index' kèm dữ liệu
        return view('admin.users.index', compact('users', 'q'));
    }

    /**
     * Xem thông tin chi tiết
     */
    public function show($id)
    {
        // Sử dụng findOrFail để tìm User theo ID hoặc trả về 404
        $user = User::findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    /**
     * Hiển thị form chỉnh sửa
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Cập nhật thông tin
     */
    public function update(Request $request, $id)
    {
     
        $request->validate([
            'HoTen' => 'required|max:255',
            'Email' => 'required|email|unique:nguoi_dung,Email,' . $id . ',ID',
        ]);

     
        $vaiTroMoi = ($request->Role == 'admin') ? 'admin' : 'user';

        
        \Illuminate\Support\Facades\DB::table('nguoi_dung')
            ->where('ID', $id)
            ->update([
                'HoTen'       => $request->HoTen,
                'Email'       => $request->Email,
                'SoDienThoai' => $request->SoDienThoai, 
                'DiaChi'      => $request->DiaChi,     
                'VaiTro'      => $vaiTroMoi,          
                'TrangThai'   => $request->TrangThai,   
            ]);

        return redirect()->route('admin.users.show', $id)->with('success', 'Cập nhật thành công!');
    }

    /**
     * Xóa người dùng
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // KIỂM TRA BẢO MẬT: Không được tự xóa chính mình
        if ($user->ID == Auth::id()) {
            return redirect()->route('admin.users.index')->with('error', 'Bạn không thể tự xóa tài khoản quản trị đang đăng nhập!');
        }
        
        $user->delete();

        // Trả về trang danh sách kèm thông báo thành công
        return redirect()->route('admin.users.index')->with('success', 'Đã xóa người dùng khỏi hệ thống thành công!');
    }

    /**
     * Hiển thị form thêm người dùng/admin mới
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Lưu người dùng mới vào database
     */
    public function store(Request $request)
    {
        $request->validate([
            'HoTen' => 'required|max:255',
            'Email' => 'required|email|unique:nguoi_dung,Email',
            'MatKhau' => 'required|min:6',
        ], [
            'HoTen.required' => 'Vui lòng nhập họ tên.',
            'Email.unique' => 'Email này đã tồn tại trên hệ thống.',
            'MatKhau.min' => 'Mật khẩu phải có ít nhất 6 ký tự.'
        ]);

        $user = new User();
        $user->HoTen = $request->HoTen;
        $user->Email = $request->Email;
        $user->SoDienThoai = $request->SoDienThoai;
        $user->DiaChi = $request->DiaChi;
        $user->MatKhau = bcrypt($request->MatKhau); 
        $user->Role = $request->Role ?? 'user';
        
        // Đồng bộ MaVaiTro khi tạo mới
        if ($request->Role == 'admin') {
            $user->MaVaiTro = 1;
        } else {
            $user->MaVaiTro = 0;
        }
        
        $user->TrangThai = 'active';
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Thêm người dùng mới thành công!');
    }
}
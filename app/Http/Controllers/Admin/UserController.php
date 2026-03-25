<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Hiển thị danh sách người dùng (Tương ứng list.php)
     */
    public function index(Request $request)
    {
        // TODO: Tiếp nhận từ khóa tìm kiếm 'q' từ Request
        $q = $request->query('q');

        // TODO: Truy vấn bảng 'nguoi_dung' tìm theo HoTen hoặc Email
        $users = User::when($q, function($query) use ($q) {
            return $query->where('HoTen', 'LIKE', "%$q%")
                         ->orWhere('Email', 'LIKE', "%$q%");
        })
        ->orderBy('ID', 'ASC') // Sắp xếp theo ID tăng dần
        ->paginate(10); // TODO: Thực hiện phân trang 10 dòng/trang

        // TODO: Trả về view 'admin.users.index' kèm dữ liệu
        return view('admin.users.index', compact('users', 'q'));
    }

    /**
     * Xem thông tin chi tiết (Tương ứng detail.php)
     */
    public function show($id)
    {
        // TODO: Sử dụng findOrFail để tìm User theo ID hoặc trả về 404
        $user = User::findOrFail($id);

        // TODO: Trả về view 'admin.users.show'
        return view('admin.users.show', compact('user'));
    }

    /**
     * Hiển thị form chỉnh sửa (Tương ứng edit.php - phần hiển thị)
     */
    public function edit($id)
    {
        // TODO: Lấy thông tin User cần sửa
        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Cập nhật thông tin (Tương ứng edit.php - phần xử lý POST)
     */
    public function update(Request $request, $id)
    {
        // TODO: Tìm User cần cập nhật
        $user = User::findOrFail($id);

        // TODO: Thực hiện Validation (Bắt buộc HoTen, Email; Email phải đúng định dạng)
        $request->validate([
            'HoTen' => 'required|max:255',
            'Email' => 'required|email|unique:nguoi_dung,Email,' . $id . ',ID',
        ], [
            'HoTen.required' => 'Họ tên không được để trống!',
            'Email.unique' => 'Email này đã được sử dụng bởi người dùng khác.',
        ]);

        // TODO: Cập nhật dữ liệu từ Request vào Database
        $user->update($request->all());

        // TODO: Redirect về trang chi tiết kèm thông báo thành công
        return redirect()->route('users.show', $id)->with('success', 'Cập nhật thông tin người dùng thành công!');
    }

    /**
     * Xóa người dùng (Tương ứng delete.php)
     */
    public function destroy($id)
    {
        // TODO: Tìm và thực hiện xóa User
        $user = User::findOrFail($id);
        
        // TODO: Cần kiểm tra nếu User là Admin chính thì không được tự xóa (Option)
        
        $user->delete();

        // TODO: Trả về trang danh sách kèm thông báo thành công
        return redirect()->route('users.index')->with('success', 'Đã xóa người dùng khỏi hệ thống!');
    }
}
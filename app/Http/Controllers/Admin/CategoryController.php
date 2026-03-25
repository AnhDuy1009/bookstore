<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // TODO: Lấy toàn bộ danh sách thể loại (Category::all())
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        // TODO: Validate 'TenTheLoai' không được trùng trong bảng 'the_loai'
        // TODO: Category::create($request->only('TenTheLoai'));
        // TODO: Trả về back() kèm thông báo thành công
        // Trả về back() kèm thông báo thành công
        return redirect()->route('categories.index')->with('success', 'Thêm danh mục mới thành công!');
    }

    public function update(Request $request, $id)
    {
        // TODO: Tìm Category theo ID và cập nhật TenTheLoai mới
        return redirect()->route('categories.index')->with('success', 'Cập nhật danh mục thành công!');
    }
    

    public function destroy($id)
    {
        // TODO: Kiểm tra ràng buộc: Nếu thể loại này đang có sách thì KHÔNG ĐƯỢC XÓA
        // TODO: Trả về thông báo lỗi nếu còn sách, ngược lại cho phép xóa
        if ($category->books()->count() > 0) {
            // Trả về thông báo lỗi nếu còn sách
            return redirect()->route('categories.index')->with('error', 'Không thể xóa vì danh mục này đang chứa sách!');
        }
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Đã xóa danh mục thành công!');
    }
}
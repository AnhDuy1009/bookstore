<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
       
        $categories = Category::orderBy('ID', 'desc')->paginate(10);
        
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
    
        $category = new Category();
        
      
        if ($request->has('TenDanhMuc')) {
            $category->TenDanhMuc = $request->input('TenDanhMuc');
        } elseif ($request->has('TenTheLoai')) {
            $category->TenTheLoai = $request->input('TenTheLoai');
        }

        $category->save();

        
        return redirect()->route('admin.categories.index')->with('success', 'Thêm danh mục mới thành công!');
    }

    public function update(Request $request, $id)
    {
      
        $category = Category::findOrFail($id);
        
        // Cập nhật tên danh mục
        if ($request->has('TenDanhMuc')) {
            $category->TenDanhMuc = $request->input('TenDanhMuc');
        } elseif ($request->has('TenTheLoai')) {
            $category->TenTheLoai = $request->input('TenTheLoai');
        }

        // Nếu có cập nhật trạng thái
        if ($request->has('TrangThai')) {
            $category->TrangThai = $request->input('TrangThai');
        }

        $category->save();

       
        return redirect()->route('admin.categories.index')->with('success', 'Cập nhật danh mục thành công!');
    }
    

    public function destroy($id)
    {
        
        $category = Category::findOrFail($id);

        // Kiểm tra ràng buộc: Nếu thể loại này đang có sách thì KHÔNG ĐƯỢC XÓA
        if ($category->books()->count() > 0) {
            // Trả về thông báo lỗi nếu còn sách
            return redirect()->route('admin.categories.index')->with('error', 'Không thể xóa vì danh mục này đang chứa sách!');
        }
        
        $category->delete();
        
       
        return redirect()->route('admin.categories.index')->with('success', 'Đã xóa danh mục thành công!');
    }
    // Hàm hiển thị form Thêm mới
    public function create()
    {
        return view('admin.categories.edit');
    }

    // Hàm hiển thị form Chỉnh sửa
    public function edit($id)
    {
        // Tìm danh mục theo ID để đổ dữ liệu cũ ra form
        $category = \App\Models\Category::findOrFail($id);
        
        return view('admin.categories.edit', compact('category'));
    }
}
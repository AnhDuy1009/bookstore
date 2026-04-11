<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Author; // Đã thêm Model Author
use Illuminate\Support\Facades\Storage; // Hỗ trợ xóa ảnh cũ

class AuthorController extends Controller
{
    public function index()
    {
        // Lấy danh sách tác giả phân trang 10 mục/trang, sắp xếp mới nhất lên đầu
        $authors = Author::orderBy('ID', 'DESC')->paginate(10);

        // Truyền biến $authors ra view
        return view('admin.authors.index', compact('authors'));
    }

    public function create()
    {
        return view('admin.authors.create');
    }

    public function store(Request $request)
    {
        // 1. Validate dữ liệu
        $request->validate([
            'TenTacGia' => 'required|max:255',
            'HinhAnh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'TenTacGia.required' => 'Bạn vui lòng nhập tên tác giả.'
        ]);

        $data = $request->all();

        // 2. Xử lý lưu HinhAnh (Upload file)
        if ($request->hasFile('HinhAnh')) {
            $path = $request->file('HinhAnh')->store('authors', 'public');
            $data['HinhAnh'] = $path;
        }

        // 3. Tạo mới tác giả
        Author::create($data);

        // Redirect về index với route có admin.
        return redirect()->route('admin.authors.index')->with('success', 'Thêm tác giả mới thành công!');
    }

    public function edit($id)
    {
        // Tìm Author theo $id
        $author = Author::findOrFail($id);

        return view('admin.authors.edit', compact('author'));
    }

    public function update(Request $request, $id)
    {
        $author = Author::findOrFail($id);

        // 1. Validate
        $request->validate([
            'TenTacGia' => 'required|max:255',
            'HinhAnh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        // 2. Nếu có ảnh mới, hãy xóa ảnh cũ trong storage trước khi lưu ảnh mới
        if ($request->hasFile('HinhAnh')) {
            if ($author->HinhAnh && Storage::disk('public')->exists($author->HinhAnh)) {
                Storage::disk('public')->delete($author->HinhAnh);
            }
            $path = $request->file('HinhAnh')->store('authors', 'public');
            $data['HinhAnh'] = $path;
        }

        $author->update($data);

        return redirect()->route('admin.authors.index')->with('success', 'Cập nhật thông tin tác giả thành công!');
    }

    public function destroy($id)
    {
        $author = Author::findOrFail($id);

        // 3. Kiểm tra ràng buộc: Nếu tác giả đang có sách thì KHÔNG ĐƯỢC XÓA

        if($author->books()->count() > 0) {
            return back()->with('error', 'Không thể xóa tác giả này vì đang có sách trong hệ thống!');
        }

        // Xóa ảnh trước khi xóa bản ghi
        if ($author->HinhAnh && Storage::disk('public')->exists($author->HinhAnh)) {
            Storage::disk('public')->delete($author->HinhAnh);
        }

        $author->delete();

        return redirect()->route('admin.authors.index')->with('success', 'Đã xóa tác giả thành công!');
    }
}
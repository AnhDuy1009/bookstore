<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AuthorController extends Controller
{
    public function index()
    {
        // TODO: Lấy danh sách tác giả phân trang 10 mục/trang
        $authors = Author::orderBy('ID', 'DESC')->paginate(10);

        // TODO: Truyền biến $authors ra view 'admin.authors.index'
        return view('admin.authors.index', compact('authors'));
    }

    public function create()
    {
        return view('admin.authors.create');
    }

    public function store(Request $request)
    {
        // TODO: Validate 'TenTacGia' là bắt buộc
        // TODO: Xử lý lưu 'HinhAnh' (Có thể là URL hoặc Upload file qua UploadService)
        // TODO: Author::create($request->all());

        // TODO: Redirect về index với thông báo thành công
        return redirect()->route('authors.index')->with('success', 'Thêm tác giả mới thành công!');
    }

    public function edit($id)
    {
        // TODO: Tìm Author theo $id (findOrFail)
        $author = Author::findOrFail($id);

        return view('admin.authors.edit', compact('author'));
    }

    public function update(Request $request, $id)
    {
        // TODO: Cập nhật thông tin tác giả
        // TODO: Nếu có ảnh mới, hãy xóa ảnh cũ trong storage trước khi lưu ảnh mới

        return redirect()->route('authors.index')->with('success', 'Cập nhật thông tin tác giả thành công!');
    }

    public function destroy($id)
    {
        $author = Author::findOrFail($id);

        // TODO: Kiểm tra $author->books()->count()
        // TODO: Nếu > 0 thì không cho xóa (vì tác giả đang có sách), trả về thông báo lỗi
        
        // Giả sử logic kiểm tra:
        // if($author->books()->count() > 0) {
        //    return back()->with('error', 'Không thể xóa tác giả này vì đang có sách trong hệ thống!');
        // }

        // TODO: Nếu = 0 thì tiến hành xóa và redirect về index
        $author->delete();

        return redirect()->route('authors.index')->with('success', 'Đã xóa tác giả thành công!');
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookController extends Controller
{
    public function index()
    {
        // TODO: Lấy danh sách sách kèm thông tin Author và Category
       $books = \App\Models\Book::orderBy('ID', 'desc')->paginate(10);

        // Truyền biến $books sang view admin.books.index
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        $authors = \App\Models\Author::all(); 
        $categories = \App\Models\Category::all();

        return view('admin.books.create', compact('authors', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'integer', 'exists:danh_muc,ID'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'quantity' => ['nullable', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ], [
            'title.required' => 'Tên sách không được để trống.',
            'author.required' => 'Tác giả không được để trống.',
            'category_id.required' => 'Vui lòng chọn danh mục.',
            'category_id.exists' => 'Danh mục không hợp lệ.',
            'price.numeric' => 'Giá bán phải là số.',
            'price.min' => 'Giá bán không được nhỏ hơn 0.',
            'quantity.integer' => 'Số lượng phải là số nguyên.',
            'quantity.min' => 'Số lượng không được nhỏ hơn 0.',
            'image.image' => 'File tải lên phải là hình ảnh.',
            'image.mimes' => 'Ảnh bìa chỉ hỗ trợ jpeg, png, jpg, webp.',
            'image.max' => 'Ảnh bìa không được vượt quá 2MB.',
        ]);

        $authorName = trim($validated['author']);
        $author = Author::firstOrCreate(['TenTacGia' => $authorName]);

        $bookData = [
            'TenSach' => $validated['title'],
            'MoTa' => $validated['description'] ?? null,
            'GiaBan' => $validated['price'] ?? 0,
            'SoLuongTon' => $validated['quantity'] ?? 0,
            'IDDanhMuc' => $validated['category_id'],
            'IDTacGia' => $author->ID,
            'TrangThai' => 'Active',
        ];

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileName = time() . '_' . Str::random(12) . '.' . $extension;
            $storedPath = $request->file('image')->storeAs('books', $fileName, 'public');
            $bookData['Link_image'] = $storedPath;
        }

        Book::create($bookData);

        return redirect()->route('admin.books.index')->with('success', 'Thêm sách mới thành công!');
    }

    public function edit($id)
    {
        $book = \App\Models\Book::findOrFail($id);

        
        $authors = \App\Models\Author::all(); 
        $categories = \App\Models\Category::all();

        return view('admin.books.edit', compact('book', 'authors', 'categories'));
    }

    public function update(Request $request, $id)
    {
        // 1. Tìm cuốn sách trong Database
        $book = \App\Models\Book::findOrFail($id);

        $request->validate([
            'TenSach' => ['required', 'string', 'max:255'],
            'GiaBan' => ['nullable', 'numeric', 'min:0'],
            'Anh_Bia_File' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ], [
            'TenSach.required' => 'Tên sách không được để trống.',
            'GiaBan.numeric' => 'Giá bán phải là số.',
            'GiaBan.min' => 'Giá bán không được nhỏ hơn 0.',
            'Anh_Bia_File.image' => 'File tải lên phải là hình ảnh.',
            'Anh_Bia_File.mimes' => 'Ảnh bìa chỉ hỗ trợ jpeg, png, jpg, webp.',
            'Anh_Bia_File.max' => 'Ảnh bìa không được vượt quá 2MB.',
        ]);

        // 2. Cập nhật dữ liệu từ form gửi lên (Lấy theo thuộc tính name="..." trong file HTML)
        if ($request->has('TenSach')) $book->TenSach = $request->input('TenSach');
        if ($request->has('GiaBan')) $book->GiaBan = $request->input('GiaBan');
        if ($request->has('TrangThai')) $book->TrangThai = $request->input('TrangThai');
        if ($request->has('MoTa')) $book->MoTa = $request->input('MoTa');

        if ($request->hasFile('Anh_Bia_File') && $request->file('Anh_Bia_File')->isValid()) {
            $oldImagePath = null;
            if (!empty($book->Link_image) && $book->Link_image !== 'no-image.jpg') {
                $oldImagePath = str_replace(['storage/', 'public/'], '', $book->Link_image);
            }

            $extension = $request->file('Anh_Bia_File')->getClientOriginalExtension();
            $fileName = time() . '_' . Str::random(12) . '.' . $extension;
            $storedPath = $request->file('Anh_Bia_File')->storeAs('books', $fileName, 'public');
            $book->Link_image = $storedPath;

            if (!empty($oldImagePath) && Storage::disk('public')->exists($oldImagePath)) {
                Storage::disk('public')->delete($oldImagePath);
            }
        }

        // 3. Lệnh quan trọng nhất: Lưu đè xuống Database
        $book->save();

        // 4. Trở về trang quản lý và báo thành công
        return redirect()->route('admin.books.index')->with('success', 'Cập nhật sách thành công!');
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        $hasOrderItems = OrderItem::where('IDSach', $book->ID)->exists();
        if ($hasOrderItems) {
            return redirect()
                ->route('admin.books.index')
                ->with('error', 'Không thể xóa sách vì sách đã phát sinh trong đơn hàng.');
        }

        if (!empty($book->Link_image) && $book->Link_image !== 'no-image.jpg') {
            $imagePath = str_replace(['storage/', 'public/'], '', $book->Link_image);

            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
        }

        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Đã xóa sách khỏi hệ thống!');
    }
}
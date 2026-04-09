<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
{
    $book_moi = Book::orderBy('ID', 'desc')->take(8)->get();
    $book_ban_chay = Book::orderBy('LuotBan', 'desc')->take(8)->get();
    $the_loai = Category::where('TrangThai', 'Active')->get();

    return view('frontend.home.index', compact('book_moi', 'book_ban_chay', 'the_loai'));
}
    
        
}
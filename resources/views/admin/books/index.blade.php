@extends('layouts.admin')
@section('title', 'Quản lý kho sách')

@section('content')
<div class="card border-0 shadow-sm p-4">
    <div class="d-flex justify-content-between mb-3">
        <h4 class="fw-bold">Danh sách sách</h4>
        <a href="{{ route('admin.books.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Thêm sách mới</a>
    </div>
    
    <table class="table table-hover">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Tên sách</th>
                <th>Giá</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($books as $book)
            <tr>
                <td>{{ $book->id }}</td>
                <td>{{ $book->TenSach }}</td>
                <td>{{ number_format($book->Gia) }}đ</td>
                <td>
                    <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-sm btn-info text-white"><i class="fas fa-edit"></i></a>
                    </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
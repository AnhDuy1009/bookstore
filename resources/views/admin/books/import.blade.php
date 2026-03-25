@extends('layouts.admin')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <h1>NHẬP DỮ LIỆU TỪ CSV</h1>
    </div>

    <div class="admin-content">
        <div class="form-card">
            <div style="margin-bottom: 20px;">
                <label style="font-weight: 800; display: block; margin-bottom: 10px;">Cấu trúc file mẫu:</label>
                <code>title, author, price, stock, category_id, description</code>
            </div>

            <form action="{{ route('books.import.post') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Chọn file CSV của bạn</label>
                    <input type="file" name="csv_file" accept=".csv" required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Bắt đầu nhập dữ liệu</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
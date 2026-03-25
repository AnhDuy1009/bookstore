@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Thiết lập tài khoản</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="text-center mb-4">
                            <label for="avatar_input" style="cursor: pointer;">
                                <img src="{{ $user->AnhDaiDien ?? '/images/default-avatar.png' }}" 
                                     class="rounded-circle shadow-sm border" id="avatar_preview"
                                     style="width: 100px; height: 100px; object-fit: cover;">
                                <div class="mt-2 text-primary small">Thay đổi ảnh đại diện</div>
                            </label>
                            <input type="file" name="avatar" id="avatar_input" class="d-none" onchange="previewImage(this)">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Họ và tên</label>
                            <input type="text" name="fullname" class="form-control" value="{{ $user->HoTen }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Số điện thoại</label>
                            <input type="text" name="phone" class="form-control" value="{{ $user->SoDienThoai }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Địa chỉ</label>
                            <textarea name="address" class="form-control" rows="3">{{ $user->DiaChi }}</textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">Lưu thay đổi</button>
                            <a href="{{ route('profile.index') }}" class="btn btn-light">Hủy bỏ</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatar_preview').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
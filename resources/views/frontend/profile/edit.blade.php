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
                        
                        <div class="row mb-4 align-items-center">
                            <label class="col-sm-3 col-form-label fw-bold">Ảnh đại diện</label>
                            <div class="col-sm-9">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ $user->AnhDaiDien ? asset('storage/' . $user->AnhDaiDien) : asset('images/default-avatar.png') }}" 
     class="rounded-circle shadow" 
     style="width: 120px; height: 120px; object-fit: cover;">
                                    <div>
                                        <input type="file" name="AnhDaiDien" class="form-control form-control-sm" onchange="previewImage(this)">
                                        <small class="text-muted d-block mt-1">Định dạng: JPG, PNG. Tối đa 2MB.</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label fw-bold">Họ và tên</label>
                            <div class="col-sm-9">
                                <input type="text" name="HoTen" class="form-control @error('HoTen') is-invalid @enderror" 
                                       value="{{ old('HoTen', $user->HoTen) }}">
                                @error('HoTen') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label fw-bold">Số điện thoại</label>
                            <div class="col-sm-9">
                                <input type="text" name="SoDienThoai" class="form-control @error('SoDienThoai') is-invalid @enderror" 
                                       value="{{ old('SoDienThoai', $user->SoDienThoai) }}">
                                @error('SoDienThoai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label class="col-sm-3 col-form-label fw-bold">Địa chỉ</label>
                            <div class="col-sm-9">
                                <textarea name="DiaChi" class="form-control @error('DiaChi') is-invalid @enderror" 
                                          rows="3">{{ old('DiaChi', $user->DiaChi) }}</textarea>
                                @error('DiaChi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-9 offset-sm-3">
                                <button type="submit" class="btn btn-primary px-4">Lưu thay đổi</button>
                                <a href="{{ route('profile.index') }}" class="btn btn-link text-decoration-none">Hủy bỏ</a>
                            </div>
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
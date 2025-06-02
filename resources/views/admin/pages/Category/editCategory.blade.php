@extends('admin.layouts.main')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Chỉnh sửa danh mục</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Chỉnh sửa danh mục</li>
            </ol>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Lỗi!</strong> Vui lòng kiểm tra lại các thông tin sau:
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-edit me-1"></i>
                    Chỉnh sửa danh mục
                </div>
                <div class="card-body">
                    <form action="{{ route('categories.update', $category->id) }}" method="POST"
                        enctype="multipart/form-data" id="update-category-form">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Tên danh mục</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $category->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="ParentID" class="form-label">Danh mục cha</label>
                            <select name="ParentID" id="ParentID"
                                class="form-control @error('ParentID') is-invalid @enderror">
                                <option value="">Không có danh mục cha</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ old('ParentID', $category->ParentID) == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('ParentID')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="thumbnail" class="form-label">Ảnh danh mục</label>
                            <input type="file" name="thumbnail" id="thumbnail"
                                class="form-control @error('thumbnail') is-invalid @enderror" accept="image/*">
                            @error('thumbnail')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="mt-2" id="thumbnail-preview">
                                @if ($category->thumbnail)
                                    <img src="{{ asset($category->thumbnail) }}" alt="Current Thumbnail"
                                        style="width: 150px; height: 150px; object-fit: contain;">
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                            <a href="{{ route('listCategory') }}" class="btn btn-secondary ms-2">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // Preview ảnh thumbnail
            $('#thumbnail').on('change', function(e) {
                const preview = $('#thumbnail-preview');
                preview.empty();
                const file = e.target.files[0];
                if (file && file.type.match('image.*')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = $('<img>').attr('src', e.target.result)
                            .css({
                                'width': '150px',
                                'height': '150px',
                                'object-fit': 'contain',
                                'margin': '5px',
                                'border': '2px solid blue'
                            })
                            .attr('alt', 'Thumbnail Preview');
                        preview.append(img);
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Xác nhận trước khi gửi form
            $('#update-category-form').on('submit', function(event) {
                event.preventDefault();
                Swal.fire({
                    title: 'Bạn có chắc không?',
                    text: "Bạn có muốn lưu các thay đổi này không?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Có, lưu!',
                    cancelButtonText: 'Hủy'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });

            // Hiển thị thông báo thành công nếu có
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'OK',
                    timer: 3000,
                    timerProgressBar: true,
                });
            @endif
        });
    </script>
@endsection

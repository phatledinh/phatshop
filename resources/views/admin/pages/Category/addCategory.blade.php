@extends('admin.layouts.main')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Thêm danh mục</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Thêm danh mục</li>
        </ol>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-header">Thêm danh mục</div>
            <div class="card-body">
                <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Tên danh mục</label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="ParentID" class="form-label">Danh mục cha</label>
                        <select name="ParentID" id="ParentID" class="form-control @error('ParentID') is-invalid @enderror">
                            <option value="">Không có danh mục cha</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('ParentID') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
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
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Thêm danh mục</button>
                        <a href="{{ route('admin') }}" class="btn btn-secondary">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Tích hợp SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Tích hợp jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        .image-preview img {
            object-fit: cover;
            border-radius: 5px;
        }

        .image-preview img.thumbnail-preview {
            border: 2px solid blue;
            width: 150px;
        }

        .image-preview div {
            position: relative;
            margin: 5px;
        }
    </style>

    <script>
        $(document).ready(function() {
            // Hiển thị SweetAlert2 nếu có session success
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'OK'
                });
            @endif

            // Xem trước ảnh
            const previewContainer = $(
                '<div class="image-preview mt-2" style="display: flex; flex-wrap: wrap;"></div>');
            $('#thumbnail').after(previewContainer);

            function addRemoveButton(img) {
                const removeBtn = $('<button>').text('X')
                    .css({
                        'position': 'absolute',
                        'top': '0',
                        'right': '0',
                        'background': 'red',
                        'color': 'white',
                        'border': 'none',
                        'cursor': 'pointer',
                        'padding': '2px 6px'
                    })
                    .on('click', function() {
                        img.parent().remove();
                        $('#thumbnail').val(''); // Clear the file input
                    });
                const wrapper = $('<div>').css('position', 'relative').append(img, removeBtn);
                return wrapper;
            }

            $('#thumbnail').on('change', function(e) {
                const file = e.target.files[0];
                previewContainer.find('.thumbnail-preview').remove();
                if (file && file.type.match('image.*')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = $('<img>').attr('src', e.target.result)
                            .addClass('thumbnail-preview')
                            .css({
                                'width': '150px',
                                'margin': '5px',
                                'border': '2px solid blue'
                            })
                            .attr('title', 'Ảnh danh mục');
                        previewContainer.prepend(addRemoveButton(img));
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endsection

@extends('admin.layouts.main')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Thêm sản phẩm</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Thêm sản phẩm</li>
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
            <div class="card-header">Thêm sản phẩm</div>
            <div class="card-body">
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="product_name" class="form-label">Tên sản phẩm</label>
                            <input type="text" name="product_name" id="product_name"
                                class="form-control @error('product_name') is-invalid @enderror"
                                value="{{ old('product_name') }}" required>
                            @error('product_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="category_id" class="form-label">Danh mục</label>
                            <select name="category_id" id="category_id"
                                class="form-control @error('category_id') is-invalid @enderror" required>
                                <option value="">Chọn danh mục</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="brand_id" class="form-label">Hãng</label>
                        <select name="brand_id" id="brand_id" class="form-control @error('brand_id') is-invalid @enderror"
                            required>
                            <option value="">Chọn hãng</option>
                        </select>
                        @error('brand_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="price_new" class="form-label">Giá mới</label>
                            <input type="number" name="price_new" id="price_new"
                                class="form-control @error('price_new') is-invalid @enderror"
                                value="{{ old('price_new') }}" required>
                            @error('price_new')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="price_old" class="form-label">Giá cũ (nếu có)</label>
                            <input type="number" name="price_old" id="price_old"
                                class="form-control @error('price_old') is-invalid @enderror"
                                value="{{ old('price_old') }}">
                            @error('price_old')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="stock" class="form-label">Trong kho</label>
                        <input type="number" name="stock" id="stock"
                            class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', 0) }}"
                            min="0" required>
                        @error('stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="thumbnail" class="form-label">Ảnh sản phẩm</label>
                        <input type="file" name="thumbnail" id="thumbnail"
                            class="form-control @error('thumbnail') is-invalid @enderror" accept="image/*">
                        @error('thumbnail')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="related_images" class="form-label">Ảnh sản phẩm liên quan</label>
                        <input type="file" name="related_images[]" id="related_images"
                            class="form-control @error('related_images.*') is-invalid @enderror" accept="image/*" multiple>
                        @error('related_images.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="suggestion" class="form-label">Gợi ý</label>
                        <select name="suggestion" id="suggestion"
                            class="form-control @error('suggestion') is-invalid @enderror" required>
                            <option value="0" {{ old('suggestion') == 0 ? 'selected' : '' }}>Không gợi ý</option>
                            <option value="1" {{ old('suggestion') == 1 ? 'selected' : '' }}>Gợi ý</option>
                        </select>
                        @error('suggestion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả chi tiết</label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="giftbox" class="form-label">Hộp quà (nếu có)</label>
                        <textarea name="giftbox" id="giftbox" class="form-control @error('giftbox') is-invalid @enderror">{{ old('giftbox') }}</textarea>
                        @error('giftbox')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
                        <a href="{{ route('admin') }}" class="btn btn-secondary">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Tích hợp SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Tích hợp Summernote -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-en-US.js"></script>

    <style>
        .image-preview img {
            object-fit: cover;
            border-radius: 5px;
        }

        .image-preview img.thumbnail-preview {
            border: 2px solid blue;
            width: 150px;
        }

        .image-preview img.related-image-preview {
            border: 1px solid gray;
            width: 100px;
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

            // Summernote cho description
            $('#description').summernote({
                height: 400,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture', 'table']]
                ],
                fontNames: [],
                fontNamesIgnoreCheck: [],
                addDefaultFonts: false,
                styleTags: [],
                callbacks: {
                    onImageUpload: function(files) {
                        let formData = new FormData();
                        formData.append('file', files[0]);
                        $.ajax({
                            url: "{{ route('upload.image') }}",
                            method: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function(data) {
                                if (data.url) {
                                    $('#description').summernote('insertImage', data.url);
                                }
                            },
                            error: function() {
                                alert('Tải ảnh thất bại');
                            }
                        });
                    }
                }
            });

            // Summernote cho giftbox
            $('#giftbox').summernote({
                height: 200,
                toolbar: [
                    ['font', ['bold', 'italic']],
                    ['para', ['ul', 'ol']]
                ],
                fontNames: [],
                fontNamesIgnoreCheck: [],
                addDefaultFonts: false,
                styleTags: [],
                callbacks: {}
            });

            // AJAX cho brands
            $('#category_id').on('change', function() {
                let categoryId = $(this).val();
                if (categoryId) {
                    $.ajax({
                        url: "{{ route('get.brands.by.category') }}",
                        method: 'GET',
                        data: {
                            category_id: categoryId
                        },
                        success: function(data) {
                            $('#brand_id').empty().append(
                                '<option value="">Chọn hãng</option>');
                            $.each(data.brands, function(key, brand) {
                                $('#brand_id').append('<option value="' + brand.id +
                                    '">' + brand.name + '</option>');
                            });
                        },
                        error: function() {
                            alert('Không thể tải danh sách hãng.');
                        }
                    });
                } else {
                    $('#brand_id').empty().append('<option value="">Chọn hãng</option>');
                }
            });

            @if (old('category_id'))
                $('#category_id').trigger('change');
            @endif

            // Xem trước ảnh
            const previewContainer = $(
                '<div class="image-preview mt-2" style="display: flex; flex-wrap: wrap;"></div>');
            $('#related_images').after(previewContainer);

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
                            .attr('title', 'Ảnh chính');
                        previewContainer.prepend(addRemoveButton(img));
                    };
                    reader.readAsDataURL(file);
                }
            });

            $('#related_images').on('change', function(e) {
                previewContainer.find('.related-image-preview').remove();
                const files = e.target.files;
                $.each(files, function(index, file) {
                    if (file.type.match('image.*')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = $('<img>').attr('src', e.target.result)
                                .addClass('related-image-preview')
                                .css({
                                    'width': '100px',
                                    'margin': '5px',
                                    'border': '1px solid gray'
                                })
                                .attr('title', 'Ảnh liên quan');
                            previewContainer.append(addRemoveButton(img));
                        };
                        reader.readAsDataURL(file);
                    }
                });
            });
        });
    </script>
@endsection

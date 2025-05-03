@extends('admin.layouts.main')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Thêm sản phẩm</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Thêm sản phẩm</li>
        </ol>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-header">
                Thêm sản phẩm
            </div>
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

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="brand_id" class="form-label">Hãng</label>
                            <select name="brand_id" id="brand_id"
                                class="form-control @error('brand_id') is-invalid @enderror" required>
                                <option value="">Chọn hãng</option>
                            </select>
                            @error('brand_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="price_new" class="form-label">Giá mới</label>
                            <input type="number" name="price_new" id="price_new"
                                class="form-control @error('price_new') is-invalid @enderror"
                                value="{{ old('price_new') }}" required>
                            @error('price_new')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="price_old" class="form-label">Giá cũ (nếu có)</label>
                            <input type="number" name="price_old" id="price_old"
                                class="form-control @error('price_old') is-invalid @enderror"
                                value="{{ old('price_old') }}">
                            @error('price_old')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="discount" class="form-label">Giảm giá (%)</label>
                            <input type="number" name="discount" id="discount"
                                class="form-control @error('discount') is-invalid @enderror"
                                value="{{ old('discount', 0) }}" min="0" max="100" required>
                            @error('discount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="stock" class="form-label">Trong kho</label>
                            <input type="number" name="stock" id="stock"
                                class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', 0) }}"
                                min="0" required>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="sold" class="form-label">Đã bán</label>
                            <input type="number" name="sold" id="sold"
                                class="form-control @error('sold') is-invalid @enderror" value="{{ old('sold', 0) }}"
                                min="0" required>
                            @error('sold')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
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
                        <label for="sortDesc" class="form-label">Mô tả ngắn</label>
                        <textarea name="sortDesc" id="sortDesc" class="form-control @error('sortDesc') is-invalid @enderror"
                            rows="4">{{ old('sortDesc') }}</textarea>
                        @error('sortDesc')
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

    <!-- Tích hợp Summernote -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <!-- File ngôn ngữ (nếu cần, đặt sau summernote.min.js) -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-en-US.js"></script>
    <script>
        $(document).ready(function() {
            $('#description').summernote({
                height: 400,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture', 'table']]
                ],
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
                                alert('Upload image failed');
                            }
                        });
                    }
                }
            });

            $('#giftbox').summernote({
                height: 200,
                toolbar: [
                    ['font', ['bold', 'italic']],
                    ['para', ['ul', 'ol']]
                ]
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Khi danh mục thay đổi
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
                            $('#brand_id').empty();
                            $('#brand_id').append('<option value="">Chọn hãng</option>');

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
                    $('#brand_id').empty();
                    $('#brand_id').append('<option value="">Chọn hãng</option>');
                }
            });

            // Nếu có old input (trường hợp form lỗi), tự động load lại hãng
            @if (old('category_id'))
                $('#category_id').trigger('change');
            @endif
        });
    </script>
@endsection

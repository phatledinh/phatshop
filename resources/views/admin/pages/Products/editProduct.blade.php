@extends('admin.layouts.main')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-edit me-1"></i>
                    Chỉnh sửa sản phẩm
                </div>
                <div class="card-body">
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

                    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data"
                        id="update-product-form">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="thumbnail" class="form-label">Ảnh sản phẩm</label>
                                    <input type="file" class="form-control" id="thumbnail" name="thumbnail"
                                        accept="image/*">
                                    <div class="mt-2" id="thumbnail-preview">
                                        @if ($product->thumbnail)
                                            <img src="{{ asset($product->thumbnail) }}" alt="Current Thumbnail"
                                                style="width: 100px; height: 120px; object-fit: contain;">
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="related_images" class="form-label">Ảnh liên quan</label>
                                    <input type="file" class="form-control" id="related_images" name="related_images[]"
                                        multiple accept="image/*">
                                    <div class="mt-2 d-flex flex-wrap" id="related-images-preview">
                                        @if ($product->images->count() > 0)
                                            @foreach ($product->images as $image)
                                                <div class="mb-2 position-relative me-2"
                                                    data-image-id="{{ $image->id }}">
                                                    <img src="{{ asset($image->img_path) }}" alt="Related Image"
                                                        style="width: 80px; height: 80px; object-fit: cover;">
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm position-absolute top-0 end-0"
                                                        style="padding: 2px 6px;"
                                                        onclick="removeImage(this, {{ $image->id }})">X</button>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <input type="hidden" name="deleted_images" id="deleted_images" value="">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="product_name" class="form-label">Tên sản phẩm</label>
                                    <input type="text" class="form-control" id="product_name" name="product_name"
                                        value="{{ old('product_name', $product->product_name) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Danh mục</label>
                                    <select class="form-select" id="category_id" name="category_id" required>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="brand_id" class="form-label">Hãng</label>
                                    <select class="form-select" id="brand_id" name="brand_id" required>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}"
                                                {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="price_new" class="form-label">Giá mới (VNĐ)</label>
                                    <input type="number" class="form-control" id="price_new" name="price_new"
                                        value="{{ old('price_new', $product->price_new) }}" step="1000" required>
                                </div>
                                <div class="mb-3">
                                    <label for="price_old" class="form-label">Giá cũ (VNĐ)</label>
                                    <input type="number" class="form-control" id="price_old" name="price_old"
                                        value="{{ old('price_old', $product->price_old) }}" step="1000">
                                </div>
                                <div class="mb-3">
                                    <label for="stock" class="form-label">Số lượng trong kho</label>
                                    <input type="number" class="form-control" id="stock" name="stock"
                                        value="{{ old('stock', $product->stock) }}" step="1" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Thông tin chi tiết</label>
                            <div class="p-2 box_shadow rounded-10 modal-open pl-lg-3 pr-lg-3 mb-3">
                                <h3 class="special-content title font-">Thông tin chi tiết</h3>
                                <textarea class="form-control summernote" id="description" name="description">{{ old('description', $product->description) }}</textarea>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="giftbox" class="form-label">Hộp quà</label>
                            <div class="p-2 box_shadow rounded-10 modal-open pl-lg-3 pr-lg-3 mb-3">
                                <h3 class="special-content title font-">Hộp quà</h3>
                                <div class="row">
                                    <textarea class="form-control summernote" id="giftbox" name="giftbox">{{ old('giftbox', $product->giftbox) }}</textarea>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        <a href="{{ route('listProduct') }}" class="btn btn-secondary ms-2">Hủy</a>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-en-US.js"></script>
    <!-- Thêm SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

            // Summernote cho giftbox
            $('#giftbox').summernote({
                height: 200,
                toolbar: [
                    ['font', ['bold', 'italic']],
                    ['para', ['ul', 'ol']]
                ]
            });

            // Hàm tải ảnh lên server
            function uploadImage(file, editor) {
                let data = new FormData();
                data.append('upload', file);
                data.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    url: '{{ route('upload.image') }}',
                    method: 'POST',
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.uploaded) {
                            $(editor).summernote('insertImage', response.url);
                        } else {
                            alert('Lỗi khi tải ảnh lên!');
                        }
                    },
                    error: function() {
                        alert('Lỗi khi tải ảnh lên!');
                    }
                });
            }
        });

        // Preview ảnh thumbnail
        document.getElementById('thumbnail').addEventListener('change', function(event) {
            const preview = document.getElementById('thumbnail-preview');
            preview.innerHTML = '';
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '100px';
                    img.style.height = '120px';
                    img.style.objectFit = 'contain';
                    img.alt = 'Thumbnail Preview';
                    preview.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        });

        // Preview và quản lý ảnh liên quan
        document.getElementById('related_images').addEventListener('change', function(event) {
            const previewContainer = document.getElementById('related-images-preview');
            const files = event.target.files;

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();

                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'mb-2 position-relative me-2';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '80px';
                    img.style.height = '80px';
                    img.style.objectFit = 'cover';
                    img.alt = 'Related Image';

                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className = 'btn btn-danger btn-sm position-absolute top-0 end-0';
                    removeBtn.style.padding = '2px 6px';
                    removeBtn.innerText = 'X';
                    removeBtn.onclick = function() {
                        removeImage(this, null);
                    };

                    div.appendChild(img);
                    div.appendChild(removeBtn);
                    previewContainer.appendChild(div);
                };
                reader.readAsDataURL(file);
            }
        });

        // Quản lý danh sách ID ảnh bị xóa
        let deletedImages = [];

        // Hàm xóa ảnh
        function removeImage(element, imageId) {
            const parent = element.parentElement;
            parent.remove();

            if (imageId) {
                deletedImages.push(imageId);
                document.getElementById('deleted_images').value = deletedImages.join(',');
            }
        }

        // Hiển thị SweetAlert2 khi cập nhật thành công
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

        // Xác nhận trước khi gửi form
        document.getElementById('update-product-form').addEventListener('submit', function(event) {
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
    </script>
    <style>
        .box_shadow {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .rounded-10 {
            border-radius: 10px;
        }

        .modal-open {

            position: relative;
            z-index: 1;
        }

        .pl-lg-3 {
            padding-left: 1.5rem;
        }

        .pr-lg-3 {
            padding-right: 1.5rem;
        }

        .mb-3 {
            margin-bottom: 1rem;
        }

        .p-2 {
            padding: 0.5rem;
        }

        .special-content {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .title {
            margin-bottom: 15px;
        }

        .font- {
            font-family: Arial, sans-serif;
        }

        .summernote {
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            min-height: 200px;
        }
    </style>
@endsection

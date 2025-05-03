@extends('layouts.main')

@section('content')
    <div class="categoryPage">
        <div class="container py-3">
            <x-breadcrumb-wrapper :breadcrumbs="[['label' => 'Trang chủ', 'url' => route('home')], ['label' => $category->name]]" />
        </div>
        <div class="container py-2">
            <div class="row">
                <div class="col-3">
                    <div class="sidebar">
                        <div class="card border-0 shadow card-2">
                            <div class="catList">
                                <div style="border-bottom: 2px solid #3BBA7D; margin-bottom: 20px;">
                                    <h3 class="title">Giá</h3>
                                </div>
                                <div id="range-slider"></div>
                                <div class="value-display">Giá từ: <span id="range-values">300.000 - 50.000.000 VNĐ</span>
                                </div>
                                <div style="border-bottom: 2px solid #3BBA7D; margin-top: 30px; margin-bottom: 10px;">
                                    <h3 class="title">Hãng</h3>
                                </div>
                                @foreach ($brands as $brand)
                                    <div class="form-check d-flex align-items-center">
                                        <input class="form-check-input brand-checkbox" type="checkbox"
                                            value="{{ $brand->id }}" id="brand-{{ $brand->id }}"
                                            style="width: 25px; height: 25px;">
                                        <img class="mb-0 mr-3 ms-2" style="width:60px; height:30px; object-fit:contain"
                                            src="{{ asset($brand->thumbnail) }}" />
                                        <span class="d-flex align-items-center justify-content-center rounded-circle"
                                            style="margin-left: auto;">
                                            {{ $brand->products_count ?? 0 }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-success btn-filter">Tìm kiếm</button>
                        </div>
                    </div>
                </div>
                <div class="col-9" style="background-color: #ffffff; border-radius:25px; position: relative;">
                    <div class="row" id="product-list">
                        @foreach ($products as $product)
                            <div class="col-3" style="margin-top: 10px">
                                <div class="card-product">
                                    <div class="product-thumbnail sale">
                                        <a class="image_thumb" href="{{ route('product.detail', $product->slug) }}">
                                            <img src="{{ asset($product->thumbnail) }}" alt="{{ $product->product_name }}">
                                        </a>
                                    </div>
                                    <div class="product-info">
                                        <h3 class="product-">
                                            <a href="#"
                                                title="{{ $product->product_name }}">{{ $product->product_name }}</a>
                                        </h3>
                                        <div class="price-box">
                                            <span class="price">{{ number_format($product->price_new, 0, ',', '.') }}
                                                ₫</span>
                                            @if (!is_null($product->price_old) && $product->price_old > 0)
                                                <span class="compare-price">
                                                    {{ number_format($product->price_old, 0, ',', '.') }} ₫
                                                </span>
                                            @endif
                                            <div class="action-cart">
                                                <a class="btn-buy btn-views add_to_cart" title="Tới gian hàng"
                                                    href="#!" target="_blank">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25">
                                                        <circle cx="7" cy="17" r="2"></circle>
                                                        <circle cx="15" cy="17" r="2"></circle>
                                                        <path
                                                            d="M20,4.4V5l-1.8,6.3c-0.1,0.4-0.5,0.7-1,0.7H6.7c-0.4,0-0.8-0.3-1-0.7L3.3,3.9C3.1,3.3,2.6,3,2.1,3H0.4C0.2,3,0,2.8,0,2.6 V1.4C0,1.2,0.2,1,0.4,1h2.5c1,0,1.8,0.6,2.1,1.6L5.1,3l2.3,6.8c0,0.1,0.2,0.2,0.3,0.2h8.6c0.1,0,0.3-0.1,0.3-0.2l1.3-4.4C17.9,5.2,17.7,5,17.5,5H9.4C9.2,5,9,4.8,9,4.6V3.4C9,3.2,9.2,3,9.4,3h9.2C19.4,3,20,3.6,20,4.4z">
                                                        </path>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div id="filter-spinner" class="spinner-overlay" style="display: none;">
                        <div class="spinner">
                            <div class="spinner-border text-success" role="status">
                                <span class="visually-hidden">Đang lọc...</span>
                            </div>
                            <p class="spinner-text">Đang lọc sản phẩm...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <style>
        .spinner-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            /* Nền mờ trắng */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            border-radius: 25px;
        }

        .spinner {
            text-align: center;
        }

        .spinner-border {
            width: 3rem;
            /* Kích thước lớn hơn */
            height: 3rem;
            border-width: 0.4em;
            /* Đường viền dày hơn */
        }

        .spinner-text {
            margin-top: 10px;
            color: #3BBA7D;
            /* Màu xanh giống giao diện */
            font-weight: bold;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Script đã tải'); // Log để kiểm tra script chạy

            // Khởi tạo noUiSlider
            var rangeSlider = document.getElementById('range-slider');
            var rangeValues = document.getElementById('range-values');
            if (rangeSlider && rangeValues) {
                noUiSlider.create(rangeSlider, {
                    start: [300000, 50000000],
                    connect: true,
                    range: {
                        'min': 300000,
                        'max': 50000000
                    },
                    format: {
                        to: function(value) {
                            return Math.round(value);
                        },
                        from: function(value) {
                            return Number(value);
                        }
                    }
                });

                rangeSlider.noUiSlider.on('update', function(values, handle) {
                    rangeValues.textContent = values[0].toLocaleString('vi-VN') + ' - ' + values[1]
                        .toLocaleString('vi-VN') + ' VNĐ';
                });
            } else {
                console.error('Không tìm thấy #range-slider hoặc #range-values');
            }

            // Xử lý sự kiện nút tìm kiếm
            var btn = document.querySelector('.btn-filter');
            var spinner = document.getElementById('filter-spinner');
            console.log('Nút:', btn);
            if (btn && spinner) {
                btn.addEventListener('click', function() {
                    console.log('Nút tìm kiếm được bấm');
                    spinner.style.display = 'flex'; // Hiển thị spinner
                    btn.disabled = true; // Vô hiệu hóa nút

                    var priceRange = rangeSlider.noUiSlider.get();
                    var minPrice = priceRange[0];
                    var maxPrice = priceRange[1];
                    var selectedBrands = [];
                    document.querySelectorAll('.brand-checkbox:checked').forEach(function(checkbox) {
                        selectedBrands.push(checkbox.value);
                    });
                    console.log('Dữ liệu gửi:', {
                        min_price: minPrice,
                        max_price: maxPrice,
                        brands: selectedBrands
                    });

                    fetch('{{ route('category.filter', $category->slug) }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                min_price: minPrice,
                                max_price: maxPrice,
                                brands: selectedBrands
                            })
                        })
                        .then(response => {
                            console.log('Phản hồi:', response.status, response.statusText);
                            if (!response.ok) {
                                return response.text().then(text => {
                                    throw new Error('Yêu cầu thất bại: ' + response.status +
                                        ' - ' + text);
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Dữ liệu:', data);
                            updateProductList(data.products);
                        })
                        .catch(error => {
                            console.error('Lỗi AJAX:', error.message);
                        })
                        .finally(() => {
                            spinner.style.display = 'none'; // Ẩn spinner
                            btn.disabled = false; // Kích hoạt lại nút
                        });
                });
            } else {
                console.error('Không tìm thấy nút .btn-filter hoặc #filter-spinner');
            }
        });

        function updateProductList(products) {
            console.log('Sản phẩm nhận được:', products);
            var productContainer = document.getElementById('product-list');
            if (!productContainer) {
                console.error('Không tìm thấy #product-list');
                return;
            }
            productContainer.innerHTML = '';

            if (products.length === 0) {
                productContainer.innerHTML = '<p class="text-center">Không tìm thấy sản phẩm nào.</p>';
                return;
            }

            products.forEach(function(product) {
                var productHtml = `
                    <div class="col-3" style="margin-top: 10px">
                        <div class="card-product">
                            <div class="product-thumbnail sale">
                                <a class="image_thumb" href="${product.detail_url}">
                                    <img src="${product.thumbnail}" alt="${product.product_name}">
                                </a>
                            </div>
                            <div class="product-info">
                                <h3 class="product-">
                                    <a href="#" title="${product.product_name}">${product.product_name}</a>
                                </h3>
                                <div class="price-box">
                                    <span class="price">${product.price_new.toLocaleString('vi-VN')} ₫</span>
                                    ${product.price_old ? `<span class="compare-price">${product.price_old.toLocaleString('vi-VN')} ₫</span>` : ''}
                                    <div class="action-cart">
                                        <a class="btn-buy btn-views add_to_cart" title="Tới gian hàng" href="#!" target="_blank">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25">
                                                <circle cx="7" cy="17" r="2"></circle>
                                                <circle cx="15" cy="17" r="2"></circle>
                                                <path d="M20,4.4V5l-1.8,6.3c-0.1,0.4-0.5,0.7-1,0.7H6.7c-0.4,0-0.8-0.3-1-0.7L3.3,3.9C3.1,3.3,2.6,3,2.1,3H0.4C0.2,3,0,2.8,0,2.6 V1.4C0,1.2,0.2,1,0.4,1h2.5c1,0,1.8,0.6,2.1,1.6L5.1,3l2.3,6.8c0,0.1,0.2,0.2,0.3,0.2h8.6c0.1,0,0.3-0.1,0.3-0.2l1.3-4.4C17.9,5.2,17.7,5,17.5,5H9.4C9.2,5,9,4.8,9,4.6V3.4C9,3.2,9.2,3,9.4,3h9.2C19.4,3,20,3.6,20,4.4z"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                productContainer.insertAdjacentHTML('beforeend', productHtml);
            });
        }
    </script>
@endsection

@extends('layouts.main')

@section('content')
    <section class="detailsPage">
        <div class="container py-3">
            <x-breadcrumb-wrapper :breadcrumbs="[
                ['label' => 'Trang chủ', 'url' => route('home')],
                ['label' => $category->name, 'url' => route('category.detail', $category->slug)],
                ['label' => $product->product_name],
            ]" />
        </div>

        <div class="container">
            <div class="row">
                <div class="col-lg-9 " style="background-color: #FFFFFF; border-radius:25px;">
                    <div class="row mt-4">
                        <div class="col-lg-5">
                            <div class="productZoom">
                                <!-- Ảnh chính với Zoom -->
                                <img id="zoom_09" src="{{ asset($product->thumbnail) }}" width="300" />

                                <!-- Gallery ảnh -->
                                <div id="gallery_09" class="gallery py-2">
                                    @foreach ($productImages as $productimages)
                                        <a href="images/large/image1.jpg" data-image="{{ asset($productimages->img_path) }}"
                                            data-zoom-image="images/large/image1.jpg" data-fancybox="gallery">
                                            <img src="{{ asset($productimages->img_path) }}" />
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7 productInfo">
                            <h2 class="product-title">{{ $product->product_name }}</h2>
                            <div class="product-price">
                                <p class="new-price">{{ number_format($product->price_new, 0, ',', '.') }}₫</p>
                                @if (!is_null($product->price_old) && $product->price_old > 0)
                                    <p class="last-price">Giá niêm yết:
                                        <span>{{ number_format($product->price_old, 0, ',', '.') }}₫</span>
                                    </p>
                                @endif
                            </div>
                            <div class="product-quantity">
                                <p class="quantity">Số lượng:</p>
                            </div>

                            <div class="custom custom-btn-numbers clearfix input_number_product">
                                <button class="btn-minus btn-cts"
                                    onclick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN(qty) && qty > 1 ) result.value--; checkStock(document.getElementById('qty'), {{ $product->stock }}); return false;"
                                    type="button">–</button>
                                <input aria-label="Số lượng" class="qty input-text item_quantity" id="qty"
                                    maxlength="3" name="quantity"
                                    onchange="if(this.value == 0)this.value=1; checkStock(this, {{ $product->stock }})"
                                    onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;"
                                    size="4" type="text" value="1" data-stock="{{ $product->stock }}">
                                <button class="btn-plus btn-cts"
                                    onclick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN(qty)) result.value++; checkStock(document.getElementById('qty'), {{ $product->stock }}); return false;"
                                    type="button">+</button>
                            </div>

                            <div class="purchase-btn d-flex py-2">
                                <a href="javascript:void(0);" class="btn-addcart add_to_cart"
                                    data-product-id="{{ $product->id }}" data-stock="{{ $product->stock }}"
                                    onclick="addToCart(this)">
                                    THÊM VÀO GIỎ
                                    <br>
                                    Cam kết chính hãng/ đổi trả 24h
                                </a>
                                <a href="{{ route('cart') }}" class="btn-buy-now"
                                    onclick="return checkBuyNow({{ $product->stock }})">
                                    MUA NGAY
                                    <br>
                                    Thanh toán nhanh chóng
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="detail-infoProduct">
                        <div class="specifications-product" style="padding: 20px 20px 0px">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-home" type="button" role="tab"
                                        aria-controls="pills-home" aria-selected="true">
                                        Thông số kỹ thuật
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-profile" type="button" role="tab"
                                        aria-controls="pills-profile" aria-selected="false">
                                        Bài viết đánh giá
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                    aria-labelledby="pills-home-tab">
                                    <div class="p-2 box_shadow rounded-10 modal-open pl-lg-3 pr-lg-3 mb-3">
                                        <h3 class="special-content_title font-weight-bold d-block w-100 pt-2 pb-2 mb-0">
                                            Thông tin chi tiết</h3>
                                        <div class="product-content pt-2 pb-2 mewcontent">
                                            <div class="content_coll modal-close-content position-relative rte">
                                                {!! $product->description !!}
                                                <div class="bg_cl position-absolute w-100"></div>
                                            </div>
                                            <div class="view_mores text-center mb-2">
                                                <a href="javascript:;"
                                                    class="one pt-2 pb-2 pl-4 pr-4 modal-open position-relative btn rounded-10 box_shadow font-weight-bold"
                                                    title="Xem thêm">Xem thêm <i class="fa-solid fa-angle-down"></i></a>
                                                <a href="javascript:;"
                                                    class="two pt-2 pb-2 pl-4 pr-4 modal-open position-relative btn rounded-10 box_shadow font-weight-bold d-none"
                                                    title="Thu gọn">Thu gọn <i class="fa-solid fa-angle-up"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                    aria-labelledby="pills-profile-tab">
                                    <div class="reviews-section" style="padding: 20px;">
                                        <!-- Review Submission Form -->
                                        <div class="review-form mb-4"
                                            style="background-color: #f8f9fa; padding: 20px; border-radius: 15px;">
                                            <h3 class="mb-3">Viết đánh giá của bạn</h3>
                                            @auth
                                                <form action="{{ route('product.review.store', $product->slug) }}"
                                                    method="POST">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="rating" class="form-label">Đánh giá của bạn</label>
                                                        <div class="star-rating" id="star-rating">
                                                            <span class="star" data-value="1">★</span>
                                                            <span class="star" data-value="2">★</span>
                                                            <span class="star" data-value="3">★</span>
                                                            <span class="star" data-value="4">★</span>
                                                            <span class="star" data-value="5">★</span>
                                                            <input type="hidden" name="rating" id="rating-value"
                                                                value="0" required>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="comment" class="form-label">Nhận xét</label>
                                                        <textarea class="form-control" id="comment" name="comment" rows="4" required></textarea>
                                                    </div>
                                                    <button type="submit" class="btn btn-danger">Gửi đánh giá</button>
                                                </form>
                                            @else
                                                <p>Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để viết đánh giá.</p>
                                            @endauth
                                        </div>

                                        <!-- Reviews List -->
                                        <div class="reviews-list">
                                            <h3 class="mb-3">Đánh giá sản phẩm ({{ $reviews->count() }})</h3>
                                            @if ($reviews->isEmpty())
                                                <p>Chưa có đánh giá nào cho sản phẩm này.</p>
                                            @else
                                                @foreach ($reviews as $review)
                                                    <div class="review-item mb-3 p-3"
                                                        style="border: 1px solid #dee2e6; border-radius: 10px;">
                                                        <div class="d-flex justify-content-between">
                                                            <div>
                                                                <strong>{{ $review->user->name }}</strong>
                                                                <div class="star-display">
                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                        <span
                                                                            class="star {{ $i <= $review->rating ? 'filled' : '' }}">★</span>
                                                                    @endfor
                                                                </div>
                                                            </div>
                                                            <small
                                                                class="text-muted">{{ $review->created_at->format('d/m/Y H:i') }}</small>
                                                        </div>
                                                        <p class="mt-2">{{ $review->comment }}</p>
                                                    </div>
                                                @endforeach

                                                <!-- Pagination -->
                                                <div class="pagination mt-4">
                                                    {{ $reviews->links() }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="linehot d-flex align-items-center"
                        style="background-color: #FFF3CD; padding: 5px 0px; border-radius: 15px">
                        <img class="ms-2" src="{{ asset('images/icons/customer-service.webp') }}" alt="">
                        <div class="ms-2">
                            <span class="d-block fs-5">Gọi mua <strong style="color: red">0987654321</strong></span>
                            <span class="d-block fs-4" style="color: red">Zalo - Facebook</span>
                        </div>
                    </div>
                    <div class="banner"
                        style="background-color: #FFFFFF; padding: 5px 0px; border-radius: 15px; margin-top: 10px">
                        <span class="d-block fs-5 ms-2">Tình trạng: <span style="color: #00b907;">Còn hàng</span></span>
                        <span class="d-block fs-5 ms-2">Thương hiệu: <span style="color: #00b907">Apple</span></span>
                        <span class="d-block fs-5 ms-2">Loại: <span style="color: #00b907">Điện thoại ios</span></span>
                    </div>
                    <div class="mt-2 giftbox" style="background-color: #FFFFFF; padding: 5px">
                        <div class="giftbox-icon d-flex align-items-center">
                            <img src="{{ asset('images/icons/gift.webp') }}" alt="">
                            <span class="fs-5 ms-2 text-danger">Quà tặng</span>
                        </div>
                        <div>
                            {!! $product->giftbox !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="detailsPage-bottom py-4">
        <div class="container" style="background-color: #FFFFFF; border-radius:25px;">
            <h2 class="sale-product-title">Sản phẩm liên quan</h2>
            <div class="owl-carousel owl-theme" id="carousel-1">
                @foreach ($phoneProducts as $product)
                    <div class="item">
                        <div class="card-product">
                            <div class="product-thumbnail sale">
                                <a class="image_thumb" href="{{ route('product.detail', $product->slug) }}">
                                    <img src="{{ asset($product->thumbnail) }}" alt="{{ $product->product_name }}">
                                </a>
                            </div>
                            <div class="product-info">
                                <h3 class="product-name">
                                    <a href="#"
                                        title="{{ $product->product_name }}">{{ $product->product_name }}</a>
                                </h3>
                                <div class="price-box">
                                    <span class="price">{{ number_format($product->price_new, 0, ',', '.') }}
                                        ₫</span>
                                    <span class="compare-price">{{ number_format($product->price_old, 0, ',', '.') }}
                                        ₫</span>
                                    <div class="action-cart">
                                        <a class="btn-buy btn-views add_to_cart" title="Tới gian hàng" href="#!"
                                            target="_blank">
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
        </div>
    </section>

@section('scripts')
    <!-- Thêm SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Kiểm tra số lượng so với tồn kho
        function checkStock(input, stock) {
            const qty = parseInt(input.value);
            if (isNaN(qty) || qty < 1) {
                input.value = 1;
                return;
            }
            if (qty > stock) {
                Swal.fire({
                    icon: 'error',
                    title: 'Hết hàng!',
                    text: `Sản phẩm chỉ còn ${stock} đơn vị trong kho.`,
                    confirmButtonText: 'OK'
                });
                input.value = stock; // Đặt lại số lượng tối đa
            }
        }

        // Kiểm tra khi thêm vào giỏ hàng
        function addToCart(element) {
            const productId = element.getAttribute('data-product-id');
            const stock = parseInt(element.getAttribute('data-stock'));
            const qtyInput = document.getElementById('qty');
            const qty = parseInt(qtyInput.value);

            if (qty > stock) {
                Swal.fire({
                    icon: 'error',
                    title: 'Hết hàng!',
                    text: `Sản phẩm chỉ còn ${stock} đơn vị trong kho.`,
                    confirmButtonText: 'OK'
                });
                qtyInput.value = stock;
                return;
            }

            // Tiến hành thêm vào giỏ hàng
            fetch(`/cart/add/${productId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        quantity: qty
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công!',
                            text: 'Sản phẩm đã được thêm vào giỏ hàng.',
                            confirmButtonText: 'OK'
                        });
                        updateCartDisplay(data);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: data.message || 'Không thể thêm sản phẩm vào giỏ hàng.',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi!',
                        text: 'Có lỗi xảy ra khi thêm sản phẩm.',
                        confirmButtonText: 'OK'
                    });
                });
        }

        // Kiểm tra khi mua ngay
        function checkBuyNow(stock) {
            const qty = parseInt(document.getElementById('qty').value);
            if (qty > stock) {
                Swal.fire({
                    icon: 'error',
                    title: 'Hết hàng!',
                    text: `Sản phẩm chỉ còn ${stock} đơn vị trong kho.`,
                    confirmButtonText: 'OK'
                });
                document.getElementById('qty').value = stock;
                return false; // Ngăn chuyển hướng đến trang giỏ hàng
            }
            return true; // Cho phép chuyển hướng
        }

        // Giữ nguyên hàm updateCartDisplay
        function updateCartDisplay(data) {
            const totalPriceElement = document.getElementById("totalPrice");
            const selectedCountElement = document.getElementById("selectedCount");
            const cartInfo = document.querySelector(".js-cart-info");
            const emptyCartMessage = document.querySelector(".js-empty-cart-message");
            const cartCountElement = document.querySelector(".js-cart-count");

            if (totalPriceElement) {
                totalPriceElement.textContent =
                    (data.total || 0).toLocaleString("vi-VN") + "₫";
            }

            if (selectedCountElement) {
                selectedCountElement.textContent = data.count || 0;
            }

            if (cartCountElement) {
                cartCountElement.textContent = data.count || 0;
            } else {
                document.dispatchEvent(
                    new CustomEvent("updateCartCount", {
                        detail: {
                            count: data.count || 0
                        },
                    })
                );
            }

            if (data.count === 0) {
                if (cartInfo) cartInfo.style.display = "none";
                if (emptyCartMessage) emptyCartMessage.style.display = "block";
            } else {
                if (cartInfo) cartInfo.style.display = "flex";
                if (emptyCartMessage) emptyCartMessage.style.display = "none";
            }

            document.dispatchEvent(new Event("updateSummary"));
        }

        // Giữ nguyên các script liên quan đến đánh giá
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.star-rating .star');
            const ratingInput = document.getElementById('rating-value');

            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const value = this.getAttribute('data-value');
                    ratingInput.value = value;
                    stars.forEach(s => {
                        s.classList.remove('filled');
                        if (s.getAttribute('data-value') <= value) {
                            s.classList.add('filled');
                        }
                    });
                });

                star.addEventListener('mouseover', function() {
                    const value = this.getAttribute('data-value');
                    stars.forEach(s => {
                        s.classList.remove('hover');
                        if (s.getAttribute('data-value') <= value) {
                            s.classList.add('hover');
                        }
                    });
                });

                star.addEventListener('mouseout', function() {
                    stars.forEach(s => s.classList.remove('hover'));
                });
            });
        });
    </script>

    <style>
        .star-rating .star {
            font-size: 24px;
            color: #ddd;
            cursor: pointer;
            transition: color 0.2s;
        }

        .star-rating .star.filled,
        .star-rating .star:hover,
        .star-rating .star.hover {
            color: #ffc107;
        }

        .star-display .star {
            font-size: 18px;
            color: #ddd;
        }

        .star-display .star.filled {
            color: #ffc107;
        }

        .review-item {
            background-color: #fff;
        }

        .pagination .page-link {
            color: #007bff;
        }

        .pagination .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
        }
    </style>
@endsection
@endsection

@extends('layouts.main')

@section('content')
    <section class="slider py-2">
        <div class="container">
            <div class="row">
                <div class="col-3"></div>
                <div class="col-9">
                    <div class="row">
                        <div class="col-9">
                            <div class="owl-carousel owl-theme" id="carousel-2">
                                <div class="item">
                                    <div class="home-slide-image"><img src="{{ asset('images/banner/slide-1.png') }}"
                                            alt="">
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="home-slide-image"><img src="{{ asset('images/banner/slide-2.png') }}"
                                            alt=""></div>
                                </div>
                                <div class="item">
                                    <div class="home-slide-image"><img src="{{ asset('images/banner/slide-3.png') }}"
                                            alt=""></div>
                                </div>
                                <div class="item">
                                    <div class="home-slide-image"><img src="{{ asset('images/banner/slide-4.jpg') }}"
                                            alt=""></div>
                                </div>
                            </div>
                            <div class="row py-2">
                                <div class="col-4">
                                    <div class="home-image">
                                        <img src="{{ asset('images/banner/home-banner-2.jpg') }}" alt="">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="home-image">
                                        <img src="{{ asset('images/banner/home-banner-3.jpg') }}" alt="">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="home-image">
                                        <img src="{{ asset('images/banner/home-banner-4.jpg') }}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="home-image">
                                <img src="{{ asset('images/banner/home-banner-1.jpg') }}" alt="">
                            </div>
                            <div class="home-image py-3">
                                <img src="{{ asset('images/banner/home-banner-1.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="sale-product py-3">
        <div class="container">
            <h2 class="sale-product-title">Khuyến mãi đặc biệt</h2>
            <ul class="nav nav-tabs d-flex align-items-center w-100" id="myTab" role="tablist" style="height: 80px;">
                <li class="nav-item d-flex justify-content-center align-items-center flex-grow-1 h-100" role="presentation">
                    <button class="nav-link w-100 h-100 active d-flex justify-content-center align-items-center"
                        id="flashsale-tab" data-bs-toggle="tab" data-bs-target="#flashsale-tab-pane" type="button"
                        role="tab" aria-controls="flashsale-tab-pane" aria-selected="true">
                        <img src="{{ asset('images/flahsale.jpg') }}" alt="" class="img-fluid"
                            style="width: 80px; height: 50px; object-fit: contain;">
                    </button>
                </li>
                <li class="nav-item d-flex justify-content-center align-items-center flex-grow-1 h-100" role="presentation">
                    <button class="nav-link w-100 h-100" id="phone-tab" data-bs-toggle="tab"
                        data-bs-target="#phone-tab-pane" type="button" role="tab" aria-controls="phone-tab-pane"
                        aria-selected="false" style="color: black;">Điện thoại</button>
                </li>
                <li class="nav-item d-flex justify-content-center align-items-center flex-grow-1 h-100" role="presentation">
                    <button class="nav-link w-100 h-100" id="laptop-tab" data-bs-toggle="tab"
                        data-bs-target="#laptop-tab-pane" type="button" role="tab" aria-controls="laptop-tab-pane"
                        aria-selected="false" style="color: black;">Laptop</button>
                </li>
                <li class="nav-item d-flex justify-content-center align-items-center flex-grow-1 h-100" role="presentation">
                    <button class="nav-link w-100 h-100" id="accessory-tab" data-bs-toggle="tab"
                        data-bs-target="#accessory-tab-pane" type="button" role="tab"
                        aria-controls="accessory-tab-pane" aria-selected="false" style="color: black;">Phụ kiện</button>
                </li>
                <li class="nav-item d-flex justify-content-center align-items-center flex-grow-1 h-100"
                    role="presentation">
                    <button class="nav-link w-100 h-100" id="watch-tab" data-bs-toggle="tab"
                        data-bs-target="#watch-tab-pane" type="button" role="tab" aria-controls="watch-tab-pane"
                        aria-selected="false" style="color: black;">Đồng hồ</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="flashsale-tab-pane" role="tabpanel"
                    aria-labelledby="flashsale-tab" tabindex="0">
                    <div class="row">
                        @foreach ($flashsaleProducts as $product)
                            <div class="col-2">
                                <div class="card-product">
                                    <div class="product-thumbnail sale" data-sale="Giảm {{ $product->discount }}%">
                                        <a class="image_thumb" href="{{ route('product.detail', $product->slug) }}">
                                            <img src="{{ asset($product->thumbnail) }}"
                                                alt="{{ $product->product_name }}">
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

                                            @if (!is_null($product->price_old) && $product->price_old > 0)
                                                <span class="compare-price">
                                                    {{ number_format($product->price_old, 0, ',', '.') }} ₫
                                                </span>
                                            @endif


                                            <div class="action-cart">
                                                <a href="javascript:void(0);" class="btn-buy btn-views add_to_cart"
                                                    data-product-id="{{ $product->id }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="25"
                                                        height="25">
                                                        <circle cx="7" cy="17" r="2"></circle>
                                                        <circle cx="15" cy="17" r="2"></circle>
                                                        <path
                                                            d="M20,4.4V5l-1.8,6.3c-0.1,0.4-0.5,0.7-1,0.7H6.7c-0.4,0-0.8-0.3-1-0.7L3.3,3.9C3.1,3.3,2.6,3,2.1,3H0.4C0.2,3,0,2.8,0,2.6V1.4C0,1.2,0.2,1,0.4,1h2.5c1,0,1.8,0.6,2.1,1.6L5.1,3l2.3,6.8c0,0.1,0.2,0.2,0.3,0.2h8.6c0.1,0,0.3-0.1,0.3-0.2l1.3-4.4C17.9,5.2,17.7,5,17.5,5H9.4C9.2,5,9,4.8,9,4.6V3.4C9,3.2,9.2,3,9.4,3h9.2C19.4,3,20,3.6,20,4.4z">
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
                <div class="tab-pane fade" id="phone-tab-pane" role="tabpanel" aria-labelledby="phone-tab"
                    tabindex="0">
                    <div class="row">
                        @foreach ($phoneProducts as $product)
                            <div class="col-2">
                                <div class="card-product">
                                    <div class="product-thumbnail sale" data-sale="Giảm {{ $product->discount }}%">
                                        <a class="image_thumb" href="{{ route('product.detail', $product->slug) }}">
                                            <img src="{{ asset($product->thumbnail) }}"
                                                alt="{{ $product->product_name }}">
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

                                            @if (!is_null($product->price_old) && $product->price_old > 0)
                                                <span class="compare-price">
                                                    {{ number_format($product->price_old, 0, ',', '.') }} ₫
                                                </span>
                                            @endif


                                            <div class="action-cart">
                                                <a href="javascript:void(0);" class="btn-buy btn-views add_to_cart"
                                                    data-product-id="{{ $product->id }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="25"
                                                        height="25">
                                                        <circle cx="7" cy="17" r="2"></circle>
                                                        <circle cx="15" cy="17" r="2"></circle>
                                                        <path
                                                            d="M20,4.4V5l-1.8,6.3c-0.1,0.4-0.5,0.7-1,0.7H6.7c-0.4,0-0.8-0.3-1-0.7L3.3,3.9C3.1,3.3,2.6,3,2.1,3H0.4C0.2,3,0,2.8,0,2.6V1.4C0,1.2,0.2,1,0.4,1h2.5c1,0,1.8,0.6,2.1,1.6L5.1,3l2.3,6.8c0,0.1,0.2,0.2,0.3,0.2h8.6c0.1,0,0.3-0.1,0.3-0.2l1.3-4.4C17.9,5.2,17.7,5,17.5,5H9.4C9.2,5,9,4.8,9,4.6V3.4C9,3.2,9.2,3,9.4,3h9.2C19.4,3,20,3.6,20,4.4z">
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
                <div class="tab-pane fade" id="laptop-tab-pane" role="tabpanel" aria-labelledby="laptop-tab"
                    tabindex="0">
                    <div class="row">
                        @foreach ($laptopProducts as $product)
                            <div class="col-2">
                                <div class="card-product">
                                    <div class="product-thumbnail sale" data-sale="Giảm {{ $product->discount }}%">
                                        <a class="image_thumb" href="{{ route('product.detail', $product->slug) }}">
                                            <img src="{{ asset($product->thumbnail) }}"
                                                alt="{{ $product->product_name }}">
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

                                            @if (!is_null($product->price_old) && $product->price_old > 0)
                                                <span class="compare-price">
                                                    {{ number_format($product->price_old, 0, ',', '.') }} ₫
                                                </span>
                                            @endif


                                            <div class="action-cart">
                                                <a href="javascript:void(0);" class="btn-buy btn-views add_to_cart"
                                                    data-product-id="{{ $product->id }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="25"
                                                        height="25">
                                                        <circle cx="7" cy="17" r="2"></circle>
                                                        <circle cx="15" cy="17" r="2"></circle>
                                                        <path
                                                            d="M20,4.4V5l-1.8,6.3c-0.1,0.4-0.5,0.7-1,0.7H6.7c-0.4,0-0.8-0.3-1-0.7L3.3,3.9C3.1,3.3,2.6,3,2.1,3H0.4C0.2,3,0,2.8,0,2.6V1.4C0,1.2,0.2,1,0.4,1h2.5c1,0,1.8,0.6,2.1,1.6L5.1,3l2.3,6.8c0,0.1,0.2,0.2,0.3,0.2h8.6c0.1,0,0.3-0.1,0.3-0.2l1.3-4.4C17.9,5.2,17.7,5,17.5,5H9.4C9.2,5,9,4.8,9,4.6V3.4C9,3.2,9.2,3,9.4,3h9.2C19.4,3,20,3.6,20,4.4z">
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
                <div class="tab-pane fade" id="accessory-tab-pane" role="tabpanel" aria-labelledby="accessory-tab"
                    tabindex="0">
                    <div class="row">
                        @foreach ($accessoryProducts as $product)
                            <div class="col-2">
                                <div class="card-product">
                                    <div class="product-thumbnail sale" data-sale="Giảm {{ $product->discount }}%">
                                        <a class="image_thumb" href="{{ route('product.detail', $product->slug) }}">
                                            <img src="{{ asset($product->thumbnail) }}"
                                                alt="{{ $product->product_name }}">
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

                                            @if (!is_null($product->price_old) && $product->price_old > 0)
                                                <span class="compare-price">
                                                    {{ number_format($product->price_old, 0, ',', '.') }} ₫
                                                </span>
                                            @endif


                                            <div class="action-cart">
                                                <a href="javascript:void(0);" class="btn-buy btn-views add_to_cart"
                                                    data-product-id="{{ $product->id }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="25"
                                                        height="25">
                                                        <circle cx="7" cy="17" r="2"></circle>
                                                        <circle cx="15" cy="17" r="2"></circle>
                                                        <path
                                                            d="M20,4.4V5l-1.8,6.3c-0.1,0.4-0.5,0.7-1,0.7H6.7c-0.4,0-0.8-0.3-1-0.7L3.3,3.9C3.1,3.3,2.6,3,2.1,3H0.4C0.2,3,0,2.8,0,2.6V1.4C0,1.2,0.2,1,0.4,1h2.5c1,0,1.8,0.6,2.1,1.6L5.1,3l2.3,6.8c0,0.1,0.2,0.2,0.3,0.2h8.6c0.1,0,0.3-0.1,0.3-0.2l1.3-4.4C17.9,5.2,17.7,5,17.5,5H9.4C9.2,5,9,4.8,9,4.6V3.4C9,3.2,9.2,3,9.4,3h9.2C19.4,3,20,3.6,20,4.4z">
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
                <div class="tab-pane fade" id="watch-tab-pane" role="tabpanel" aria-labelledby="watch-tab"
                    tabindex="0">
                    <div class="row">
                        @foreach ($watchProducts as $product)
                            <div class="col-2">
                                <div class="card-product">
                                    <div class="product-thumbnail sale" data-sale="Giảm {{ $product->discount }}%">
                                        <a class="image_thumb" href="{{ route('product.detail', $product->slug) }}">
                                            <img src="{{ asset($product->thumbnail) }}"
                                                alt="{{ $product->product_name }}">
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

                                            @if (!is_null($product->price_old) && $product->price_old > 0)
                                                <span class="compare-price">
                                                    {{ number_format($product->price_old, 0, ',', '.') }} ₫
                                                </span>
                                            @endif


                                            <div class="action-cart">
                                                <a href="javascript:void(0);" class="btn-buy btn-views add_to_cart"
                                                    data-product-id="{{ $product->id }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="25"
                                                        height="25">
                                                        <circle cx="7" cy="17" r="2"></circle>
                                                        <circle cx="15" cy="17" r="2"></circle>
                                                        <path
                                                            d="M20,4.4V5l-1.8,6.3c-0.1,0.4-0.5,0.7-1,0.7H6.7c-0.4,0-0.8-0.3-1-0.7L3.3,3.9C3.1,3.3,2.6,3,2.1,3H0.4C0.2,3,0,2.8,0,2.6V1.4C0,1.2,0.2,1,0.4,1h2.5c1,0,1.8,0.6,2.1,1.6L5.1,3l2.3,6.8c0,0.1,0.2,0.2,0.3,0.2h8.6c0.1,0,0.3-0.1,0.3-0.2l1.3-4.4C17.9,5.2,17.7,5,17.5,5H9.4C9.2,5,9,4.8,9,4.6V3.4C9,3.2,9.2,3,9.4,3h9.2C19.4,3,20,3.6,20,4.4z">
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
            </div>
        </div>
    </section>
    <section class="suggestion-product py-3">
        <div class="container">
            <h2 class="sale-product-title">Sản phẩm bán chạy nhất</h2>
            <div class="row" style="background-color: #ffffff; border-radius: 25px">
                @foreach ($suggestionProducts as $product)
                    <div class="col-2" style="margin-top: 10px">
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
                                    <span class="price">{{ number_format($product->price_new, 0, ',', '.') }} ₫</span>

                                    @if (!is_null($product->price_old) && $product->price_old > 0)
                                        <span class="compare-price">
                                            {{ number_format($product->price_old, 0, ',', '.') }} ₫
                                        </span>
                                    @endif
                                    <div class="action-cart">
                                        <a href="javascript:void(0);" class="btn-buy btn-views add_to_cart"
                                            data-product-id="{{ $product->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25">
                                                <circle cx="7" cy="17" r="2"></circle>
                                                <circle cx="15" cy="17" r="2"></circle>
                                                <path
                                                    d="M20,4.4V5l-1.8,6.3c-0.1,0.4-0.5,0.7-1,0.7H6.7c-0.4,0-0.8-0.3-1-0.7L3.3,3.9C3.1,3.3,2.6,3,2.1,3H0.4C0.2,3,0,2.8,0,2.6V1.4C0,1.2,0.2,1,0.4,1h2.5c1,0,1.8,0.6,2.1,1.6L5.1,3l2.3,6.8c0,0.1,0.2,0.2,0.3,0.2h8.6c0.1,0,0.3-0.1,0.3-0.2l1.3-4.4C17.9,5.2,17.7,5,17.5,5H9.4C9.2,5,9,4.8,9,4.6V3.4C9,3.2,9.2,3,9.4,3h9.2C19.4,3,20,3.6,20,4.4z">
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
    <section class="daily-recommended py-3">
        <div class="container">
            <h2 class="sale-product-title">Gợi ý cho bạn</h2>
            <div class="row" style="background-color: #ffffff; border-radius: 25px">
                <div class="col-3">
                    <img src="{{ asset('images/banner/recommend.jpg') }}" alt="">
                </div>
                <div class="col-9">
                    <div class="owl-carousel owl-theme" id="carousel-1">
                        @foreach ($recommendedProduct as $product)
                            <div class="item" style="margin-top: 10px">
                                <div class="card-product">
                                    <div class="product-thumbnail sale">
                                        <a class="image_thumb" href="{{ route('product.detail', $product->slug) }}">
                                            <img src="{{ asset($product->thumbnail) }}"
                                                alt="{{ $product->product_name }}">
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
                                            @if (!is_null($product->price_old) && $product->price_old > 0)
                                                <span class="compare-price">
                                                    {{ number_format($product->price_old, 0, ',', '.') }} ₫
                                                </span>
                                            @endif


                                            <div class="action-cart">
                                                <a href="javascript:void(0);" class="btn-buy btn-views add_to_cart"
                                                    data-product-id="{{ $product->id }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="25"
                                                        height="25">
                                                        <circle cx="7" cy="17" r="2"></circle>
                                                        <circle cx="15" cy="17" r="2"></circle>
                                                        <path
                                                            d="M20,4.4V5l-1.8,6.3c-0.1,0.4-0.5,0.7-1,0.7H6.7c-0.4,0-0.8-0.3-1-0.7L3.3,3.9C3.1,3.3,2.6,3,2.1,3H0.4C0.2,3,0,2.8,0,2.6V1.4C0,1.2,0.2,1,0.4,1h2.5c1,0,1.8,0.6,2.1,1.6L5.1,3l2.3,6.8c0,0.1,0.2,0.2,0.3,0.2h8.6c0.1,0,0.3-0.1,0.3-0.2l1.3-4.4C17.9,5.2,17.7,5,17.5,5H9.4C9.2,5,9,4.8,9,4.6V3.4C9,3.2,9.2,3,9.4,3h9.2C19.4,3,20,3.6,20,4.4z">
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
            </div>
        </div>
    </section>
    <section class="banner-offers py-3">
        <div class="container">
            <h2 class="sale-product-title">Gian hàng ưu đãi</h2>
            <div class="row">
                <div class="col-3">
                    <img src="{{ asset('images/banner/banner-offer-1.png') }}" alt="">
                </div>
                <div class="col-3">
                    <img src="{{ asset('images/banner/banner-offer-2.png') }}" alt="">
                </div>
                <div class="col-3">
                    <img src="{{ asset('images/banner/banner-offer-3.png') }}" alt="">
                </div>
                <div class="col-3">
                    <img src="{{ asset('images/banner/banner-offer-4.png') }}" alt="">
                </div>
            </div>
        </div>
    </section>
    <section class="section_blog py-3">
        <div class="container">
            <div class="row" style="background-color: #ffffff; border-radius: 25px">
                <h2 class="sale-product-title py-2">Tin tức mới nhất</h2>
                <div class="col-lg-3 col-md-3 col-8">
                    <div class="item_blog_base">
                        <a class="thumb" href="#!" title="">
                            <img src="{{ asset('images/news/news-1.jpg') }}" alt="" style="height: 162px;">
                        </a>
                        <p>Trên tay Nothing Phone (3a) Pro: Thiết kế trong suốt đầy ấn tượng, hiệu năng mạnh mẽ trong tầm
                            giá</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-8">
                    <div class="item_blog_base">
                        <a class="thumb" href="#!" title="">
                            <img src="{{ asset('images/news/news-2.jpg') }}" alt="">
                        </a>
                        <p>Số máy iPhone bắt đầu bằng chữ M có ý nghĩa gì? Cách nhận biết</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-8">
                    <div class="item_blog_base">
                        <a class="thumb" href="#!" title="">
                            <img src="{{ asset('images/news/news-3.jpg') }}" alt="">
                        </a>
                        <p>OPPO Reno14 series sẽ có màn hình phẳng, camera zoom tiềm vọng theo rò rỉ mới</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-8">
                    <div class="item_blog_base">
                        <a class="thumb" href="#!" title="">
                            <img src="{{ asset('images/news/news-4.jpg') }}" alt="">
                        </a>
                        <p>Tổng Hợp 50+ Hình Nền Máy Tính Đẹp: 4K, Cute, Anime [Tải Miễn Phí]</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@extends('layouts.main') @section('content')
    <section class="cartPage py-4">
        <div class="container">
            <x-breadcrumb-wrapper :breadcrumbs="[
                ['label' => 'Trang chủ', 'url' => route('home')],
                ['label' => 'Kết quả tìm kiếm cho ' . $search],
            ]" />
        </div>

        <div class="container" style="min-height: 350px">
            <div class="rounded p-2 p-md-3 bg-white">
                @if ($results->isNotEmpty())
                    <div class="row">
                        @foreach ($results as $product)
                            <div class="col-2">
                                <div class="card-product">
                                    <div class="product-thumbnail sale" data-sale="Giảm {{ $product->discount }}%">
                                        <a class="image_thumb" href="{{ route('product.detail', $product->slug) }}">
                                            <img src="{{ asset($product->thumbnail) }}"
                                                alt="{{ $product->product_name }}" />
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
                                                    {{ number_format($product->price_old, 0, ',', '.') }}
                                                    ₫
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
                @else
                    <p>Không tìm thấy sản phẩm nào</p>
                @endif
            </div>
        </div>
    </section>
@endsection

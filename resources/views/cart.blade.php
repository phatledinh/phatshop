@extends('layouts.main')

@section('content')
    <section class="cartPage py-4">
        <div class="container">
            <x-breadcrumb-wrapper :breadcrumbs="[
                ['label' => 'Trang chủ', 'url' => route('home')],
                ['label' => 'Giỏ hàng', 'url' => route('cart')],
            ]" />
        </div>
        <div class="container" style="min-height: 350px">
            <div class="rounded p-2 p-md-3 bg-white">
                <h1 class="cart-name font-weight-bold text-uppercase pb-2 pt-2 mb-2">
                    Giỏ hàng
                </h1>
                <div class="row">
                    <div class="col-7">
                        <div class="rounded py-1 cart-info d-flex justify-content-between align-items-center mb-3 border">
                            <div class="allCheck d-flex align-items-center ms-2" style="padding-left: 5px">
                                <div class="form-check me-1">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"
                                        style="width: 30px; height: 30px; border: 1px #000 solid" checked>
                                </div>
                                <span class="cart-number">
                                    @php
                                        $cartCount = 0;
                                        if (Auth::check()) {
                                            $cartCount = \App\Models\CartItem::where('user_id', Auth::id())->sum(
                                                'quantity',
                                            );
                                            Log::info('Cart count for user', [
                                                'user_id' => Auth::id(),
                                                'count' => $cartCount,
                                            ]);
                                        } else {
                                            $cartId = session('cart_id');
                                            if ($cartId) {
                                                $cartCount = \App\Models\CartItem::where('cart_id', $cartId)->sum(
                                                    'quantity',
                                                );
                                                Log::info('Cart count for guest', [
                                                    'cart_id' => $cartId,
                                                    'count' => $cartCount,
                                                ]);
                                            }
                                        }
                                    @endphp
                                    Chọn tất cả ({{ $cartCount }})
                                </span>
                            </div>
                            <div class="allClear me-2">
                                <a class="btn btn-clearcart btn-dark rounded font-weight-bold" href="#!" role="button"
                                    title="Xoá tất cả"><i class="fa-solid fa-trash"></i>Xoá tất cả</a>
                            </div>
                        </div>
                        <div class="row rounded py-3 cart-info align-items-center mb-3 border">
                            @foreach ($cartItems as $item)
                                <div class="col-3 d-flex align-items-center mb-3" id="cart-item-{{ $item->id }}">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"
                                            style="width: 30px; height: 30px; border: 1px #000 solid" checked>
                                    </div>
                                    <img src="{{ asset($item->product->thumbnail) }}" alt="{{ $item->product->name }}"
                                        style="width:100%; height:70px; object-fit:contain;">
                                </div>
                                <div class="col-9 mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <p class="item-title mb-0 font-weight-bold">{{ $item->product->product_name }}</p>
                                        <span
                                            class="text-danger font-weight-bold">{{ number_format($item->product->price_new) }}₫</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="custom input_number_product d-flex align-items-center">
                                            <button class="btn btn-sm btn-outline-secondary btn-minus" type="button"
                                                onclick="updateQuantity({{ $item->id }}, -1)">−</button>
                                            <input type="text" class="form-control mx-2 text-center item_quantity"
                                                value="{{ $item->quantity }}" id="qty-{{ $item->id }}"
                                                onchange="manualQuantity({{ $item->id }})"
                                                style="border-left: #ccc solid 1px; border-right: #ccc solid 1px">
                                            <button class="btn btn-sm btn-outline-secondary btn-plus" type="button"
                                                onclick="updateQuantity({{ $item->id }}, 1)">+</button>
                                        </div>
                                        <button class="btn btn-sm btn-outline-danger js-remove-item-cart ml-3"
                                            onclick="removeItem({{ $item->id }})" title="Xoá"> <i
                                                class="fa-solid fa-trash"></i> Xoá</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="payment-info d-flex justify-content-between rounded">
                            <p class="text-uppercase ms-2">Tổng tiền</p>
                            <p class="cart__summary_total font-weight-bold me-2">
                                {{ number_format($totalPrice, 0, ',', '.') }}đ</p>
                        </div>
                        <a class="btn btn-checkout rounded" href="{{ route('checkout') }}" role="button">ĐẶT
                            HÀNG<br><small>Trả
                                sau hoặc trả online miễn phí</small></a>
                        <div class="m_giftbox mb-3">
                            <fieldset class="free-gifts p-3 pb-2 pb-md-3 rounded position-relative">
                                <legend class="d-flex align-items-center mb-0">
                                    <img alt="Ưu Đãi"
                                        src="//bizweb.dktcdn.net/thumb/icon/100/177/937/themes/881538/assets/gift.gif?1741848900725">
                                    <span class="fw-600 fs-3 ms-1">Ưu Đãi</span>
                                </legend>
                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-6 col-xl-12">
                                        <div class="item line_b pb-2 ">
                                            <strong>Khi mua điện thoại, Camera</strong><br>
                                            🎁Giảm giá 20% (tối đa 200k) phụ kiện đi kèm. Nhập mã: GIAM20DT<a
                                                href="https://trongphumobile.com/phu-kien-dien-thoai"> <span
                                                    style="color:#007ef5;">[Link] </span></a><br>
                                            🎁Giảm giá 20% (tối đa 200k) Tai nghe dây, tai nghe bluetooth, airpod đi kèm.
                                            Nhập mã: GIAM20DT<a href="https://trongphumobile.com/am-thanh"> <span
                                                    style="color:#007ef5;">[Link] </span></a><br>
                                            🎁Giảm giá 20% (tối đa 200k) Khi đổi qua Dán cường lực xịn, chống nhìn
                                            trộm, chống vân tay. Nhập mã: GIAM20DT<a
                                                href="https://trongphumobile.com/dan-man-hinh"> <span
                                                    style="color:#007ef5;">[Link] </span></a><br>
                                            🎁Giảm giá 20% (tối đa 200k) Khi đổi qua bộ sạc xịn, Chính hãng. Nhập mã:
                                            GIAM20DT<a href="https://trongphumobile.com/bo-sac"> <span
                                                    style="color:#007ef5;">[Link] </span></a><br>
                                            🎁Giảm giá 20% (tối đa 200k) Khi mua thẻ nhớ kèm Camera giám sát, Điện
                                            thoại bàn phím. Nhập mã: GIAM20CA<a
                                                href="https://trongphumobile.com/usb-the-nho"> <span
                                                    style="color:#007ef5;">[Link] </span></a><br>
                                            🎁Giảm 5% tối đa 500k khi thanh toán qua Home paylater lần đầu<br>
                                            🎁Giảm giá điện thoại 100k-200k cho học sinh, sinh viên<br>

                                        </div>
                                    </div>
                                    <div class="position-absolute vmore_c w-100 d-md-none">
                                        <a href="javascript:;" class="d-block v_more_coupon text-center font-weight-bold">
                                            <span class="t1">Nhanh tay Ưu đãi có hạn</span>
                                            <span class="t1 d-none">Cảm ơn Quý khách</span>
                                        </a>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

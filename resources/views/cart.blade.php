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
                        <div class="row rounded py-3 cart-info">
                            <div class="col-3">
                                <img src="{{ asset('images/products/phone/iphone-15-plus-xanh-la-128gb.jpg') }}"
                                    alt="" style='width:100%; height:70px; object-fit:contain;'>
                            </div>
                            <div class="col-9">
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="item-title clearfix mb-2">
                                        IPhone 15 Pro Max 1Tb Mới chính hãng
                                    </p>
                                    <span class="font-weight-bold ml-auto text-right"
                                        style="color: #F9420E;">30.890.000₫</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="custom custom-btn-numbers clearfix input_number_product">
                                        <button class="btn-minus btn-cts"
                                            onclick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN(qty) &amp; qty > 1 ) result.value--;return false;"
                                            type="button">–</button>
                                        <input aria-label="Số lượng" class="qty input-text item_quantity" id="qty"
                                            maxlength="3" name="quantity" onchange="if(this.value == 0)this.value=1;"
                                            onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;"
                                            size="4" type="text" value="1">
                                        <button class="btn-plus btn-cts"
                                            onclick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN(qty)) result.value++;return false;"
                                            type="button">+</button>
                                    </div>
                                    <button class="btn btn-outline-danger remove ml-auto js-remove-item-cart" title="Xoá"
                                        data-variantid="124501900">Xoá</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="payment-info d-flex justify-content-between rounded">
                            <p class="text-uppercase ms-2">Tổng tiền</p>
                            <p class="cart__summary_total font-weight-bold me-2">30.890.000&nbsp;₫</p>
                        </div>
                        <a class="btn btn-checkout rounded" href="{{ route('checkout') }}" role="button">ĐẶT
                            HÀNG<br><small>Trả
                                sau hoặc trả online miễn phí</small></a>
                        <a class="btn btn-clearcart btn-dark rounded w-100 font-weight-bold mb-4 mt-2" href="#!"
                            role="button" title="Xoá tất cả">Xoá tất cả</a>
                        <div class="m_giftbox mb-3">
                            <fieldset class="free-gifts p-3 pb-2 pb-md-3 rounded position-relative">
                                <legend class="d-inline-block pl-3 pr-3 mb-0">
                                    <img alt="Ưu Đãi"
                                        src="//bizweb.dktcdn.net/thumb/icon/100/177/937/themes/881538/assets/gift.gif?1741848900725">
                                    Ưu Đãi
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

@extends('layouts.main')

@section('content')
    <section class="checkoutPage py-4">
        <div class="container">
            <a href="{{ route('cart') }}" style="font-size: 18px; color: #74c0fc"><i class="fa-solid fa-chevron-left"></i> Quay
                lại giỏ hàng</a>
            <div class="row py-4">
                <div class="col-8">
                    <div class="totalProduct rounded w-100 h-auto" style="background-color: #FFFFFF">
                        <h4 class="ms-3 py-3">Sản phẩm trong đơn: <span>(1)</span></h4>
                        <div class="rounded py-3 d-flex checkout-info justify-content-between">
                            <div class="checkout-info-thumbnail d-flex">
                                <img src="{{ asset('images/products/phone/iphone-15-plus-xanh-la-128gb.jpg') }}"
                                    alt="" class="rounded">
                                <p class="item-title clearfix ms-2">
                                    IPhone 15 Pro Max 1Tb Mới chính hãng
                                </p>
                            </div>
                            <div class="checkout-info-price me-3">
                                <span class="font-weight-bold ml-auto d-block" style="color: #F9420E;">30.890.000₫</span>
                                <span class="font-weight-bold ml-auto d-block"
                                    style="color: #000; text-decoration:line-through; ">30.890.000₫</span>
                            </div>
                        </div>
                    </div>
                    <div class="infoClient rounded mt-3 py-3" style="background-color: #FFFFFF">
                        <h4 class="ms-3">Thông tin khách hàng</h4>
                        <div>
                            <div class="TextField_wrapperInput rounded">
                                <input class="w-100 rounded ms-1" placeholder="Họ và tên" type="text">
                            </div>
                            <div class="TextField_wrapperInput rounded">
                                <input class="w-100 rounded ms-1" placeholder="Số điện thoại" type="text">
                            </div>
                            <div class="TextField_wrapperInput rounded">
                                <input class="w-100 rounded ms-1" placeholder="Địa chỉ nhận hàng" type="text">
                            </div>
                            <div class="TextField_wrapperInput TextField_wrapperInput-2 rounded">
                                <input class="w-100 rounded ms-1" placeholder="Ghi chú" type="text">
                            </div>
                        </div>

                    </div>
                    <div class="methodPayment rounded mt-3 py-3" style="background-color: #FFFFFF">
                        <h4 class="ms-3">Hình thức thanh toán</h4>
                        <div class="ms-3 me-3">
                            <div class="form-check py-2 rounded">
                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1"
                                    value="option1" checked>
                                <img src="{{ asset('images/cod.png') }}" alt="">
                                <label class="form-check-label" for="exampleRadios1">
                                    Thanh toán khi nhận hàng
                                </label>
                            </div>
                            <div class="form-check py-2 rounded">
                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2"
                                    value="option2">
                                <img src="{{ asset('images/momo.png') }}" alt="">
                                <label class="form-check-label" for="exampleRadios2">
                                    Thanh toán bằng ví MoMo
                                </label>
                            </div>
                            <div class="form-check py-2 rounded">
                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3"
                                    value="option3">
                                <img src="{{ asset('images/zalopay.png') }}" alt="">
                                <label class="form-check-label" for="exampleRadios3">
                                    Thanh toán bằng ví ZaloPay
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="rounded" style="background-color: #FFFFFF">
                        <div class="ms-2 me-2 py-2">
                            <p style="font-size: 20px; font-weight:700;">Thông tin đơn hàng</p>
                            <div class="d-flex w-full align-items-center justify-content-between">
                                <p style="font-size:16px; color:#9e9e9e; font-weight:400;">Tổng tiền</p>
                                <p>17.490.000₫</p>
                            </div>
                            <div class="d-flex w-full align-items-center justify-content-between">
                                <p style="font-size:16px; color:#9e9e9e; font-weight:400;">Tổng khuyến mãi</p>
                                <p>900.000₫</p>
                            </div>
                            <div class="d-flex w-full align-items-center justify-content-between">
                                <p style="font-size:16px; color:#9e9e9e; font-weight:400;">Phí vận chuyển</p>
                                <div class="">Miễn phí</div>
                            </div>
                            <div class="d-flex w-full align-items-center justify-content-between">
                                <p style="font-size:16px; color:#9e9e9e; font-weight:400;">Cần thanh toán</p>
                                <div class="">16.590.000₫</div>
                            </div>
                        </div>
                        <button class="btn w-100 rounded" type="button"
                            style="background-color: #eb3e32; color:#FFFFFF; padding: 10px 0px;">
                            <span>Đặt
                                hàng</span>
                        </button>
                        <div class="text-center py-2">
                            <p style="font-size: 14px; font-weight:400;margin: 0px; padding:0px;">Bằng
                                việc tiến hành đặt mua
                                hàng, bạn đồng ý với
                            </p>
                            <div>
                                <a href="#!" style="text-decoration: underline;font-weight: 700;font-size: 14px;">Điều
                                    khoản dịch
                                    vụ</a> và <a href="#!"
                                    style="text-decoration: underline;font-weight: 700;font-size: 14px;">Chính
                                    sách
                                    xử lý dữ liệu cá nhân
                                </a>
                            </div>
                            <p style="font-size: 14px; font-weight:400;margin: 0px; padding:0px;">của PhatShop</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

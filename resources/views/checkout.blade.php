@extends('layouts.main')

@section('content')
    <section class="checkoutPage py-4">
        <div class="container">
            <a href="{{ route('cart') }}" style="font-size: 18px; color: #74c0fc">
                <i class="fa-solid fa-chevron-left"></i> Quay lại giỏ hàng
            </a>
            <form id="checkoutForm" action="{{ route('order.store') }}" method="POST">
                @csrf
                <div class="row py-4">
                    <div class="col-8">
                        <div class="totalProduct rounded w-100 h-auto" style="background-color: #FFFFFF">
                            <h4 class="ms-3 py-3">Sản phẩm trong đơn: <span>({{ count($cartItems) }})</span></h4>
                            <div class="rounded py-3 checkout-info">
                                <div class="row">
                                    @foreach ($cartItems as $cartItem)
                                        <div class="col-2 mb-3">
                                            <img src="{{ asset($cartItem['product']['thumbnail']) }}"
                                                alt="{{ $cartItem['product']['product_name'] }}"
                                                style="width:100%; height:70px; object-fit:contain;">
                                        </div>
                                        <div class="col-10 d-flex justify-content-between">
                                            <div class="d-flex flex-col ms-2">
                                                <p class="item-title clearfix">
                                                    {{ $cartItem['product']['product_name'] }}
                                                </p>
                                                <span class="fs-5">Số lượng: <span
                                                        class="fs-5 fw-bold">{{ $cartItem['quantity'] }}</span>
                                                </span>
                                            </div>
                                            <div class="checkout-info-price me-3">
                                                <span class="font-weight-bold ml-auto d-block" style="color: #F9420E;">
                                                    {{ number_format($cartItem['product']['price_new']) }}₫
                                                </span>
                                                @if (!empty($cartItem['product']['price_old']))
                                                    <span class="font-weight-bold ml-auto d-block"
                                                        style="color: #000; text-decoration:line-through;">
                                                        {{ number_format($cartItem['product']['price_old']) }}₫
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="infoClient rounded mt-3 py-3" style="background-color: #FFFFFF">
                            <h4 class="ms-3">Thông tin khách hàng</h4>
                            <div class="ps-3 pe-3">
                                <input class="rounded w-100 my-2" placeholder="Họ và tên" type="text" name="name"
                                    value="{{ old('name', $user->name ?? '') }}" required>
                                <input class="rounded w-100 my-2" placeholder="Số điện thoại" type="text" name="phone"
                                    value="{{ old('phone', $user->phone ?? '') }}" required>
                                <input class="rounded w-100 my-2" placeholder="Địa chỉ nhận hàng" type="text"
                                    name="address" value="{{ old('address', $user->address ?? '') }}" required>
                                <input class="rounded w-100 my-2" placeholder="Ghi chú" type="text" name="note"
                                    value="{{ old('note') }}">
                            </div>
                        </div>

                        <div class="methodPayment rounded mt-3 py-3" style="background-color: #FFFFFF">
                            <h4 class="ms-3">Hình thức thanh toán</h4>
                            <div class="ms-3 me-3">
                                <div class="form-check py-2 rounded">
                                    <input class="form-check-input" type="radio" name="payment_method" id="cod"
                                        value="cod" checked>
                                    <img src="{{ asset('images/cod.png') }}" alt="COD" style="width: 30px;">
                                    <label class="form-check-label" for="cod">Thanh toán khi nhận hàng</label>
                                </div>
                                <div class="form-check py-2 rounded">
                                    <input class="form-check-input" type="radio" name="payment_method" id="momo"
                                        value="momo">
                                    <img src="{{ asset('images/momo.png') }}" alt="MoMo" style="width: 30px;">
                                    <label class="form-check-label" for="momo">Thanh toán bằng ví MoMo</label>
                                </div>
                                <div class="form-check py-2 rounded">
                                    <input class="form-check-input" type="radio" name="payment_method" id="vnpay"
                                        value="vnpay">
                                    <img src="{{ asset('images/vnpay.svg') }}" alt="VNPay" style="width: 30px;">
                                    <label class="form-check-label" for="vnpay">Thanh toán bằng VNPay</label>
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
                                    <p>{{ number_format($totalPrice, 0, ',', '.') }}₫</p>
                                </div>
                                <div class="d-flex w-full align-items-center justify-content-between">
                                    <p style="font-size:16px; color:#9e9e9e; font-weight:400;">Tổng khuyến mãi</p>
                                    <p>0₫</p>
                                </div>
                                <div class="d-flex w-full align-items-center justify-content-between">
                                    <p style="font-size:16px; color:#9e9e9e; font-weight:400;">Phí vận chuyển</p>
                                    <div class="">Miễn phí</div>
                                </div>
                                <div class="d-flex w-full align-items-center justify-content-between">
                                    <p style="font-size:16px; color:#9e9e9e; font-weight:400;">Cần thanh toán</p>
                                    <div class="">{{ number_format($totalPrice, 0, ',', '.') }}₫</div>
                                </div>
                            </div>

                            <button class="btn w-100 rounded" type="submit" id="submitBtn"
                                style="background-color: #eb3e32; color:#FFFFFF; padding: 10px 0px;">
                                <span id="submitText">Đặt hàng</span>
                                <span id="loadingSpinner" style="display: none;">
                                    <i class="fas fa-spinner fa-spin"></i> Đang xử lý...
                                </span>
                            </button>

                            <div class="text-center py-2">
                                <p style="font-size: 14px; font-weight:400;margin: 0px; padding:0px;">Bằng việc tiến hành
                                    đặt mua hàng, bạn đồng ý với</p>
                                <div>
                                    <a href="{{ route('terms') }}"
                                        style="text-decoration: underline;font-weight: 700;font-size: 14px;">Điều khoản
                                        dịch vụ</a> và
                                    <a href="{{ route('privacy') }}"
                                        style="text-decoration: underline;font-weight: 700;font-size: 14px;">Chính sách xử
                                        lý dữ liệu cá nhân</a>
                                </div>
                                <p style="font-size: 14px; font-weight:400;margin: 0px; padding:0px;">của PhatShop</p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#checkoutForm').validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 2
                    },
                    phone: {
                        required: true,
                        pattern: /^[0-9]{10,11}$/
                    },
                    address: {
                        required: true,
                        minlength: 5
                    },
                    payment_method: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Vui lòng nhập họ và tên",
                        minlength: "Họ và tên phải có ít nhất 2 ký tự"
                    },
                    phone: {
                        required: "Vui lòng nhập số điện thoại",
                        pattern: "Số điện thoại phải có 10-11 chữ số"
                    },
                    address: {
                        required: "Vui lòng nhập địa chỉ",
                        minlength: "Địa chỉ phải có ít nhất 5 ký tự"
                    },
                    payment_method: {
                        required: "Vui lòng chọn phương thức thanh toán"
                    }
                },
                submitHandler: function(form) {
                    $('#submitBtn').prop('disabled', true);
                    $('#submitText').hide();
                    $('#loadingSpinner').show();
                    form.submit();
                }
            });
        });
    </script>
@endsection

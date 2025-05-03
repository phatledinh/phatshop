@extends('layouts.main')

@section('content')
    <section class="cartPage py-4">
        <div class="container">
            <x-breadcrumb-wrapper :breadcrumbs="[
                ['label' => 'Trang chủ', 'url' => route('home')],
                ['label' => 'Giỏ hàng', 'url' => route('cart.view')],
            ]" />
        </div>
        <div class="container" style="min-height: 350px">
            <div class="rounded p-2 p-md-3 bg-white">
                <h1 class="cart-name font-weight-bold text-uppercase pb-2 pt-2 mb-2">
                    Giỏ hàng
                </h1>
                <div class="row">
                    <div class="col-7">
                        <div class="rounded py-1 cart-info d-flex justify-content-between align-items-center mb-3 border js-cart-info"
                            style="display: {{ $cartItems->isEmpty() ? 'none' : 'flex' }};">
                            <div class="allCheck d-flex align-items-center ms-2" style="padding-left: 5px">
                                <div class="form-check me-1">
                                    <input class="form-check-input" type="checkbox" value="" id="selectAll"
                                        style="width: 30px; height: 30px; border: 1px #000 solid" checked>
                                </div>
                                <span class="cart-number">
                                    Chọn tất cả (<span id="selectedCount">{{ $cartItems->count() }}</span>)
                                </span>
                            </div>
                            <div class="allClear me-2">
                                <a class="btn btn-clearcart btn-dark rounded font-weight-bold" href="#!" role="button"
                                    title="Xoá tất cả">
                                    <i class="fa-solid fa-trash"></i> Xoá tất cả
                                </a>
                            </div>
                        </div>
                        <div class="js-cart-items">
                            @forelse ($cartItems as $item)
                                <div class="row rounded py-3 cart-info align-items-center mb-3 border"
                                    id="cart-item-{{ $item->id }}">
                                    <div class="col-3 d-flex align-items-center mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input item-checkbox" type="checkbox"
                                                value="{{ $item->id }}" id="item-{{ $item->id }}"
                                                data-price="{{ $item->product->price_new * $item->quantity }}"
                                                style="width: 30px; height: 30px; border: 1px #000 solid" checked>
                                        </div>
                                        <img src="{{ asset($item->product->thumbnail) }}"
                                            alt="{{ $item->product->product_name }}"
                                            style="width:100%; height:70px; object-fit:contain;">
                                    </div>
                                    <div class="col-9 mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <p class="item-title mb-0 font-weight-bold">{{ $item->product->product_name }}
                                            </p>
                                            <span class="text-danger font-weight-bold">
                                                {{ number_format($item->product->price_new, 0, ',', '.') }}₫
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="custom input_number_product d-flex align-items-center">
                                                <button class="btn btn-sm btn-outline-secondary btn-minus" type="button"
                                                    data-item-id="{{ $item->id }}">−</button>
                                                <input type="text" class="form-control mx-2 text-center item_quantity"
                                                    value="{{ $item->quantity }}" id="qty-{{ $item->id }}"
                                                    data-item-id="{{ $item->id }}"
                                                    style="border-left: #ccc solid 1px; border-right: #ccc solid 1px">
                                                <button class="btn btn-sm btn-outline-secondary btn-plus" type="button"
                                                    data-item-id="{{ $item->id }}">+</button>
                                            </div>
                                            <button class="btn btn-sm btn-outline-danger js-remove-item-cart ml-3"
                                                data-item-id="{{ $item->id }}" title="Xoá">
                                                <i class="fa-solid fa-trash"></i> Xoá
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="js-empty-cart-message text-center">
                                    Giỏ hàng của bạn đang trống.
                                </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="payment-info d-flex justify-content-between rounded">
                            <p class="text-uppercase ms-2">Tổng tiền</p>
                            <p class="cart__summary_total font-weight-bold me-2" id="totalPrice">
                                {{ number_format($totalPrice, 0, ',', '.') }}₫
                            </p>
                        </div>
                        <button class="btn btn-checkout rounded" onclick="handleCheckout()">
                            ĐẶT HÀNG<br><small>Trả sau hoặc trả online miễn phí</small>
                        </button>
                        <div class="m_giftbox mb-3">
                            <fieldset class="free-gifts p-3 pb-2 pb-md-3 rounded position-relative">
                                <legend class="d-flex align-items-center mb-0">
                                    <img alt="Ưu Đãi"
                                        src="//bizweb.dktcdn.net/thumb/icon/100/177/937/themes/881538/assets/gift.gif?1741848900725">
                                    <span class="fw-600 fs-3 ms-1">Ưu Đãi</span>
                                </legend>
                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-6 col-xl-12">
                                        <div class="item line_b pb-2">
                                            <strong>Khi mua điện thoại, Camera</strong><br>
                                            🎁Giảm giá 20% (tối đa 200k) phụ kiện đi kèm. Nhập mã: GIAM20DT<a
                                                href="https://trongphumobile.com/phu-kien-dien-thoai"> <span
                                                    style="color:#007ef5;">[Link]</span></a><br>
                                            🎁Giảm giá 20% (tối đa 200k) Tai nghe dây, tai nghe bluetooth, airpod đi kèm.
                                            Nhập mã: GIAM20DT<a href="https://trongphumobile.com/am-thanh"> <span
                                                    style="color:#007ef5;">[Link]</span></a><br>
                                            🎁Giảm giá 20% (tối đa 200k) Khi đổi qua Dán cường lực xịn, chống nhìn
                                            trộm, chống vân tay. Nhập mã: GIAM20DT<a
                                                href="https://trongphumobile.com/dan-man-hinh"> <span
                                                    style="color:#007ef5;">[Link]</span></a><br>
                                            🎁Giảm giá 20% (tối đa 200k) Khi đổi qua bộ sạc xịn, Chính hãng. Nhập mã:
                                            GIAM20DT<a href="https://trongphumobile.com/bo-sac"> <span
                                                    style="color:#007ef5;">[Link]</span></a><br>
                                            🎁Giảm giá 20% (tối đa 200k) Khi mua thẻ nhớ kèm Camera giám sát, Điện
                                            thoại bàn phím. Nhập mã: GIAM20CA<a
                                                href="https://trongphumobile.com/usb-the-nho"> <span
                                                    style="color:#007ef5;">[Link]</span></a><br>
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

    <script src="{{ asset('js/cart.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('selectAll');
            const totalPriceElement = document.getElementById('totalPrice');
            const selectedCountElement = document.getElementById('selectedCount');
            const cartInfo = document.querySelector('.js-cart-info');
            const emptyCartMessage = document.querySelector('.js-empty-cart-message');

            function updateSummary() {
                const itemCheckboxes = document.querySelectorAll('.item-checkbox');
                let selectedCount = 0;
                let totalPrice = 0;

                itemCheckboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        selectedCount++;
                        const price = parseFloat(checkbox.getAttribute('data-price')) || 0;
                        totalPrice += price;
                    }
                });

                if (selectedCountElement) selectedCountElement.textContent = selectedCount;
                if (totalPriceElement) totalPriceElement.textContent = totalPrice.toLocaleString('vi-VN') + '₫';

                if (selectAllCheckbox) selectAllCheckbox.checked = selectedCount === itemCheckboxes.length &&
                    selectedCount > 0;

                if (selectedCount === 0 && itemCheckboxes.length === 0) {
                    if (cartInfo) cartInfo.style.display = 'none';
                    if (emptyCartMessage) emptyCartMessage.style.display = 'block';
                } else {
                    if (cartInfo) cartInfo.style.display = 'flex';
                    if (emptyCartMessage) emptyCartMessage.style.display = 'none';
                }
            }

            // Gắn sự kiện cho checkbox "Chọn tất cả"
            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function() {
                    const itemCheckboxes = document.querySelectorAll('.item-checkbox');
                    itemCheckboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                    updateSummary();
                });
            }

            // Gắn sự kiện cho từng checkbox
            document.querySelectorAll('.item-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', updateSummary);
            });

            // Gắn sự kiện cho nút tăng/giảm số lượng (giữ nguyên logic cũ)
            document.querySelectorAll('.btn-minus').forEach(button => {
                button.addEventListener('click', () => {
                    const itemId = button.dataset.itemId;
                    updateQuantity(itemId, -1);
                });
            });

            document.querySelectorAll('.btn-plus').forEach(button => {
                button.addEventListener('click', () => {
                    const itemId = button.dataset.itemId;
                    updateQuantity(itemId, 1);
                });
            });

            document.querySelectorAll('.item_quantity').forEach(input => {
                input.addEventListener('change', () => {
                    const itemId = input.dataset.itemId;
                    manualQuantity(itemId);
                });
            });

            // Lắng nghe sự kiện updateSummary từ cart.js
            document.addEventListener('updateSummary', updateSummary);

            // Tính toán ban đầu
            updateSummary();
        });

        // Handle checkout button click
        function handleCheckout() {
            @if (Auth::check())
                const selectedItems = [];
                document.querySelectorAll('.item-checkbox:checked').forEach(checkbox => {
                    selectedItems.push(checkbox.value);
                });

                if (selectedItems.length === 0) {
                    alert('Vui lòng chọn ít nhất một sản phẩm để đặt hàng.');
                    return;
                }

                fetch("{{ route('checkout.store') }}", {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            selectedItems: selectedItems
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Có lỗi xảy ra khi gửi yêu cầu.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            window.location.href = data.redirect || "{{ route('checkout') }}";
                        } else {
                            alert(data.message || 'Có lỗi xảy ra, vui lòng thử lại.');
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi:', error);
                        alert('Có lỗi xảy ra: ' + error.message);
                    });
            @else
                alert('Vui lòng đăng nhập để tiếp tục đặt hàng.');
                window.location.href = "{{ route('login') }}";
            @endif
        }

        // Các hàm updateQuantity, manualQuantity, updateCartItem, và updateCartDisplay giữ nguyên logic cũ
        function updateQuantity(itemId, change) {
            const input = document.getElementById("qty-" + itemId);
            let quantity = parseInt(input.value) + change;
            if (quantity < 1) quantity = 1;
            updateCartItem(itemId, quantity);
        }

        function manualQuantity(itemId) {
            const input = document.getElementById("qty-" + itemId);
            let quantity = parseInt(input.value);
            if (isNaN(quantity) || quantity < 1) {
                quantity = 1;
                input.value = quantity;
            }
            updateCartItem(itemId, quantity);
        }

        function updateCartItem(itemId, quantity) {
            fetch("/cart/update/" + itemId, {
                    method: "PUT",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                        Accept: "application/json",
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        quantity: quantity
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (data.deleted) {
                            const itemElement = document.getElementById("cart-item-" + itemId);
                            if (itemElement) itemElement.remove();
                        } else {
                            const input = document.getElementById("qty-" + itemId);
                            input.value = data.quantity;
                            const checkbox = document.getElementById("item-" + itemId);
                            if (checkbox && data.price) {
                                checkbox.setAttribute("data-price", data.price * data.quantity);
                            }
                        }
                        updateCartDisplay(data);
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("Có lỗi xảy ra khi cập nhật số lượng!");
                });
        }

        function updateCartDisplay(data) {
            const totalPriceElement = document.getElementById("totalPrice");
            const selectedCountElement = document.getElementById("selectedCount");
            const cartInfo = document.querySelector(".js-cart-info");
            const emptyCartMessage = document.querySelector(".js-empty-cart-message");
            const cartCountElement = document.querySelector(".js-cart-count");

            if (totalPriceElement) {
                totalPriceElement.textContent = (data.total || 0).toLocaleString("vi-VN") + "₫";
            }

            if (selectedCountElement) {
                selectedCountElement.textContent = data.count || 0;
            }

            if (cartCountElement) {
                cartCountElement.textContent = data.count || 0;
            } else {
                console.warn("Cart count element (.js-cart-count) not found in DOM");
                document.dispatchEvent(new CustomEvent("updateCartCount", {
                    detail: {
                        count: data.count || 0
                    }
                }));
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
    </script>
@endsection

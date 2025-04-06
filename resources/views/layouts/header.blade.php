<!-- resources/views/layouts/header.blade.php -->
<header>
    <div class="container d-flex justify-content-between align-items-center">
        <a href="/" class="header__logo" aria-label="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="img-fluid">
        </a>

        <form action="/tim-kiem" class="header__search">
            <input id="skw" type="text" class="input-search" placeholder="Bạn tìm gì..." name="key" autocomplete="off"
                maxlength="100">
            <button type="submit" aria-label="button suggest search">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
            <div id="search-result" style="display: none;"></div>
        </form>

        <div class="others d-flex">
            <div class="profile">
                <a href="/login" class="name-order active">
                    <i class="fa-solid fa-user"></i> Đăng nhập
                </a>
            </div>
            <div class="box-cart">
                <a href="/cart">
                    <i class="fa-solid fa-cart-shopping"></i> Giỏ hàng
                    <span class="cart-number"></span>
                </a>
            </div>
        </div>
    </div>
</header>
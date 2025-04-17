<!-- resources/views/layouts/header.blade.php -->
<!-- resources/views/layouts/header.blade.php -->
<header>
    <div class="container d-flex justify-content-between align-items-center">
        <a href="/" class="header__logo" aria-label="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="img-fluid">
        </a>

        <form action="/tim-kiem" class="header__search ">
            <input id="skw" type="text" class="input-search" placeholder="Bạn tìm gì..." name="key"
                autocomplete="off" maxlength="100">
            <button type="submit" aria-label="button suggest search">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
            <div id="search-result" style="display: none;"></div>
        </form>

        <div class="others d-flex">
            <div class="profile">
                @if (Auth::check())
                    <div class="dropdown">
                        <a href="#" class="name-order dropdown-toggle" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fa-solid fa-user"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Tài khoản</a></li>
                            <li><a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Đăng xuất
                                </a></li>
                        </ul>
                    </div>

                    <!-- Form logout -->
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @else
                    <a href="{{ route('login') }}" class="name-order active">
                        <i class="fa-solid fa-user"></i> Đăng nhập
                    </a>
                @endif
            </div>

            <!-- Giỏ hàng -->
            <div class="box-cart">
                <a href="{{ route('cart.view') }}">
                    <i class="fa-solid fa-cart-shopping"></i> Giỏ hàng
                    <span class="cart-number">0</span>
                </a>
            </div>
        </div>
    </div>
</header>

<nav class="nav-home">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="dropdown show">
                    <button class="btn" type="button" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Danh mục sản phẩm
                    </button>
                    <ul class="dropdown-menu show">
                        <li class="d-flex">
                            <img src="{{ asset('images/icons/phonne-24x24.png') }}" alt="">
                            <a class="dropdown-item" href="{{ route('category.detail', 'dien-thoai') }}">Điện thoại</a>
                        </li>
                        <li class="d-flex">
                            <img src="{{ asset('images/icons/laptop-24x24.png') }}" alt="">
                            <a class="dropdown-item" href="{{ route('category.detail', 'laptop') }}">Laptop</a>
                        </li>
                        <li class="dropdown-submenu position-relative">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('images/icons/phu-kien-24x24.png') }}" alt="">
                                    <a class="dropdown-item" href="{{ route('category.detail', 'phu-kien') }}">Phụ
                                        kiện</a>
                                </div>
                                <i class="fa-solid fa-sort-down"></i>
                            </div>
                            <!-- Mega menu -->
                            <div class="mega-menu position-absolute">
                                <div class="row">
                                    <div class="col">
                                        <a class="dropdown-item" href="{{ route('category.detail', 'loa') }}">
                                            <img src="{{ asset('images/icons/loa.png') }}" alt="Loa">
                                            Loa
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-item" href="{{ route('category.detail', 'tai-nghe') }}">
                                            <img src="{{ asset('images/icons/tainghe.png') }}" alt="Tai nghe">
                                            Tai nghe
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-item"
                                            href="{{ route('category.detail', 'chuot-may-tinh') }}">
                                            <img src="{{ asset('images/icons/chuot.png') }}" alt="Chuột máy tính">
                                            Chuột máy tính
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-item" href="{{ route('category.detail', 'ban-phim') }}">
                                            <img src="{{ asset('images/icons/keyboard.png') }}" alt="Bàn phím">
                                            Bàn phím
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex">
                            <img src="{{ asset('images/icons/smartwatch-24x24.png') }}" alt="">
                            <a class="dropdown-item" href="{{ route('category.detail', 'smartwatch') }}">Smartwatch</a>
                        </li>
                        <li class="d-flex">
                            <img src="{{ asset('images/icons/watch-24x24.png') }}" alt="">
                            <a class="dropdown-item" href="{{ route('category.detail', 'dong-ho') }}">Đồng hồ</a>
                        </li>
                        <li class="d-flex">
                            <img src="{{ asset('images/icons/tablet-24x24.png') }}" alt="">
                            <a class="dropdown-item" href="{{ route('category.detail', 'tablet') }}">Tablet</a>
                        </li>
                        <li class="d-flex">
                            <img src="{{ asset('images/icons/may-cu-24x24.png') }}" alt="">
                            <a class="dropdown-item" href="{{ route('category.detail', 'PC') }}">Màn hình</a>
                        </li>
                        <li class="d-flex">
                            <img src="{{ asset('images/icons/PC-24x24.png') }}" alt="">
                            <a class="dropdown-item" href="{{ route('category.detail', 'may-in') }}">Máy in</a>
                        </li>
                        <li class="d-flex">
                            <img src="{{ asset('images/icons/sim-24x24.png') }}" alt="">
                            <a class="dropdown-item" href="{{ route('category.detail', 'may-choi-game') }}">Máy chơi
                                game</a>
                        </li>
                        <li class="d-flex">
                            <img src="{{ asset('images/icons/tien-ich-24x24.png') }}" alt="">
                            <a class="dropdown-item" href="{{ route('category.detail', 'camera') }}">Camera</a>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="col-md-9">
                <nav class="navbar navbar-expand-lg">
                    <div class="container-fluid">
                        <ul class="navbar-nav">
                            <li
                                class="me-4 nav-item d-flex justify-content-center align-items-center flex-grow-1 h-100">
                                <a href="{{ route('home') }}"
                                    class="{{ Route::currentRouteName() == 'home' ? 'fw-bold' : '' }}">
                                    Trang chủ
                                </a>
                            </li>
                            <li
                                class="me-4 nav-item d-flex justify-content-center align-items-center flex-grow-1 h-100">
                                <a href="{{ route('about') }}"
                                    class="{{ Route::currentRouteName() == 'about' ? 'fw-bold' : '' }}">
                                    Giới thiệu
                                </a>
                            </li>
                            <li
                                class="me-4 nav-item d-flex justify-content-center align-items-center flex-grow-1 h-100">
                                <div class="dropdown">
                                    <a class="dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Sản phẩm
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('category.detail', 'dien-thoai') }}">Điện thoại</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('category.detail', 'laptop') }}">Laptop</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('category.detail', 'phu-kien') }}">Phụ
                                                kiện</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('category.detail', 'smartwatch') }}">Smartwatch</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('category.detail', 'dong-ho') }}">Đồng hồ</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('category.detail', 'tablet') }}">Tablet</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('category.detail', 'PC') }}">Màn
                                                hình</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('category.detail', 'may-in') }}">Máy in</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('category.detail', 'may-choi-game') }}">Máy chơi
                                                game
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('category.detail', 'camera') }}">Camera</a>
                                        </li>

                                    </ul>
                                </div>
                            </li>
                            <li
                                class="me-4 nav-item d-flex justify-content-center align-items-center flex-grow-1 h-100">
                                <a href="{{ route('news') }}"
                                    class="{{ Route::currentRouteName() == 'news' ? 'fw-bold' : '' }}">
                                    Tin mới nhất
                                </a>
                            </li>
                            <li
                                class="me-4 nav-item d-flex justify-content-center align-items-center flex-grow-1 h-100">
                                <a href="{{ route('ask') }}"
                                    class="{{ Route::currentRouteName() == 'ask' ? 'fw-bold' : '' }}">
                                    Câu hỏi thường gặp
                                </a>
                            </li>
                            <li
                                class="me-4 nav-item d-flex justify-content-center align-items-center flex-grow-1 h-100">
                                <a href="{{ route('cruit') }}"
                                    class="{{ Route::currentRouteName() == 'cruit' ? 'fw-bold' : '' }}">
                                    Tuyển dụng
                                </a>
                            </li>
                            <li
                                class="me-4 nav-item d-flex justify-content-center align-items-center flex-grow-1 h-100">
                                <a href="{{ route('contact') }}"
                                    class="{{ Route::currentRouteName() == 'contact' ? 'fw-bold' : '' }}">
                                    Liên hệ
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</nav>

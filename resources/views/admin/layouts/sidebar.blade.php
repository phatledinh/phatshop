<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <a class="nav-link" href="{{ route('admin') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    Tổng quan
                </a>

                <!-- Danh mục -->
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseCategory"
                    aria-expanded="false" aria-controls="collapseCategory">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-columns"></i>
                    </div>
                    Danh mục
                    <div class="sb-sidenav-collapse-arrow">
                        <i class="fas fa-angle-down"></i>
                    </div>
                </a>
                <div class="collapse" id="collapseCategory" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('listCategory') }}">Danh sách danh mục</a>
                        <a class="nav-link" href="{{ route('categories.create') }}">Thêm danh mục</a>
                    </nav>
                </div>

                <!-- Sản phẩm -->
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseProduct"
                    aria-expanded="false" aria-controls="collapseProduct">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-box"></i>
                    </div>
                    Sản phẩm
                    <div class="sb-sidenav-collapse-arrow">
                        <i class="fas fa-angle-down"></i>
                    </div>
                </a>
                <div class="collapse" id="collapseProduct" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('listProduct') }}">Danh sách sản phẩm</a>
                        <a class="nav-link" href="{{ route('products.create') }}">Thêm sản phẩm</a>
                    </nav>
                </div>

                <!-- Tin tức -->
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseNews"
                    aria-expanded="false" aria-controls="collapseNews">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    Tin tức
                    <div class="sb-sidenav-collapse-arrow">
                        <i class="fas fa-angle-down"></i>
                    </div>
                </a>
                <div class="collapse" id="collapseNews" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('listNews') }}">Danh sách tin tức</a>
                        <a class="nav-link" href="{{ route('news.create') }}">Thêm tin tức</a>
                    </nav>
                </div>

                <a class="nav-link" href="{{ route('listOrder') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-chart-area"></i>
                    </div>
                    Đơn hàng
                </a>
                <!-- Khách hàng -->
                <a class="nav-link" href="{{ route('listCustomer') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-chart-area"></i>
                    </div>
                    Khách hàng
                </a>
            </div>
        </div>
    </nav>
</div>

@extends('admin.layouts.main')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Dashboard</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="row mb-4">
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card board1 fill1">
                        <div class="card-body bg-info d-flex align-items-center justify-content-between">
                            <div class="card_widget_header">
                                <label class="fw-bold fs-3">Khách hàng</label>
                                <h4>{{ $totalCustomer }}</h4>
                            </div>
                            <div class="card_widget_img">
                                <i class="fa-solid fa-users fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card board1 fill2">
                        <div class="card-body bg-danger d-flex align-items-center justify-content-between">
                            <div class="card_widget_header">
                                <label class="fw-bold fs-3">Danh mục</label>
                                <h4>{{ $totalCategory }}</h4>
                            </div>
                            <div class="card_widget_img">
                                <i class="fa-solid fa-list fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card board1 fill3">
                        <div class="card-body bg-warning d-flex align-items-center justify-content-between">
                            <div class="card_widget_header">
                                <label class="fw-bold fs-3">Sản phẩm</label>
                                <h4>{{ $totalProduct }}</h4>
                            </div>
                            <div class="card_widget_img">
                                <i class="fa-brands fa-product-hunt fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card board1 fill4">
                        <div class="card-body bg-success d-flex align-items-center justify-content-between">
                            <div class="card_widget_header">
                                <label class="fw-bold fs-3">Bài viết</label>
                                <h4>{{ $totalNews }}</h4>
                            </div>
                            <div class="card_widget_img">
                                <i class="fa-solid fa-newspaper fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Biểu đồ Doanh thu theo Tháng (2025)
                        </div>
                        <div class="card-body">
                            <canvas id="myBarChart" width="100%" height="40"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Top 10 Khách hàng tiềm năng nhất (Tháng này)
                        </div>
                        <div class="card-body">
                            <canvas id="topCustomersChart" width="100%" height="40"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Sản phẩm bán chạy nhất
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Danh mục</th>
                                <th>Hãng</th>
                                <th>Giá</th>
                                <th>Trong kho</th>
                                <th>Đã bán</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>STT</th>
                                <th>Ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Danh mục</th>
                                <th>Hãng</th>
                                <th>Giá</th>
                                <th>Trong kho</th>
                                <th>Đã bán</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($products as $index => $product)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <img src="{{ asset($product->thumbnail) }}" alt=""
                                            style="
                                                width: 60px;
                                                height: 80px;
                                                object-fit: contain;
                                            " />
                                    </td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ $product->brand->name }}</td>
                                    <td>
                                        <div class="price-box">
                                            <span class="price d-block fw-bold">
                                                {{ number_format($product->price_new, 0, ',', '.') }} ₫
                                            </span>
                                            @if (!is_null($product->price_old) && $product->price_old > 0)
                                                <span class="compare-price d-block fw-bold"
                                                    style="text-decoration: line-through; color: red">
                                                    {{ number_format($product->price_old, 0, ',', '.') }} ₫
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{ $product->stock }}</td>
                                    <td>{{ $product->sold }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <script>
        window.revenueData = @json($revenueData);
        window.topCustomers = @json($topCustomers);
    </script>
    <script src="{{ asset('js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('js/demo/chart-demo.js') }}"></script>
@endsection

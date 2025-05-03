@extends('admin.layouts.main')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Danh sách sản phẩm
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
                                <th>Tùy chọn</th>
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
                                <th>Tùy chọn</th>
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
                                            <span
                                                class="price d-block fw-bold">{{ number_format($product->price_new, 0, ',', '.') }}
                                                ₫</span>

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
                                    <td>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <a href="detailEmployee.html" class="btn btn-info text-white"><i
                                                    class="fa-solid fa-eye"></i>
                                                Xem</a>

                                            <a href="editEmployee.html" class="btn btn-warning text-white ms-2"><i
                                                    class="fa-solid fa-user-pen"></i>
                                                Sửa</a>

                                            <button type="button" class="btn btn-danger ms-2">
                                                <i class="fa-solid fa-trash-can"></i>
                                                Xóa
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection

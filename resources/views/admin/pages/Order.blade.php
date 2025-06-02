@extends('admin.layouts.main')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Danh sách đơn hàng
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên khách hàng</th>
                                <th>Số điện thoại</th>
                                <th>Địa chỉ</th>
                                <th>Chi tiết</th>
                                <th>Phương thức thanh toán</th>
                                <th>Tổng tiền</th>
                                <th>Ngày đặt</th>
                                <th>Trạng thái giao hàng</th>
                                <th>Xử lý</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>STT</th>
                                <th>Tên khách hàng</th>
                                <th>Số điện thoại</th>
                                <th>Địa chỉ</th>
                                <th>Chi tiết</th>
                                <th>Phương thức thanh toán</th>
                                <th>Tổng tiền</th>
                                <th>Ngày đặt</th>
                                <th>Trạng thái giao hàng</th>
                                <th>Xử lý</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($orders as $index => $order)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $order->name }}</td>
                                    <td>{{ $order->phone }}</td>
                                    <td>{{ $order->address }}</td>
                                    <td>
                                        @if ($order->orderItems && $order->orderItems->count() > 0)
                                            @foreach ($order->orderItems as $item)
                                                <div>
                                                    <img src="{{ asset($item->product->thumbnail) }}"
                                                        alt="{{ $item->product->product_name }}"
                                                        style="width: 50px; height: 50px;">
                                                    <span>{{ $item->product->product_name }}</span> (SL:
                                                    {{ $item->quantity }})
                                                </div>
                                            @endforeach
                                        @else
                                            <span>Không có sản phẩm</span>
                                        @endif
                                    </td>
                                    <td>{{ $order->payment_method }}</td>
                                    <td>{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</td>
                                    <td>{{ $order->created_at }}</td>
                                    <td>
                                        <button type="button"
                                            class="btn {{ $order->delivery_status == 'Đã giao' ? 'btn-success' : ($order->delivery_status == 'Đã hủy' ? 'btn-danger' : 'btn-warning') }}">
                                            <span
                                                class="status-{{ str_replace(' ', '-', strtolower($order->delivery_status)) }}">
                                                {{ $order->delivery_status }}
                                            </span>
                                        </button>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.orders.update_status', $order->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <select name="delivery_status" onchange="this.form.submit()"
                                                {{ $order->delivery_status != 'Đang giao' ? 'disabled' : '' }}>
                                                <option value="Đang giao"
                                                    {{ $order->delivery_status == 'Đang giao' ? 'selected' : '' }}>Đang
                                                    giao</option>
                                                <option value="Đã hủy"
                                                    {{ $order->delivery_status == 'Đã hủy' ? 'selected' : '' }}>Đã hủy
                                                </option>
                                                <option value="Đã giao"
                                                    {{ $order->delivery_status == 'Đã giao' ? 'selected' : '' }}>Đã giao
                                                </option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <style>
        .status-dang-giao {
            color: #333;
        }

        .status-da-giao {
            color: #fff;
        }

        .status-da-huy {
            color: #fff;
        }
    </style>
@endsection

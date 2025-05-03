@extends('layouts.main')

@section('content')
    <section class="order-success py-4">
        <div class="container text-center">
            <h1>Đặt hàng thành công!</h1>
            <p>Cảm ơn bạn đã đặt hàng. Chúng tôi sẽ liên hệ sớm để xác nhận.</p>
            <a href="{{ route('home') }}" class="btn btn-primary">Quay lại trang chủ</a>
        </div>
    </section>
@endsection

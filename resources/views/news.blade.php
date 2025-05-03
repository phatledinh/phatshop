@extends('layouts.main')

@section('content')
    <section class="news py-4">
        <div class="container">
            <x-breadcrumb-wrapper :breadcrumbs="[
                ['label' => 'Trang chủ', 'url' => route('home')],
                ['label' => 'Tin tức', 'url' => route('news')],
            ]" />
        </div>
        <div class="container">
            <ul class="nav nav-tabs d-flex align-items-center w-100" id="myTab" role="tablist" style="height: 80px;">
                <li class="nav-item" style="border: 1px solid #ffffff; border-radius: none; background-color: #ffffff"
                    role="presentation">
                    <button class="nav-link w-100 h-100 active" id="flashsale-tab" data-bs-toggle="tab"
                        data-bs-target="#flashsale-tab-pane" type="button" role="tab"
                        aria-controls="flashsale-tab-pane" aria-selected="true" style="color: black;">Khuyến mãi</button>
                </li>
                <li class="nav-item" style="border: 1px solid #ffffff; background-color: #ffffff" role="presentation">
                    <button class="nav-link w-100 h-100" id="phone-tab" data-bs-toggle="tab"
                        data-bs-target="#phone-tab-pane" type="button" role="tab" aria-controls="phone-tab-pane"
                        aria-selected="false" style="color: black;">Đánh giá - Tư vấn</button>
                </li>
                <li class="nav-item" style="border: 1px solid #ffffff; border-radius: none; background-color: #ffffff"
                    role="presentation">
                    <button class="nav-link w-100 h-100" id="laptop-tab" data-bs-toggle="tab"
                        data-bs-target="#laptop-tab-pane" type="button" role="tab" aria-controls="laptop-tab-pane"
                        aria-selected="false" style="color: black;">Thủ thuật</button>
                </li>
                <li class="nav-item" style="border: 1px solid #ffffff; border-radius: none; background-color: #ffffff"
                    role="presentation">
                    <button class="nav-link w-100 h-100" id="accessory-tab" data-bs-toggle="tab"
                        data-bs-target="#accessory-tab-pane" type="button" role="tab"
                        aria-controls="accessory-tab-pane" aria-selected="false" style="color: black;">Hỏi đáp</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="flashsale-tab-pane" role="tabpanel"
                    aria-labelledby="flashsale-tab" tabindex="0">
                    <div class="row rounded py-2" style="background: #ffffff">
                        <h3 class="fs-1 fw-600">Khuyến mãi</h3>
                        <div class="col-6">
                            <div class="item_blog_base">
                                <a class="thumb" href="#!" title="">
                                    <img src="{{ asset('images/news/news-1.jpg') }}" alt="">
                                </a>
                                <h4 class="fs-2 py-1">aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</h4>
                                <p>Trên tay Nothing Phone (3a) Pro: Thiết kế trong suốt đầy ấn tượng, hiệu năng mạnh mẽ
                                    trong tầm
                                    giá</p>
                                <span><i class="fa-solid fa-clock pe-2"></i>1 ngày trước</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-6">
                                    <div class="item_blog_base">
                                        <a class="thumb" href="#!" title="">
                                            <img src="{{ asset('images/news/news-1.jpg') }}" alt="">
                                        </a>
                                        <h4 class="fs-5 py-1">aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</h4>
                                        <span><i class="fa-solid fa-clock pe-2"></i>1 ngày trước</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="item_blog_base">
                                        <a class="thumb" href="#!" title="">
                                            <img src="{{ asset('images/news/news-1.jpg') }}" alt="">
                                        </a>
                                        <h4 class="fs-5 py-1">aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</h4>
                                        <span><i class="fa-solid fa-clock pe-2"></i>1 ngày trước</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="item_blog_base">
                                        <a class="thumb" href="#!" title="">
                                            <img src="{{ asset('images/news/news-1.jpg') }}" alt="">
                                        </a>
                                        <h4 class="fs-5 py-1">aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</h4>
                                        <span><i class="fa-solid fa-clock pe-2"></i>1 ngày trước</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="item_blog_base">
                                        <a class="thumb" href="#!" title="">
                                            <img src="{{ asset('images/news/news-1.jpg') }}" alt="">
                                        </a>
                                        <h4 class="fs-5 py-1">aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</h4>
                                        <span><i class="fa-solid fa-clock pe-2"></i>1 ngày trước</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="phone-tab-pane" role="tabpanel" aria-labelledby="phone-tab"
                    tabindex="0">

                </div>
                <div class="tab-pane fade" id="laptop-tab-pane" role="tabpanel" aria-labelledby="laptop-tab"
                    tabindex="0">

                </div>
                <div class="tab-pane fade" id="accessory-tab-pane" role="tabpanel" aria-labelledby="accessory-tab"
                    tabindex="0">

                </div>
            </div>
        </div>
    </section>
@endsection

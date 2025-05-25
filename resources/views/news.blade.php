@extends('layouts.main')

@section('content')
    <section class="news py-4">
        <div class="container">
            <x-breadcrumb-wrapper :breadcrumbs="[
                ['label' => 'Trang chủ', 'url' => route('home')],
                ['label' => 'Tin tức', 'url' => route('news')],
            ]" />
        </div>
        <div class="container p-2" style="background-color: #ffffff; border-radius: 25px">
            <h3 class="fs-1 fw-600">Khuyến mãi</h3>
            <div class="row">
                @if (isset($saleNews[0]))
                    <div class="col-6">
                        <div class="item_blog_base">
                            <a class="thumb" href="{{ route('detailNews', $saleNews[0]->id) }}"
                                title="{{ $saleNews[0]->title }}">
                                <img src="{{ $saleNews[0]->image }}" alt="">
                            </a>
                            <h4 class="fs-2 py-1"
                                style="font-size: 24px !important; font-weight: 600 !important;line-height: 24px !important;display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
           overflow: hidden; text-overflow: ellipsis;">
                                {{ $saleNews[0]->title }}</h4>
                            {!! $saleNews[0]->excerpt !!}
                            <div class="d-flex">
                                <span><i
                                        class="fa-solid fa-clock pe-2"></i>{{ $saleNews[0]->created_at->diffForHumans() }}</span>
                                <span class="ps-3"><i class="fa-solid fa-user pe-2"></i>{{ $saleNews[0]->author }}</span>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="col-6">
                    <div class="row">
                        @foreach ($saleNews->slice(1, 4) as $news)
                            <div class="col-6">
                                <div class="item_blog_base">
                                    <a class="thumb" href="{{ route('detailNews', $news->id) }}"
                                        title="{{ $news->title }}">
                                        <img src="{{ $news->image }}" alt="">
                                    </a>
                                    <h4 class="fs-5 py-1"
                                        style="font-size: 16px !important; font-weight: 600 !important;line-height: 24px !important;display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
           overflow: hidden; text-overflow: ellipsis;">
                                        {{ $news->title }}</h4>
                                    <div class="d-flex">
                                        <span><i
                                                class="fa-solid fa-clock pe-2"></i>{{ $saleNews[0]->created_at->diffForHumans() }}</span>
                                        <span class="ps-3"><i
                                                class="fa-solid fa-user pe-2"></i>{{ $saleNews[0]->author }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
        <div class="container p-2 mt-3" style="background-color: #ffffff; border-radius: 25px">
            <h3 class="fs-1 fw-600">Bài viết nổi bật</h3>
            <div class="row" style="background-color: #ffffff; border-radius: 25px">
                @foreach ($suggesNews as $news)
                    <div class="col-lg-3 col-md-3 col-8">
                        <div class="item_blog_base">
                            <a class="thumb" href="{{ route('detailNews', $news->id) }}" title="">
                                <img src="{{ asset($news->image) }}" alt="" style="height: 162px;">
                            </a>
                            <h4 class="fs-2 py-1"
                                style="font-size: 20px !important; font-weight: 600 !important;line-height: 24px !important;display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
           overflow: hidden; text-overflow: ellipsis;">
                                {{ $news->title }}</h4>
                            {!! $news->excerpt !!}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="container p-2 mt-3" style="background-color: #ffffff; border-radius: 25px">
            <div class="row">
                <div class="col-7">
                    <h3 class="fs-1 fw-600">Tin tức</h3>
                    @foreach ($topNews as $news)
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-3">
                                    <a class="thumb" href="{{ route('detailNews', $news->id) }}" title="">
                                        <img src="{{ asset($news->image) }}" alt="" style="height: 162px;">
                                    </a>
                                </div>
                                <div class="col-9">
                                    <h4
                                        style="font-size: 20px !important; font-weight: 600 !important;line-height: 24px !important;display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
           overflow: hidden; text-overflow: ellipsis;">
                                        {{ $news->title }}</h4>
                                    {!! $news->excerpt !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-5">
                    <div class="p-1" style="border: 0 solid #e5e7eb; border-radius: 25px">
                        <h3 class="fs-1 fw-600 text-center">Bài viết mới nhất</h3>
                        @foreach ($newNews as $news)
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-3">
                                        <a class="thumb" href="{{ route('detailNews', $news->id) }}" title="">
                                            <img src="{{ asset($news->image) }}">
                                        </a>
                                    </div>
                                    <div class="col-9">
                                        <h4
                                            style="font-size: 20px !important; font-weight: 600 !important;line-height: 24px !important;display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
           overflow: hidden; text-overflow: ellipsis;">
                                            {{ $news->title }}</h4>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

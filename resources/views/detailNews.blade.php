@extends('layouts.main')

@section('content')
    <section class="detailsPage">
        <div class="container py-3">
            <x-breadcrumb-wrapper :breadcrumbs="[
                ['label' => 'Trang chủ', 'url' => route('home')],
                ['label' => 'Tin tức', 'url' => route('news')],
                ['label' => 'Bài viết'],
            ]" />
        </div>

        <div class="container p-2">
            <div class="row">
                <div class="col-6"></div>
                <div class="col-6">
                    <div class="d-flex mb-3">
                        <span><i class="fa-solid fa-user pe-2"></i>{{ $news->author }}</span>
                        <span class="ps-3"><i
                                class="fa-solid fa-clock pe-2"></i>{{ $news->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <img src="{{ asset($news->image) }}" alt="{{ $news->title }}" class="img-fluid mb-3">
                </div>
                <div class="col-6">
                    <h1 class="fs-1 fw-600">{{ $news->title }}</h1>
                    {!! $news->excerpt !!}
                </div>
            </div>
            <div class="content-wrapper">
                <div class="content">
                    {!! $news->content !!}
                </div>
            </div>
        </div>
    </section>
@endsection

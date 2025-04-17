@extends('layouts.main')

@section('content')
    <section class="news py-4">
        <div class="container">
            <x-breadcrumb-wrapper :breadcrumbs="[
                ['label' => 'Trang chủ', 'url' => route('home')],
                ['label' => 'Tuyển dụng', 'url' => route('cruit')],
            ]" />

        </div>
    </section>
@endsection

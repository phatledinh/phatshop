@extends('layouts.main')

@section('content')
    <section class="news py-4">
        <div class="container">
            <x-breadcrumb-wrapper :breadcrumbs="[
                ['label' => 'Trang chủ', 'url' => route('home')],
                ['label' => 'Câu hỏi thường gặp', 'url' => route('ask')],
            ]" />

        </div>
    </section>
@endsection

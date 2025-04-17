@extends('layouts.main')

@section('content')
    <div class="main-wrapper py-5" style="background-color: #fcd7db">
        <div class="account-content">
            <div class="container">
                <div id="message-box"></div>

                <div class="account-box">
                    <div class="account-wrapper">
                        <h3 class="account-title">Đăng nhập</h3>

                        <!-- Form đăng nhập -->
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Địa chỉ Email -->
                            <div class="form-group">
                                <label for="email">Địa chỉ Email</label>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" placeholder="Nhập địa chỉ email" required autofocus
                                    autocomplete="username" />
                                @error('email')
                                    <div class="invalid-feedback">Email không hợp lệ hoặc không tồn tại.</div>
                                @enderror
                            </div>

                            <!-- Mật khẩu -->
                            <div class="form-group">
                                <label for="password">Mật khẩu</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    placeholder="Nhập mật khẩu" required autocomplete="current-password" />
                                @error('password')
                                    <div class="invalid-feedback">Mật khẩu không chính xác.</div>
                                @enderror
                            </div>

                            <!-- Quên mật khẩu -->
                            <div class="form-group">
                                <div class="row">
                                    <div class="col"></div>
                                    <div class="col-auto">
                                        <a class="text-muted" href="{{ route('password.request') }}">Quên mật khẩu?</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Đăng nhập -->
                            <div class="form-group text-center py-4">
                                <button type="submit" class="btn btn-primary account-btn">
                                    Đăng nhập
                                </button>
                            </div>

                            <!-- Footer -->
                            <div class="account-footer">
                                <p>
                                    Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

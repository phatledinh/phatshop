@extends('Layouts.main')

@section('content')
    <div class="main-wrapper py-5" style="background-color: #fcd7db">
        <div class="account-content">
            <div class="container">
                <div class="account-box">
                    <div class="account-wrapper">
                        <h3 class="account-title">Đăng ký</h3>

                        <!-- Hiển thị lỗi chung -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Form đăng ký -->
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Name -->
                            <div class="form-group">
                                <label for="name">Họ và tên</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" placeholder="Nhập họ và tên của bạn" value="{{ old('name') }}"
                                    required />
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email Address -->
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" placeholder="Nhập địa chỉ email" value="{{ old('email') }}" required />
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone Number -->
                            <div class="form-group">
                                <label for="phone">Số điện thoại</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    name="phone" placeholder="Nhập số điện thoại" value="{{ old('phone') }}" required />
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div class="form-group">
                                <label for="address">Địa chỉ</label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror"
                                    name="address" placeholder="Nhập địa chỉ" value="{{ old('address') }}" required />
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Hidden Image Field -->
                            <input type="hidden" name="image" value="photo_defaults.jpg" />

                            <!-- Password -->
                            <div class="form-group">
                                <label for="password">Mật khẩu</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" placeholder="Nhập mật khẩu" required />
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="form-group">
                                <label for="password_confirmation"><strong>Nhập lại mật khẩu</strong></label>
                                <input type="password"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    name="password_confirmation" placeholder="Nhập lại mật khẩu" required />
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="captcha">Mã xác nhận</label>
                                <div class="d-flex">
                                    {!! Captcha::img('default', ['class' => 'captcha-img', 'id' => 'captcha-img']) !!}
                                    <button type="button" class="btn btn-danger mt-2 ms-3"
                                        onclick="document.getElementById('captcha-img').src='{{ url('/captcha/default') }}?'+Math.random()"><i
                                            class="fa-solid fa-rotate-right"></i> Làm
                                        mới</button>
                                </div>

                                <input type="text" class="form-control mt-2 @error('captcha') is-invalid @enderror"
                                    name="captcha" placeholder="Nhập mã xác nhận" required />
                                @error('captcha')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Submit Button -->
                            <div class="form-group text-center">
                                <button class="btn btn-primary account-btn" type="submit">
                                    Đăng ký
                                </button>
                            </div>

                            <!-- Footer -->
                            <div class="account-footer">
                                <p>
                                    Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tích hợp Google reCAPTCHA v2 -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection

@extends('layouts.app')

@section('content')
<div class="container-fluid d-flex align-items-center justify-content-center" style="height: 100vh; background-color: #fff;">
    <div class="row justify-content-center w-100">
        <div class="col-md-6 col-lg-4">
            <div class="text-center mb-4">
                <h2 style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #2c3e50;">
                    Kasbon <span style="color: red;">X</span>code
                </h2>
            </div>
            <div class="card border-0 rounded-5 shadow-lg">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #2c3e50;">Welcome Back</h2>
                    <p class="text-center text-muted mb-4" style="font-size: 14px;">Please log in to your account to continue</p>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label" style="font-weight: 500; font-size: 14px; color: #34495e;">Email Address</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter your email" style="border-radius: 10px;">

                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label" style="font-weight: 500; font-size: 14px; color: #34495e;">Password</label>
                            <div class="input-group">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter your password" style="border-radius: 10px;">
                                <span class="input-group-text toggle-password" data-target="password">
                                    <i class="bi bi-eye"></i>
                                </span>
                            </div>

                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label" for="remember" style="font-size: 14px; color: #34495e;">Remember Me</label>
                            </div>
                            <a href="{{ route('password.request') }}" class="text-muted" style="font-size: 14px;">Forgot Password?</a>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" style="border-radius: 25px; padding: 12px 0; font-size: 16px; box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1); transition: all 0.3s ease;">
                            <strong>Login</strong>
                        </button>
                    </form>
                    <div class="mt-4 text-center">
                        <p style="font-size: 14px; color: #34495e;">Don't have an account? <a href="{{ route('register') }}" style="color: #3498db; text-decoration: none; font-weight: 500;">Register here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const passwordField = document.getElementById("password");
        const togglePasswordIcon = document.querySelector('.toggle-password');

        togglePasswordIcon.addEventListener("click", function () {
            const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
            passwordField.setAttribute("type", type);
            const iconElement = togglePasswordIcon.querySelector('i');
            iconElement.classList.toggle('bi-eye');
            iconElement.classList.toggle('bi-eye-slash');
        });
    });
</script>
@endsection

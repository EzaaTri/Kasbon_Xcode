@extends('layouts.app')

@section('content')
<div class="container-fluid d-flex align-items-center justify-content-center" style="height: 100vh; background-color: #fff; margin-top: 80px;">
    <div class="row justify-content-center w-100">
        <div class="col-md-8 col-lg-5">
            <div class="text-center mb-4 mt-40">
                <h2 style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #2c3e50;">
                    Kasbon <span style="color: red;">X</span>code
                </h2>
            </div>

            <div class="card border-0 rounded-5 shadow-lg">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #2c3e50;">Register</h2>
                    <p class="text-center text-muted mb-4" style="font-size: 14px;">Silakan mendaftar untuk membuat akun Anda.</p>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label" style="font-weight: 500; font-size: 14px; color: #34495e;">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required style="border-radius: 10px;">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label" style="font-weight: 500; font-size: 14px; color: #34495e;">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required style="border-radius: 10px;">
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label" style="font-weight: 500; font-size: 14px; color: #34495e;">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required style="border-radius: 10px;">
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label" style="font-weight: 500; font-size: 14px; color: #34495e;">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="4" required style="border-radius: 10px;">{{ old('address') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label" style="font-weight: 500; font-size: 14px; color: #34495e;">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" required style="border-radius: 10px;">
                                <span class="input-group-text toggle-password" data-target="password">
                                    <i class="bi bi-eye"></i>
                                </span>
                            </div>
                            <div class="position-relative text-danger d-none" id="password-format-error" style="top: 7px; left: 0; font-size: 12px; z-index: 10; margin-top: 5px;">
                                Format password tidak sesuai!
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label" style="font-weight: 500; font-size: 14px; color: #34495e;">Confirm Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required style="border-radius: 10px;">
                                <span class="input-group-text toggle-password" data-target="password_confirmation">
                                    <i class="bi bi-eye"></i>
                                </span>
                            </div>
                            <div class="position-relative text-danger d-none" id="password-match-error" style="top: 7px; left: 0; font-size: 12px; z-index: 10; margin-top: 5px;">
                                Password tidak sama!
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="alert alert-info" role="alert">
                                <strong>Format Membuat Password:</strong>
                                <ul class="mb-0 list-style-dot">
                                    <li>Minimal 8 karakter.</li>
                                    <li>Mengandung setidaknya satu huruf besar.</li>
                                    <li>Mengandung setidaknya satu angka.</li>
                                    <li>Mengandung setidaknya satu simbol (misal: @, $, !, %, atau simbol lainnya).</li>
                                </ul>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" id="submit-button" class="btn btn-primary w-100" disabled style="border-radius: 25px; padding: 12px 0; font-size: 16px; box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1); transition: all 0.3s ease;">
                                <strong>Register</strong>
                            </button>
                        </div>
                    </form>

                    @if(session('status'))
                        <div class="alert alert-success mt-4">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="mt-4 text-center">
                        <p style="font-size: 14px; color: #34495e;">Already have an account? <a href="{{ route('login') }}" style="color: #3498db; text-decoration: none; font-weight: 500;">Sign in here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
    .card {
        margin: 20px;
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const passwordField = document.getElementById("password");
        const confirmPasswordField = document.getElementById("password_confirmation");
        const errorMessage = document.getElementById("password-match-error");
        const formatErrorMessage = document.getElementById("password-format-error");
        const submitButton = document.getElementById("submit-button");
        const togglePasswordIcons = document.querySelectorAll('.toggle-password');

        const passwordFormatRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,}$/;

        function validatePasswords() {
            const password = passwordField.value;
            const confirmPassword = confirmPasswordField.value;

            let isValidPassword = false;

            if (password !== confirmPassword) {
                errorMessage.classList.remove("d-none");
            } else {
                errorMessage.classList.add("d-none");
            }

            if (!passwordFormatRegex.test(password)) {
                formatErrorMessage.classList.remove("d-none");
                isValidPassword = false;
            } else {
                formatErrorMessage.classList.add("d-none");
                isValidPassword = true;
            }

            submitButton.disabled = !(isValidPassword && password === confirmPassword);
        }

        passwordField.addEventListener("input", validatePasswords);
        confirmPasswordField.addEventListener("input", validatePasswords);

        togglePasswordIcons.forEach(icon => {
            icon.addEventListener("click", function () {
                const target = document.getElementById(this.dataset.target);
                const type = target.getAttribute("type") === "password" ? "text" : "password";
                target.setAttribute("type", type);

                const iconElement = this.querySelector('i');
                iconElement.classList.toggle('bi-eye');
                iconElement.classList.toggle('bi-eye-slash');
            });
        });
    });
</script>
@endsection

@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Reset Password</h4>
                    <small>Perbarui kata sandi Anda untuk menjaga keamanan akun.</small>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" value="{{ old('email', $email) }}" required readonly>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                                <span class="input-group-text toggle-password" data-target="new_password">
                                    <i class="bi bi-eye"></i>
                                </span>
                            </div>
                            <div class="position-relative text-danger d-none" id="password-format-error" style="top: 7px; left: 0; font-size: 12px; z-index: 10; margin-top: 5px;">
                                Format password tidak sesuai!
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                                <span class="input-group-text toggle-password" data-target="new_password_confirmation">
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
                                    <li>Mengandung setidaknya satu simbol (misal: @, $, !, %, *, ?, &, #, ^, _, +, =, dan simbol lainnya).</li>
                                </ul>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary w-100" id="submit-btn" disabled>Update Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const newPasswordField = document.getElementById("new_password");
        const confirmPasswordField = document.getElementById("new_password_confirmation");
        const errorMessage = document.getElementById("password-match-error");
        const formatErrorMessage = document.getElementById("password-format-error");
        const submitButton = document.getElementById("submit-btn");
        const togglePasswordIcons = document.querySelectorAll('.toggle-password');

        // Regex yang memungkinkan semua simbol di password
        const passwordFormatRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,}$/;

        function validatePasswords() {
            const newPassword = newPasswordField.value;
            const confirmPassword = confirmPasswordField.value;

            // Validasi kesamaan password
            if (newPassword !== confirmPassword) {
                errorMessage.classList.remove("d-none");
            } else {
                errorMessage.classList.add("d-none");
            }

            // Validasi format password
            if (!passwordFormatRegex.test(newPassword)) {
                formatErrorMessage.classList.remove("d-none");
                submitButton.disabled = true; // Menonaktifkan tombol submit jika format tidak sesuai
            } else {
                formatErrorMessage.classList.add("d-none");
                if (newPassword === confirmPassword) {
                    submitButton.disabled = false; // Mengaktifkan tombol submit jika format valid dan password cocok
                }
            }
        }

        newPasswordField.addEventListener("input", validatePasswords);
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

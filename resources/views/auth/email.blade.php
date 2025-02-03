{{-- @component('mail::message') --}}
<h1>Reset Password Anda</h1>
<p>Anda menerima email ini karena kami menerima permintaan untuk mereset password akun Anda.</p>
<p>Untuk melanjutkan, klik tombol di bawah ini:</p>
<a href="{{ $resetLink }}" style="background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none;">Reset Password</a>
<p>Jika Anda tidak meminta reset password, abaikan email ini.</p>
{{ config('app.name') }}
{{-- @endcomponent --}}

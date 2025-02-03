@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="row justify-content-center w-100">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Forgot Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Enter your email address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>

                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">{{ __('Send Password Reset Link') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

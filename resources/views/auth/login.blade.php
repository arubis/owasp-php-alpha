@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="col-md-6 col-lg-4">
        <div class="card shadow">
            <div class="card-header bg-dark text-white text-center">
                <h4 class="mb-0">
                    <i class="bi bi-shield-lock me-2"></i>
                    OWASP Top 10 Training
                </h4>
            </div>
            <div class="card-body p-4">
                <p class="text-muted text-center mb-4">
                    Sign in to explore security vulnerabilities
                </p>

                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control" id="username" name="username" 
                                   value="{{ old('username') }}" required autofocus>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-key"></i></span>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-3">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                    </button>
                </form>
            </div>
            <div class="card-footer bg-light">
                <div class="small text-muted">
                    <strong>Default Credentials:</strong>
                    <div class="row mt-2">
                        <div class="col-6">
                            <span class="badge bg-danger">Admin</span><br>
                            <code>admin / admin123</code>
                        </div>
                        <div class="col-6">
                            <span class="badge bg-secondary">User</span><br>
                            <code>user / user123</code>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

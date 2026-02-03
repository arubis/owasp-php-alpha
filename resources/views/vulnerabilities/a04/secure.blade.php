@extends('layouts.app')

@section('title', 'A04: Insecure Design - Secure')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">
        <span class="badge bg-success me-2">A04</span>
        Insecure Design - Secure
    </h1>
    <a href="{{ route('a04.vulnerable') }}" class="btn btn-danger">
        <i class="bi bi-bug me-1"></i>View Vulnerable Version
    </a>
</div>

<div class="alert alert-success">
    <h5><i class="bi bi-shield-check me-2"></i>Protection Applied</h5>
    <p class="mb-0">
        Secure password reset with <strong>64-character cryptographic tokens</strong>,
        <strong>rate limiting</strong>, <strong>15-minute expiration</strong>, and
        <strong>generic responses</strong> to prevent user enumeration.
    </p>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card card-secure mb-4">
            <div class="card-header bg-success text-white">
                <i class="bi bi-shield-check me-2"></i>Request Password Reset
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('a04.secure') }}">
                    @csrf
                    <input type="hidden" name="action" value="request_reset">
                    <div class="mb-3">
                        <label class="form-label">Email Address:</label>
                        <input type="email" name="email" class="form-control" placeholder="user@example.com">
                    </div>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-envelope me-1"></i>Request Reset
                    </button>
                </form>

                @if($rateLimitInfo)
                <div class="alert alert-info mt-3">
                    <i class="bi bi-speedometer2 me-2"></i>{{ $rateLimitInfo }}
                </div>
                @endif
            </div>
        </div>

        <div class="card card-secure mb-4">
            <div class="card-header bg-success text-white">
                <i class="bi bi-key me-2"></i>Verify Token (Rate Limited)
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('a04.secure') }}">
                    @csrf
                    <input type="hidden" name="action" value="verify_token">
                    <div class="mb-3">
                        <label class="form-label">Enter Token:</label>
                        <input type="text" name="token" class="form-control" 
                               placeholder="64-character token from email">
                    </div>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check me-1"></i>Verify Token
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-dark text-white">
                <i class="bi bi-shield-lock me-2"></i>Security Measures
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <i class="bi bi-check-circle text-success me-2"></i>
                        <strong>Cryptographic Token:</strong> 64-character random string using <code>Str::random(64)</code>
                    </li>
                    <li class="list-group-item">
                        <i class="bi bi-check-circle text-success me-2"></i>
                        <strong>Rate Limiting:</strong> Max 5 requests per minute per IP
                    </li>
                    <li class="list-group-item">
                        <i class="bi bi-check-circle text-success me-2"></i>
                        <strong>Short Expiration:</strong> Token expires in 15 minutes
                    </li>
                    <li class="list-group-item">
                        <i class="bi bi-check-circle text-success me-2"></i>
                        <strong>Token Hashing:</strong> Token is hashed before storage
                    </li>
                    <li class="list-group-item">
                        <i class="bi bi-check-circle text-success me-2"></i>
                        <strong>Generic Response:</strong> Same message for valid/invalid emails
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@if($message)
<div class="alert alert-info">{{ $message }}</div>
@endif

<div class="card">
    <div class="card-header">
        <i class="bi bi-code-slash me-2"></i>Secure Code
    </div>
    <div class="card-body">
        <pre class="code-block"><code>use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

// Rate limiting
if (RateLimiter::tooManyAttempts($key, 5)) {
    return 'Too many attempts. Please try again later.';
}
RateLimiter::hit($key, 60);

// Secure token generation
$token = Str::random(64);
$hashedToken = hash('sha256', $token);

// Short expiration
'expires_at' => now()->addMinutes(15)

// Generic response (no user enumeration)
return 'If an account exists, you will receive a reset link.';</code></pre>
    </div>
</div>
@endsection

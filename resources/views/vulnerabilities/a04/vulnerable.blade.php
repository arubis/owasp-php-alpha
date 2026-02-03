@extends('layouts.app')

@section('title', 'A04: Insecure Design - Vulnerable')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">
        <span class="badge bg-warning text-dark me-2">A04</span>
        Insecure Design - Vulnerable
    </h1>
    <a href="{{ route('a04.secure') }}" class="btn btn-success">
        <i class="bi bi-shield-check me-1"></i>View Secure Version
    </a>
</div>

<div class="alert alert-danger">
    <h5><i class="bi bi-exclamation-triangle me-2"></i>Vulnerability Demonstrated</h5>
    <p class="mb-0">
        This password reset uses a <strong>4-digit predictable token</strong> (only 10,000 possibilities).
        No rate limiting allows brute force attacks. 24-hour expiration is too long.
    </p>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card card-vulnerable mb-4">
            <div class="card-header bg-danger text-white">
                <i class="bi bi-bug me-2"></i>Request Password Reset
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('a04.vulnerable') }}">
                    @csrf
                    <input type="hidden" name="action" value="request_reset">
                    <div class="mb-3">
                        <label class="form-label">Email Address:</label>
                        <input type="email" name="email" class="form-control" 
                               placeholder="admin@example.com" value="admin@example.com">
                    </div>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-envelope me-1"></i>Request Reset
                    </button>
                </form>

                @if($token)
                <div class="alert alert-warning mt-3">
                    <strong>Token Generated:</strong> <code class="fs-5">{{ $token }}</code>
                    <br><small class="text-muted">Notice: Only 4 digits! (10,000 possibilities)</small>
                </div>
                @endif
            </div>
        </div>

        <div class="card card-vulnerable mb-4">
            <div class="card-header bg-danger text-white">
                <i class="bi bi-key me-2"></i>Verify Token (No Rate Limiting)
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('a04.vulnerable') }}">
                    @csrf
                    <input type="hidden" name="action" value="verify_token">
                    <div class="mb-3">
                        <label class="form-label">Enter Token:</label>
                        <input type="text" name="token" class="form-control" placeholder="1234">
                    </div>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-check me-1"></i>Verify Token
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-dark text-white">
                <i class="bi bi-database me-2"></i>Existing Tokens (Visible for Demo)
            </div>
            <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Token</th>
                            <th>Expires</th>
                            <th>Used</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tokens as $t)
                        <tr>
                            <td>{{ $t->user->email ?? 'N/A' }}</td>
                            <td><code>{{ $t->token }}</code></td>
                            <td>{{ $t->expires_at->diffForHumans() }}</td>
                            <td>
                                <span class="badge bg-{{ $t->used ? 'secondary' : 'success' }}">
                                    {{ $t->used ? 'Yes' : 'No' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-muted">No tokens yet</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@if($message)
<div class="alert alert-info">{{ $message }}</div>
@endif

<div class="card">
    <div class="card-header">
        <i class="bi bi-code-slash me-2"></i>Vulnerable Code
    </div>
    <div class="card-body">
        <pre class="code-block"><code>// VULNERABLE: Predictable 4-digit token
$token = rand(1000, 9999);

// Problems:
// 1. Only 10,000 possibilities
// 2. No rate limiting - can be brute forced in minutes
// 3. 24-hour expiration is too long
// 4. User enumeration through different error messages</code></pre>
    </div>
</div>
@endsection

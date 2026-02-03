@extends('layouts.app')

@section('title', 'A02: Cryptographic Failures - Secure')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">
        <span class="badge bg-success me-2">A02</span>
        Cryptographic Failures - Secure
    </h1>
    <a href="{{ route('a02.vulnerable') }}" class="btn btn-danger">
        <i class="bi bi-bug me-1"></i>View Vulnerable Version
    </a>
</div>

<div class="alert alert-success">
    <h5><i class="bi bi-shield-check me-2"></i>Protection Applied</h5>
    <p class="mb-0">
        Using Laravel's <strong>Hash facade</strong> which uses <strong>bcrypt</strong> by default.
        Each hash is unique (random salt) and intentionally slow to compute.
    </p>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card card-secure mb-4">
            <div class="card-header bg-success text-white">
                <i class="bi bi-shield-check me-2"></i>Secure Password Hashing
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('a02.secure') }}">
                    @csrf
                    <input type="hidden" name="action" value="hash">
                    <div class="mb-3">
                        <label class="form-label">Enter a password to hash:</label>
                        <input type="text" name="password" class="form-control" placeholder="e.g., password123">
                    </div>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-key me-1"></i>Generate Bcrypt Hash
                    </button>
                </form>

                @if($result)
                <div class="alert alert-info mt-3">
                    <strong>Bcrypt Hash:</strong><br>
                    <code class="text-break">{{ $result }}</code>
                    <hr>
                    <small class="text-muted">
                        Notice: Each time you hash the same password, you get a different hash (due to random salt).
                    </small>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card card-secure mb-4">
            <div class="card-header bg-success text-white">
                <i class="bi bi-check-circle me-2"></i>Verify Password
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('a02.secure') }}">
                    @csrf
                    <input type="hidden" name="action" value="verify">
                    <div class="mb-3">
                        <label class="form-label">Password:</label>
                        <input type="text" name="password" class="form-control" placeholder="Enter password">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hash to verify against:</label>
                        <input type="text" name="hash_to_verify" class="form-control" placeholder="Paste bcrypt hash">
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check me-1"></i>Verify
                    </button>
                </form>

                @if($verifyResult !== null)
                <div class="alert alert-{{ $verifyResult ? 'success' : 'danger' }} mt-3">
                    <i class="bi bi-{{ $verifyResult ? 'check-circle' : 'x-circle' }} me-2"></i>
                    {{ $verifyResult ? 'Password matches!' : 'Password does not match.' }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="bi bi-code-slash me-2"></i>Secure Code
    </div>
    <div class="card-body">
        <pre class="code-block"><code>use Illuminate\Support\Facades\Hash;

// SECURE: Laravel's Hash facade uses bcrypt by default
$hash = Hash::make($password);

// Verify password (timing-safe comparison)
if (Hash::check($password, $hash)) {
    // Password is correct
}

// Benefits:
// 1. Intentionally slow (configurable rounds: {{ $bcryptRounds }})
// 2. Random salt included in every hash
// 3. Non-deterministic - same password = different hash each time
// 4. Timing-safe comparison prevents timing attacks</code></pre>

        <h6 class="mt-3">Configuration (config/hashing.php):</h6>
        <pre class="code-block"><code>'bcrypt' => [
    'rounds' => env('BCRYPT_ROUNDS', 12), // Current: {{ $bcryptRounds }}
],</code></pre>
    </div>
</div>
@endsection

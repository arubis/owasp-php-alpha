@extends('layouts.app')

@section('title', 'A02: Cryptographic Failures - Vulnerable')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">
        <span class="badge bg-warning text-dark me-2">A02</span>
        Cryptographic Failures - Vulnerable
    </h1>
    <a href="{{ route('a02.secure') }}" class="btn btn-success">
        <i class="bi bi-shield-check me-1"></i>View Secure Version
    </a>
</div>

<div class="alert alert-danger">
    <h5><i class="bi bi-exclamation-triangle me-2"></i>Vulnerability Demonstrated</h5>
    <p class="mb-0">
        Using weak hashing algorithms like <strong>MD5</strong> or <strong>SHA1</strong> for passwords.
        These can be cracked in seconds using rainbow tables or brute force attacks.
    </p>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card card-vulnerable mb-4">
            <div class="card-header bg-danger text-white">
                <i class="bi bi-bug me-2"></i>Weak Password Hashing
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('a02.vulnerable') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Enter a password to hash:</label>
                        <input type="text" name="password" class="form-control" placeholder="e.g., password123">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hash Algorithm:</label>
                        <select name="hash_type" class="form-select">
                            <option value="md5" {{ $hashType === 'md5' ? 'selected' : '' }}>MD5 (Very Weak)</option>
                            <option value="sha1" {{ $hashType === 'sha1' ? 'selected' : '' }}>SHA1 (Weak)</option>
                            <option value="sha256" {{ $hashType === 'sha256' ? 'selected' : '' }}>SHA256 (Still Not Recommended)</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-key me-1"></i>Generate Hash
                    </button>
                </form>

                @if($result)
                <div class="alert alert-warning mt-3">
                    <strong>Generated Hash:</strong><br>
                    <code class="text-break">{{ $result }}</code>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-dark text-white">
                <i class="bi bi-database me-2"></i>Example "Leaked" Hashes
            </div>
            <div class="card-body">
                <p class="text-muted small">These MD5/SHA1 hashes can be cracked instantly:</p>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Hash</th>
                            <th>Algorithm</th>
                            <th>Cracked</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leakedHashes as $hash)
                        <tr>
                            <td><code class="small">{{ substr($hash['hash'], 0, 20) }}...</code></td>
                            <td><span class="badge bg-danger">{{ $hash['algorithm'] }}</span></td>
                            <td><strong class="text-success">{{ $hash['cracked'] }}</strong></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="bi bi-code-slash me-2"></i>Vulnerable Code
    </div>
    <div class="card-body">
        <pre class="code-block"><code>// VULNERABLE: Using weak hash algorithms
$hash = md5($password);      // Crackable in seconds
$hash = sha1($password);     // Also weak
$hash = hash('sha256', $password); // Better, but no salt!

// Problems:
// 1. Too fast - allows billions of guesses per second
// 2. No salt - rainbow table attacks work
// 3. Deterministic - same password = same hash</code></pre>
    </div>
</div>
@endsection

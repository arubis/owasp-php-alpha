@extends('layouts.app')
@section('title', 'A07: Auth Failures - Secure')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3"><span class="badge bg-success me-2">A07</span>Authentication Failures - Secure</h1>
    <a href="{{ route('a07.vulnerable') }}" class="btn btn-danger">View Vulnerable Version</a>
</div>
<div class="alert alert-success">
    <strong>Protection:</strong> Session regeneration after login prevents session fixation.
</div>
<div class="card card-secure">
    <div class="card-body">
        <p><strong>Session ID:</strong> <code>{{ $sessionInfo['session_id_current'] ?? $sessionInfo['session_id_before'] }}</code></p>
        @if($message)<div class="alert alert-info">{{ $message }}</div>@endif
        <form method="POST">
            @csrf
            <input type="hidden" name="action" value="login">
            <input type="text" name="username" class="form-control mb-2" placeholder="Username" value="admin">
            <input type="password" name="password" class="form-control mb-2" placeholder="Password" value="admin123">
            <button class="btn btn-success">Login (Secure)</button>
        </form>
    </div>
</div>
<div class="card mt-3">
    <div class="card-header">Secure Code</div>
    <div class="card-body">
        <pre class="code-block"><code>Auth::login($user);
$request->session()->regenerate(); // New session ID!</code></pre>
    </div>
</div>
@endsection

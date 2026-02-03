@extends('layouts.app')
@section('title', 'A07: Auth Failures - Vulnerable')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3"><span class="badge bg-danger me-2">A07</span>Authentication Failures - Vulnerable</h1>
    <a href="{{ route('a07.secure') }}" class="btn btn-success">View Secure Version</a>
</div>
<div class="alert alert-danger">
    <strong>Vulnerability:</strong> No session regeneration after login - enables session fixation attacks.
</div>
<div class="card card-vulnerable">
    <div class="card-body">
        <p><strong>Session ID:</strong> <code>{{ $sessionInfo['session_id'] }}</code></p>
        @if($message)<div class="alert alert-info">{{ $message }}</div>@endif
        <form method="POST">
            @csrf
            <input type="hidden" name="action" value="login">
            <input type="text" name="username" class="form-control mb-2" placeholder="Username" value="admin">
            <input type="password" name="password" class="form-control mb-2" placeholder="Password" value="admin123">
            <button class="btn btn-danger">Login (Vulnerable)</button>
        </form>
    </div>
</div>
<div class="card mt-3">
    <div class="card-header">Vulnerable Code</div>
    <div class="card-body">
        <pre class="code-block"><code>// NO session regeneration after login!
Auth::login($user);
// Session ID remains the same - session fixation possible</code></pre>
    </div>
</div>
@endsection

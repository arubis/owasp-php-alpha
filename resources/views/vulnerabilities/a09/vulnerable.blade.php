@extends('layouts.app')
@section('title', 'A09: Logging Failures - Vulnerable')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3"><span class="badge bg-info me-2">A09</span>Logging Failures - Vulnerable</h1>
    <a href="{{ route('a09.secure') }}" class="btn btn-success">View Secure Version</a>
</div>
<div class="alert alert-danger">
    <strong>Vulnerability:</strong> No logging of security events - attacks go undetected.
</div>
<div class="card card-vulnerable">
    <div class="card-body">
        <form method="POST">
            @csrf
            <select name="action" class="form-select mb-2">
                <option value="failed_login">Simulate Failed Login</option>
                <option value="admin_access">Simulate Admin Access</option>
            </select>
            <button class="btn btn-danger">Trigger Event (Not Logged)</button>
        </form>
        @if($message)<div class="alert alert-warning mt-3">{{ $message }}</div>@endif
    </div>
</div>
<div class="card mt-3">
    <div class="card-header">Vulnerable Code</div>
    <div class="card-body">
        <pre class="code-block"><code>// Failed login - no logging!
if (!Auth::attempt($credentials)) {
    return back(); // Attacker can brute force undetected
}</code></pre>
    </div>
</div>
@endsection

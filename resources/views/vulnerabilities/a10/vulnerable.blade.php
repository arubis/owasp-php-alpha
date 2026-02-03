@extends('layouts.app')
@section('title', 'A10: SSRF - Vulnerable')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3"><span class="badge bg-danger me-2">A10</span>SSRF - Vulnerable</h1>
    <a href="{{ route('a10.secure') }}" class="btn btn-success">View Secure Version</a>
</div>
<div class="alert alert-danger">
    <strong>Vulnerability:</strong> Server fetches any URL without validation - can access internal services.
</div>
<div class="card card-vulnerable">
    <div class="card-body">
        <form method="POST">
            @csrf
            <input type="url" name="url" class="form-control mb-2" placeholder="Enter URL to fetch" value="{{ $url }}">
            <button class="btn btn-danger">Fetch URL (Vulnerable)</button>
        </form>
        @if($error)<div class="alert alert-warning mt-2">{{ $error }}</div>@endif
        @if($result)<div class="alert alert-secondary mt-2"><strong>Response:</strong><pre>{{ substr($result['body'] ?? '', 0, 500) }}</pre></div>@endif
    </div>
</div>
<div class="card mt-3">
    <div class="card-header">Dangerous URLs to try</div>
    <div class="card-body">
        <code>http://localhost/admin</code>, <code>http://169.254.169.254/</code> (AWS metadata)
    </div>
</div>
@endsection

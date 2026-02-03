@extends('layouts.app')
@section('title', 'A10: SSRF - Secure')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3"><span class="badge bg-success me-2">A10</span>SSRF - Secure</h1>
    <a href="{{ route('a10.vulnerable') }}" class="btn btn-danger">View Vulnerable Version</a>
</div>
<div class="alert alert-success">
    <strong>Protection:</strong> URL validation with domain allowlist and private IP blocking.
</div>
<div class="card card-secure">
    <div class="card-body">
        <form method="POST">
            @csrf
            <input type="url" name="url" class="form-control mb-2" placeholder="Enter URL" value="{{ $url }}">
            <small class="text-muted">Allowed: {{ implode(', ', $allowedDomains) }}</small>
            <button class="btn btn-success mt-2">Fetch URL (Validated)</button>
        </form>
        @if($error)<div class="alert alert-warning mt-2">{{ $error }}</div>@endif
        @if($result)<div class="alert alert-success mt-2"><strong>Response:</strong><pre>{{ substr($result['body'] ?? '', 0, 500) }}</pre></div>@endif
    </div>
</div>
<div class="card mt-3">
    <div class="card-header">Secure Code</div>
    <div class="card-body">
        <pre class="code-block"><code>$allowedDomains = ['httpbin.org', 'api.github.com'];
if (!in_array($host, $allowedDomains)) abort(403);</code></pre>
    </div>
</div>
@endsection

@extends('layouts.app')
@section('title', 'A08: Data Integrity - Secure')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3"><span class="badge bg-success me-2">A08</span>Data Integrity - Secure</h1>
    <a href="{{ route('a08.vulnerable') }}" class="btn btn-danger">View Vulnerable Version</a>
</div>
<div class="alert alert-success">
    <strong>Protection:</strong> File validation with MIME type and size checks.
</div>
<div class="card card-secure">
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" class="form-control mb-2">
            <small class="text-muted">Allowed: jpg, png, pdf (max 2MB)</small>
            <button class="btn btn-success mt-2">Upload (Validated)</button>
        </form>
        @if($errors->any())<div class="alert alert-danger mt-2">{{ $errors->first() }}</div>@endif
        @if($message)<div class="alert alert-success mt-3">{{ $message }}</div>@endif
    </div>
</div>
<div class="card mt-3">
    <div class="card-header">Secure Code</div>
    <div class="card-body">
        <pre class="code-block"><code>$request->validate([
    'file' => 'required|file|max:2048|mimes:jpg,png,pdf'
]);</code></pre>
    </div>
</div>
@endsection

@extends('layouts.app')
@section('title', 'A08: Data Integrity - Vulnerable')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3"><span class="badge bg-warning text-dark me-2">A08</span>Data Integrity - Vulnerable</h1>
    <a href="{{ route('a08.secure') }}" class="btn btn-success">View Secure Version</a>
</div>
<div class="alert alert-danger">
    <strong>Vulnerability:</strong> File upload without validation - accepts any file type.
</div>
<div class="card card-vulnerable">
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" class="form-control mb-2">
            <button class="btn btn-danger">Upload (No Validation)</button>
        </form>
        @if($message)<div class="alert alert-warning mt-3">{{ $message }}</div>@endif
    </div>
</div>
<div class="card mt-3">
    <div class="card-header">Vulnerable Code</div>
    <div class="card-body">
        <pre class="code-block"><code>// No validation!
$file->store('uploads'); // Accepts ANY file</code></pre>
    </div>
</div>
@endsection

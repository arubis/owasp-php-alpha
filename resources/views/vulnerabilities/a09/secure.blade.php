@extends('layouts.app')
@section('title', 'A09: Logging Failures - Secure')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3"><span class="badge bg-success me-2">A09</span>Logging Failures - Secure</h1>
    <a href="{{ route('a09.vulnerable') }}" class="btn btn-danger">View Vulnerable Version</a>
</div>
<div class="alert alert-success">
    <strong>Protection:</strong> All security events are logged for monitoring.
</div>
<div class="card card-secure">
    <div class="card-body">
        <form method="POST">
            @csrf
            <select name="action" class="form-select mb-2">
                <option value="failed_login">Simulate Failed Login</option>
                <option value="admin_access">Simulate Admin Access</option>
            </select>
            <button class="btn btn-success">Trigger Event (Logged)</button>
        </form>
        @if($message)<div class="alert alert-info mt-3">{{ $message }}</div>@endif
    </div>
</div>
<h5 class="mt-4">Recent Audit Logs</h5>
<table class="table table-sm">
    <thead><tr><th>Action</th><th>User</th><th>IP</th><th>Time</th></tr></thead>
    <tbody>
    @forelse($auditLogs as $log)
        <tr><td>{{ $log->action }}</td><td>{{ $log->user->username ?? 'N/A' }}</td><td>{{ $log->ip_address }}</td><td>{{ $log->created_at->diffForHumans() }}</td></tr>
    @empty
        <tr><td colspan="4" class="text-muted">No logs yet</td></tr>
    @endforelse
    </tbody>
</table>
@endsection

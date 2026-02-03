@extends('layouts.app')

@section('title', 'A05: Security Misconfiguration - Vulnerable')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">
        <span class="badge bg-info me-2">A05</span>
        Security Misconfiguration - Vulnerable
    </h1>
    <a href="{{ route('a05.secure') }}" class="btn btn-success">
        <i class="bi bi-shield-check me-1"></i>View Secure Version
    </a>
</div>

<div class="alert alert-danger">
    <h5><i class="bi bi-exclamation-triangle me-2"></i>Vulnerability Demonstrated</h5>
    <p class="mb-0">
        Exposing sensitive configuration information, detailed error messages, and
        system details that could help attackers.
    </p>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card card-vulnerable mb-4">
            <div class="card-header bg-danger text-white">
                <i class="bi bi-bug me-2"></i>Exposed Configuration
            </div>
            <div class="card-body">
                <h6>Sensitive Information (NEVER expose this!):</h6>
                <table class="table table-sm">
                    @foreach($sensitiveInfo as $key => $value)
                    <tr>
                        <td><strong>{{ $key }}</strong></td>
                        <td>
                            @if($key === 'app_key')
                            <code class="text-danger">{{ $value }}</code>
                            <span class="badge bg-danger">CRITICAL!</span>
                            @else
                            <code>{{ $value }}</code>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card card-vulnerable mb-4">
            <div class="card-header bg-danger text-white">
                <i class="bi bi-exclamation-octagon me-2"></i>Trigger Detailed Error
            </div>
            <div class="card-body">
                <p class="text-muted">Click to trigger an error and see detailed information:</p>
                <a href="{{ route('a05.vulnerable', ['action' => 'trigger_error']) }}" class="btn btn-danger">
                    <i class="bi bi-bug me-1"></i>Trigger Database Error
                </a>

                @if($error)
                <div class="alert alert-warning mt-3">
                    <h6>Exposed Error Details:</h6>
                    <p><strong>Message:</strong> {{ $error['message'] }}</p>
                    <p><strong>File:</strong> {{ $error['file'] }}</p>
                    <p><strong>Line:</strong> {{ $error['line'] }}</p>
                    <details>
                        <summary>Stack Trace</summary>
                        <pre class="small bg-dark text-light p-2 mt-2">{{ $error['trace'] }}</pre>
                    </details>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="bi bi-code-slash me-2"></i>Vulnerable Configuration
    </div>
    <div class="card-body">
        <pre class="code-block"><code># .env file (VULNERABLE settings)
APP_DEBUG=true          # Exposes stack traces
APP_ENV=local           # Should be 'production'

# Controller code exposing sensitive info
$sensitiveInfo = [
    'app_key' => config('app.key'),  // NEVER expose!
    'db_database' => config('database.connections.sqlite.database'),
];

// Exposing detailed errors
catch (Exception $e) {
    $error = [
        'message' => $e->getMessage(),
        'file' => $e->getFile(),      // Exposes file paths
        'line' => $e->getLine(),
        'trace' => $e->getTraceAsString(),
    ];
}</code></pre>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'A05: Security Misconfiguration - Secure')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">
        <span class="badge bg-success me-2">A05</span>
        Security Misconfiguration - Secure
    </h1>
    <a href="{{ route('a05.vulnerable') }}" class="btn btn-danger">
        <i class="bi bi-bug me-1"></i>View Vulnerable Version
    </a>
</div>

<div class="alert alert-success">
    <h5><i class="bi bi-shield-check me-2"></i>Protection Applied</h5>
    <p class="mb-0">
        Proper security configuration with debug mode off in production,
        generic error messages, and no sensitive information exposure.
    </p>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card card-secure mb-4">
            <div class="card-header bg-success text-white">
                <i class="bi bi-shield-check me-2"></i>Safe Configuration Info
            </div>
            <div class="card-body">
                <p><strong>Environment:</strong> {{ $safeInfo['environment'] }}</p>
                <p><strong>Debug Mode:</strong> {{ $safeInfo['debug_enabled'] }}</p>
                
                <h6 class="mt-3">Security Recommendations:</h6>
                <ul class="list-group list-group-flush">
                    @foreach($safeInfo['recommendations'] as $rec)
                    <li class="list-group-item py-2">
                        <i class="bi bi-check-circle text-success me-2"></i>{{ $rec }}
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card card-secure mb-4">
            <div class="card-header bg-success text-white">
                <i class="bi bi-shield-check me-2"></i>Secure Error Handling
            </div>
            <div class="card-body">
                <p class="text-muted">Click to trigger an error with secure handling:</p>
                <a href="{{ route('a05.secure', ['action' => 'trigger_error']) }}" class="btn btn-success">
                    <i class="bi bi-bug me-1"></i>Trigger Error (Secure)
                </a>

                @if($error)
                <div class="alert alert-warning mt-3">
                    <i class="bi bi-info-circle me-2"></i>{{ $error }}
                    <hr>
                    <small class="text-muted">
                        The actual error has been logged server-side for developers, 
                        but users only see a generic message.
                    </small>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="bi bi-code-slash me-2"></i>Secure Configuration
    </div>
    <div class="card-body">
        <pre class="code-block"><code># .env file (SECURE settings for production)
APP_DEBUG=false         # Never expose stack traces
APP_ENV=production      # Production environment

# Secure error handling
try {
    // Risky operation
} catch (Exception $e) {
    // Generic message for users
    $error = "An error occurred. Please try again later.";
    
    // Log actual error for developers
    Log::error('Database error', [
        'message' => $e->getMessage(),
        'user_id' => auth()->id(),
    ]);
}</code></pre>

        <h6 class="mt-3">Production Checklist:</h6>
        <pre class="code-block"><code># Run these commands before deploying
php artisan config:cache    # Cache configuration
php artisan route:cache     # Cache routes
php artisan view:cache      # Cache views
php artisan optimize        # Optimize autoloader</code></pre>
    </div>
</div>
@endsection

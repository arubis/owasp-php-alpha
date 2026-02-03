@extends('layouts.app')

@section('title', 'A06: Vulnerable and Outdated Components')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">
        <span class="badge bg-secondary me-2">A06</span>
        Vulnerable and Outdated Components
    </h1>
</div>

<div class="alert alert-info">
    <h5><i class="bi bi-info-circle me-2"></i>About This Vulnerability</h5>
    <p class="mb-0">
        Unlike other vulnerabilities, A06 is about <strong>dependency management</strong> rather than code patterns.
        It's about ensuring your application's components (packages, libraries) are up-to-date and free of known vulnerabilities.
    </p>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-dark text-white">
                <i class="bi bi-info-circle me-2"></i>Current Environment
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td><strong>Laravel Version</strong></td>
                        <td><code>{{ $laravelVersion }}</code></td>
                    </tr>
                    <tr>
                        <td><strong>PHP Version</strong></td>
                        <td><code>{{ $phpVersion }}</code></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-dark text-white">
                <i class="bi bi-tools me-2"></i>Security Scanning Tools
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Tool</th>
                            <th>Command/Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($securityTools as $tool)
                        <tr>
                            <td>
                                <strong>{{ $tool['name'] }}</strong>
                                <br><small class="text-muted">{{ $tool['description'] }}</small>
                            </td>
                            <td>
                                <code>{{ $tool['command'] }}</code>
                                <span class="badge bg-secondary ms-1">{{ $tool['type'] }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-dark text-white">
                <i class="bi bi-box me-2"></i>Installed Packages (Top 20)
            </div>
            <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Package</th>
                            <th>Version</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($packages as $package)
                        <tr>
                            <td>
                                <code>{{ $package['name'] }}</code>
                            </td>
                            <td>{{ $package['version'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header bg-success text-white">
        <i class="bi bi-check-circle me-2"></i>Best Practices
    </div>
    <div class="card-body">
        <div class="row">
            @foreach(array_chunk($bestPractices, 5) as $chunk)
            <div class="col-md-6">
                <ul class="list-group list-group-flush">
                    @foreach($chunk as $practice)
                    <li class="list-group-item py-2">
                        <i class="bi bi-check-circle text-success me-2"></i>{{ $practice }}
                    </li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="bi bi-terminal me-2"></i>Useful Commands
    </div>
    <div class="card-body">
        <pre class="code-block"><code># Check for security vulnerabilities
composer audit

# Update all dependencies
composer update

# Update specific package
composer update vendor/package

# Check outdated packages
composer outdated

# Install roave/security-advisories (prevents installing vulnerable packages)
composer require --dev roave/security-advisories:dev-latest</code></pre>
    </div>
</div>
@endsection

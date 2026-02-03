@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">
        <i class="bi bi-speedometer2 me-2"></i>
        OWASP Top 10 (2021) Dashboard
    </h1>
    <span class="badge bg-primary">Laravel {{ app()->version() }}</span>
</div>

<div class="alert alert-info mb-4">
    <h5 class="alert-heading"><i class="bi bi-info-circle me-2"></i>About This Application</h5>
    <p class="mb-0">
        This application demonstrates the OWASP Top 10 security risks in a Laravel environment. 
        Each vulnerability has both a <strong class="text-danger">vulnerable</strong> and 
        <strong class="text-success">secure</strong> implementation to compare.
    </p>
</div>

<div class="row">
    @foreach($vulnerabilities as $vuln)
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-header bg-{{ $vuln['color'] }} text-white d-flex justify-content-between align-items-center">
                <span class="fw-bold">{{ $vuln['id'] }}</span>
                <span class="badge bg-dark">{{ $vuln['id'] }}</span>
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ $vuln['name'] }}</h5>
                <p class="card-text text-muted small">{{ $vuln['description'] }}</p>
            </div>
            <div class="card-footer bg-white border-top-0">
                <div class="d-flex gap-2">
                    <a href="{{ $vuln['vulnerable_route'] }}" class="btn btn-outline-danger btn-sm flex-fill">
                        <i class="bi bi-bug me-1"></i>Vulnerable
                    </a>
                    @if($vuln['id'] !== 'A06')
                    <a href="{{ $vuln['secure_route'] }}" class="btn btn-outline-success btn-sm flex-fill">
                        <i class="bi bi-shield-check me-1"></i>Secure
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="card mt-4">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0"><i class="bi bi-book me-2"></i>Laravel Security Features Used</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6 class="text-primary">Built-in Protections</h6>
                <ul class="list-unstyled">
                    <li><i class="bi bi-check-circle text-success me-2"></i>CSRF Token Protection</li>
                    <li><i class="bi bi-check-circle text-success me-2"></i>Eloquent ORM (SQL Injection Prevention)</li>
                    <li><i class="bi bi-check-circle text-success me-2"></i>Blade Template Escaping (XSS Prevention)</li>
                    <li><i class="bi bi-check-circle text-success me-2"></i>Hash Facade (bcrypt by default)</li>
                    <li><i class="bi bi-check-circle text-success me-2"></i>Session Management</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h6 class="text-primary">Additional Features</h6>
                <ul class="list-unstyled">
                    <li><i class="bi bi-check-circle text-success me-2"></i>Middleware for Access Control</li>
                    <li><i class="bi bi-check-circle text-success me-2"></i>Rate Limiting</li>
                    <li><i class="bi bi-check-circle text-success me-2"></i>Validation Rules</li>
                    <li><i class="bi bi-check-circle text-success me-2"></i>Logging (Monolog Integration)</li>
                    <li><i class="bi bi-check-circle text-success me-2"></i>Environment Configuration</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

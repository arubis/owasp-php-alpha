<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'OWASP Top 10 Training') - {{ config('app.name') }}</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        :root {
            --owasp-primary: #2c3e50;
            --owasp-danger: #e74c3c;
            --owasp-success: #27ae60;
            --owasp-warning: #f39c12;
        }
        
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        
        .navbar-brand {
            font-weight: 700;
        }
        
        .sidebar {
            min-height: calc(100vh - 56px);
            background-color: var(--owasp-primary);
        }
        
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.75rem 1rem;
            border-left: 3px solid transparent;
        }
        
        .sidebar .nav-link:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .sidebar .nav-link.active {
            color: #fff;
            border-left-color: var(--owasp-warning);
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .vulnerability-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }
        
        .card-vulnerable {
            border-left: 4px solid var(--owasp-danger);
        }
        
        .card-secure {
            border-left: 4px solid var(--owasp-success);
        }
        
        .code-block {
            background-color: #2d2d2d;
            color: #f8f8f2;
            padding: 1rem;
            border-radius: 0.375rem;
            font-family: 'Consolas', 'Monaco', monospace;
            font-size: 0.875rem;
            overflow-x: auto;
        }
        
        .warning-banner {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            padding: 0.5rem;
            text-align: center;
            font-size: 0.875rem;
        }
        
        .main-content {
            padding: 2rem;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Warning Banner -->
    <div class="warning-banner">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <strong>WARNING:</strong> This application contains intentional security vulnerabilities for educational purposes only.
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="bi bi-shield-exclamation me-2"></i>
                OWASP Top 10 Training
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i>
                                {{ auth()->user()->username }}
                                <span class="badge bg-{{ auth()->user()->isAdmin() ? 'danger' : 'secondary' }} ms-1">
                                    {{ auth()->user()->role }}
                                </span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            @auth
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse py-3">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                <i class="bi bi-speedometer2 me-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item mt-3">
                            <span class="nav-link text-muted small text-uppercase">Vulnerabilities</span>
                        </li>
                        @php
                            $vulnerabilities = [
                                'a01' => ['name' => 'A01: Broken Access Control', 'color' => 'danger'],
                                'a02' => ['name' => 'A02: Cryptographic Failures', 'color' => 'warning'],
                                'a03' => ['name' => 'A03: Injection', 'color' => 'danger'],
                                'a04' => ['name' => 'A04: Insecure Design', 'color' => 'warning'],
                                'a05' => ['name' => 'A05: Security Misconfiguration', 'color' => 'info'],
                                'a06' => ['name' => 'A06: Vulnerable Components', 'color' => 'secondary'],
                                'a07' => ['name' => 'A07: Auth Failures', 'color' => 'danger'],
                                'a08' => ['name' => 'A08: Data Integrity', 'color' => 'warning'],
                                'a09' => ['name' => 'A09: Logging Failures', 'color' => 'info'],
                                'a10' => ['name' => 'A10: SSRF', 'color' => 'danger'],
                            ];
                        @endphp
                        @foreach($vulnerabilities as $key => $vuln)
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is($key.'/*') ? 'active' : '' }}" 
                                   href="{{ $key === 'a06' ? route('a06.index') : route($key.'.vulnerable') }}">
                                    <span class="badge bg-{{ $vuln['color'] }} vulnerability-badge me-2">{{ strtoupper($key) }}</span>
                                    <span class="small">{{ Str::after($vuln['name'], ': ') }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </nav>
            @endauth

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content @guest col-12 @endguest">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>

@extends('layouts.app')

@section('title', 'A01: Broken Access Control - Vulnerable')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">
        <span class="badge bg-danger me-2">A01</span>
        Broken Access Control - Vulnerable
    </h1>
    <a href="{{ route('a01.secure') }}" class="btn btn-success">
        <i class="bi bi-shield-check me-1"></i>View Secure Version
    </a>
</div>

<div class="alert alert-danger">
    <h5><i class="bi bi-exclamation-triangle me-2"></i>Vulnerability Demonstrated</h5>
    <p class="mb-0">
        This admin page has <strong>NO server-side access control</strong>. 
        Any authenticated user can access it by simply navigating to the URL.
        The "protection" relies only on hiding the link in the UI.
    </p>
</div>

<div class="card card-vulnerable mb-4">
    <div class="card-header bg-danger text-white">
        <i class="bi bi-bug me-2"></i>Admin Panel (Vulnerable)
    </div>
    <div class="card-body">
        <div class="alert alert-warning">
            <i class="bi bi-person-badge me-2"></i>
            You are logged in as: <strong>{{ auth()->user()->username }}</strong> 
            (Role: <span class="badge bg-{{ auth()->user()->isAdmin() ? 'danger' : 'secondary' }}">{{ auth()->user()->role }}</span>)
        </div>

        <h5>{{ $message }}</h5>
        
        <h6 class="mt-4">All Users:</h6>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td><span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'secondary' }}">{{ $user->role }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="bi bi-code-slash me-2"></i>Vulnerable Code
    </div>
    <div class="card-body">
        <h6>Controller (A01Controller.php):</h6>
        <pre class="code-block"><code>public function vulnerable()
{
    // VULNERABILITY: No role check!
    // Any authenticated user can access admin functionality
    $users = User::all();

    return view('vulnerabilities.a01.vulnerable', [
        'users' => $users,
    ]);
}</code></pre>

        <h6 class="mt-3">Routes (web.php):</h6>
        <pre class="code-block"><code>// VULNERABLE: No role middleware
Route::get('/a01/vulnerable', [A01Controller::class, 'vulnerable']);</code></pre>
    </div>
</div>
@endsection

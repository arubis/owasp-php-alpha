@extends('layouts.app')

@section('title', 'A01: Broken Access Control - Secure')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">
        <span class="badge bg-success me-2">A01</span>
        Broken Access Control - Secure
    </h1>
    <a href="{{ route('a01.vulnerable') }}" class="btn btn-danger">
        <i class="bi bi-bug me-1"></i>View Vulnerable Version
    </a>
</div>

<div class="alert alert-success">
    <h5><i class="bi bi-shield-check me-2"></i>Protection Applied</h5>
    <p class="mb-0">
        This admin page is protected with <strong>server-side role-based access control</strong> using Laravel middleware.
        Only users with the 'admin' role can access this page.
    </p>
</div>

<div class="card card-secure mb-4">
    <div class="card-header bg-success text-white">
        <i class="bi bi-shield-check me-2"></i>Admin Panel (Secure)
    </div>
    <div class="card-body">
        <div class="alert alert-info">
            <i class="bi bi-person-badge me-2"></i>
            You are logged in as: <strong>{{ auth()->user()->username }}</strong> 
            (Role: <span class="badge bg-danger">{{ auth()->user()->role }}</span>)
            - Access granted because you are an admin.
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
        <i class="bi bi-code-slash me-2"></i>Secure Code
    </div>
    <div class="card-body">
        <h6>Middleware (CheckRole.php):</h6>
        <pre class="code-block"><code>public function handle(Request $request, Closure $next, string $role): Response
{
    if (!$request->user()) {
        return redirect()->route('login');
    }

    if ($request->user()->role !== $role) {
        abort(403, 'Access denied.');
    }

    return $next($request);
}</code></pre>

        <h6 class="mt-3">Routes (web.php):</h6>
        <pre class="code-block"><code>// SECURE: Protected with role middleware
Route::get('/a01/secure', [A01Controller::class, 'secure'])
    ->middleware('role:admin');</code></pre>

        <h6 class="mt-3">Laravel Best Practices:</h6>
        <ul>
            <li>Use <code>middleware('role:admin')</code> for route protection</li>
            <li>Use Laravel Gates and Policies for fine-grained authorization</li>
            <li>Always check authorization on the server-side, never rely on UI hiding</li>
            <li>Use <code>$this->authorize()</code> in controllers</li>
        </ul>
    </div>
</div>
@endsection

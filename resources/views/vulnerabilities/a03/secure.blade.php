@extends('layouts.app')

@section('title', 'A03: SQL Injection - Secure')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">
        <span class="badge bg-success me-2">A03</span>
        Injection (SQL) - Secure
    </h1>
    <a href="{{ route('a03.vulnerable') }}" class="btn btn-danger">
        <i class="bi bi-bug me-1"></i>View Vulnerable Version
    </a>
</div>

<div class="alert alert-success">
    <h5><i class="bi bi-shield-check me-2"></i>Protection Applied</h5>
    <p class="mb-0">
        This search uses <strong>Laravel's Eloquent ORM</strong> which automatically uses prepared statements.
        The same SQL injection attacks will not work here.
    </p>
</div>

<div class="card card-secure mb-4">
    <div class="card-header bg-success text-white">
        <i class="bi bi-shield-check me-2"></i>Product Search (Secure)
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('a03.secure') }}">
            <div class="input-group mb-3">
                <input type="text" name="search" class="form-control" 
                       placeholder="Search products... (try SQL injection here)" value="{{ $search }}">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-search me-1"></i>Search
                </button>
            </div>
        </form>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">No products found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="bi bi-code-slash me-2"></i>Secure Code
    </div>
    <div class="card-body">
        <pre class="code-block"><code>// SECURE: Using Eloquent ORM
$products = Product::where('name', 'like', '%' . $search . '%')->get();

// Laravel converts this to a prepared statement:
// SELECT * FROM products WHERE name LIKE ?
// With parameter: '%search_value%'

// The input is treated as DATA, not SQL code
// So ' OR '1'='1 is searched as literal text</code></pre>

        <h6 class="mt-3">Alternative Secure Methods:</h6>
        <pre class="code-block"><code>// Query Builder with bindings
DB::table('products')
    ->where('name', 'like', '%' . $search . '%')
    ->get();

// Raw query with bindings
DB::select(
    'SELECT * FROM products WHERE name LIKE ?',
    ['%' . $search . '%']
);</code></pre>
    </div>
</div>
@endsection

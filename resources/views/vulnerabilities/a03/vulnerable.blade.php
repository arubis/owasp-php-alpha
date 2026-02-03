@extends('layouts.app')

@section('title', 'A03: SQL Injection - Vulnerable')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">
        <span class="badge bg-danger me-2">A03</span>
        Injection (SQL) - Vulnerable
    </h1>
    <a href="{{ route('a03.secure') }}" class="btn btn-success">
        <i class="bi bi-shield-check me-1"></i>View Secure Version
    </a>
</div>

<div class="alert alert-danger">
    <h5><i class="bi bi-exclamation-triangle me-2"></i>Vulnerability Demonstrated</h5>
    <p class="mb-2">
        This search uses <strong>string concatenation</strong> to build SQL queries.
        User input is directly inserted into the query without sanitization.
    </p>
    <p class="mb-0">
        <strong>Try these attacks:</strong><br>
        <code>' OR '1'='1</code> - Returns all products<br>
        <code>' OR '1'='1' --</code> - Same, with comment
    </p>
</div>

<div class="card card-vulnerable mb-4">
    <div class="card-header bg-danger text-white">
        <i class="bi bi-bug me-2"></i>Product Search (Vulnerable)
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('a03.vulnerable') }}">
            <div class="input-group mb-3">
                <input type="text" name="search" class="form-control" 
                       placeholder="Search products..." value="{{ $search }}">
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-search me-1"></i>Search
                </button>
            </div>
        </form>

        @if($error)
        <div class="alert alert-warning">
            <strong>SQL Error:</strong> {{ $error }}
        </div>
        @endif

        @if($executedQuery)
        <div class="alert alert-secondary">
            <strong>Executed Query:</strong><br>
            <code>{{ $executedQuery }}</code>
        </div>
        @endif

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
                    <td>{{ $product->id ?? $product['id'] }}</td>
                    <td>{{ $product->name ?? $product['name'] }}</td>
                    <td>{{ $product->description ?? $product['description'] }}</td>
                    <td>${{ number_format($product->price ?? $product['price'], 2) }}</td>
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
        <i class="bi bi-code-slash me-2"></i>Vulnerable Code
    </div>
    <div class="card-body">
        <pre class="code-block"><code>// VULNERABLE: Direct string concatenation
$query = "SELECT * FROM products WHERE name LIKE '%" . $search . "%'";
$products = DB::select($query);

// Attack: search = ' OR '1'='1
// Resulting query:
// SELECT * FROM products WHERE name LIKE '%' OR '1'='1%'
// This returns ALL products because '1'='1' is always true!</code></pre>
    </div>
</div>
@endsection

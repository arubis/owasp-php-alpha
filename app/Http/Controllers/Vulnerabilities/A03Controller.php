<?php

namespace App\Http\Controllers\Vulnerabilities;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * A03: Injection (SQL Injection)
 * 
 * This controller demonstrates SQL injection vulnerabilities
 * and how Laravel's Eloquent ORM and Query Builder protect against them.
 */
class A03Controller extends Controller
{
    /**
     * VULNERABLE: SQL Injection through string concatenation
     * 
     * User input is directly concatenated into SQL query without
     * any sanitization or parameterization.
     * 
     * Attack examples:
     * - ' OR '1'='1' -- (returns all products)
     * - ' UNION SELECT id, username, password, email, role FROM users --
     * - '; DROP TABLE products; --
     */
    public function vulnerable(Request $request)
    {
        $search = $request->input('search', '');
        $products = [];
        $error = null;
        $executedQuery = null;

        if ($search) {
            try {
                // VULNERABILITY: Direct string concatenation - SQL Injection!
                $query = "SELECT * FROM products WHERE name LIKE '%" . $search . "%'";
                $executedQuery = $query;
                
                // Using raw query - bypasses all Laravel protections
                $products = DB::select($query);
            } catch (\Exception $e) {
                $error = $e->getMessage();
            }
        } else {
            $products = Product::all();
        }

        return view('vulnerabilities.a03.vulnerable', [
            'products' => $products,
            'search' => $search,
            'error' => $error,
            'executedQuery' => $executedQuery,
        ]);
    }

    /**
     * SECURE: Using Eloquent ORM with automatic parameter binding
     * 
     * Laravel's Eloquent ORM automatically uses prepared statements
     * and parameter binding, making SQL injection impossible.
     */
    public function secure(Request $request)
    {
        $search = $request->input('search', '');
        $products = [];

        if ($search) {
            // SECURE: Eloquent uses prepared statements automatically
            // The search value is bound as a parameter, not concatenated
            $products = Product::where('name', 'like', '%' . $search . '%')->get();
            
            // Alternative secure methods:
            // 1. Query Builder with bindings:
            //    DB::table('products')->where('name', 'like', '%' . $search . '%')->get();
            // 
            // 2. Raw query with bindings:
            //    DB::select('SELECT * FROM products WHERE name LIKE ?', ['%' . $search . '%']);
        } else {
            $products = Product::all();
        }

        return view('vulnerabilities.a03.secure', [
            'products' => $products,
            'search' => $search,
        ]);
    }
}

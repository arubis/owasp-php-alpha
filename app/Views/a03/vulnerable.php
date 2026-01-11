<?php
$title = 'A03: Injection - Vulnerable';
ob_start();
?>

<h1>A03: Injection - Vulnerable Example</h1>

<div class="alert alert-danger">
    <strong>VULNERABLE IMPLEMENTATION</strong><br>
    This example uses string concatenation to build SQL queries, making it vulnerable to SQL Injection attacks.
    <strong>WARNING:</strong> This is for educational purposes only. Do not attempt to exploit production systems.
</div>

<h2>Search Products</h2>

<form method="GET" style="max-width: 500px;">
    <div class="form-group">
        <label for="search">Search:</label>
        <input type="text" id="search" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Enter product name">
    </div>
    <button type="submit" class="btn">Search</button>
</form>

<?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<h3>Products</h3>

<?php if (empty($products)): ?>
    <p>No products found.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
            <tr>
                <td><?= htmlspecialchars($product['id']) ?></td>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td><?= htmlspecialchars($product['description']) ?></td>
                <td>$<?= number_format($product['price'], 2) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<div class="alert alert-info" style="margin-top: 2rem;">
    <strong>Educational Note:</strong> Try searching for: <code>' OR '1'='1</code><br>
    This demonstrates how SQL injection can bypass filters and return all records.
</div>

<p><a href="/a03/secure" class="btn">View Secure Implementation</a></p>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>

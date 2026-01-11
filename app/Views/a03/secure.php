<?php
$title = 'A03: Injection - Secure';
ob_start();
?>

<h1>A03: Injection - Secure Example</h1>

<div class="alert alert-success">
    <strong>SECURE IMPLEMENTATION</strong><br>
    This example uses prepared statements with parameter binding, which prevents SQL injection attacks
    by separating SQL code from data.
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

<div class="alert alert-success" style="margin-top: 2rem;">
    <strong>Security Features:</strong>
    <ul>
        <li>Uses prepared statements with parameter binding</li>
        <li>SQL code is separated from user input</li>
        <li>Database driver handles escaping automatically</li>
        <li>Prevents SQL injection attacks</li>
    </ul>
</div>

<p><a href="/a03/vulnerable" class="btn">View Vulnerable Implementation</a></p>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>

<?php
$title = 'A01: Broken Access Control - Secure';
ob_start();
?>

<h1>A01: Broken Access Control - Secure Example</h1>

<div class="alert alert-success">
    <strong>SECURE IMPLEMENTATION</strong><br>
    This page uses server-side role-based access control. Only admin users can access this page.
    If you try to access this as a regular user, you will be redirected.
</div>

<h2>Admin Panel</h2>
<p><?= htmlspecialchars($message) ?></p>

<h3>All Users</h3>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user['id']) ?></td>
            <td><?= htmlspecialchars($user['username']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= htmlspecialchars($user['role']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<p><a href="/a01/vulnerable/admin" class="btn">View Vulnerable Implementation</a></p>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>

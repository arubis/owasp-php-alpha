<?php
$title = 'A01: Broken Access Control - Vulnerable';
ob_start();
?>

<h1>A01: Broken Access Control - Vulnerable Example</h1>

<div class="alert alert-danger">
    <strong>VULNERABLE IMPLEMENTATION</strong><br>
    This page has NO server-side access control. It only relies on the frontend/hidden links.
    Try accessing this page directly: <code>/a01/vulnerable/admin</code>
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

<p><a href="/a01/secure/admin" class="btn">View Secure Implementation</a></p>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>

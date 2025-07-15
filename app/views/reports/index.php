<?php require_once 'app/views/templates/header.php' ?>
<div class="container">
    <h1>Reports</h1>

    <h2>All Reminders</h2>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Subject</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['reminders'] as $reminder): ?>
                <tr>
                    <td><?= htmlspecialchars($reminder['subject']) ?></td>
                    <td>
                        <a href="/reminders/update/<?= $reminder['id'] ?>">Update</a> |
                        <a href="/reminders/delete/<?= $reminder['id'] ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require_once 'app/views/templates/footer.php' ?>
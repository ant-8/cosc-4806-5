<?php require_once 'app/views/templates/header.php' ?>
<div class="container">
    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <h1>Reminders</h1>
                <p><a href="/reminders/create">Create a new reminder</a></p>
            </div>
        </div>
    </div>

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
                    <td><?= ($reminder['subject']) ?></td>
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
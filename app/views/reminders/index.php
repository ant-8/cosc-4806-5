<?php require_once 'app/views/templates/header.php' ?>

<div class="container mt-4">
    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="display-4">Reminders</h1>
                <p><a href="/reminders/create" class="btn btn-primary">Create a new reminder</a></p>
            </div>
        </div>
    </div>

    <?php if (empty($data['reminders'])): ?>
        <div class="alert alert-warning" role="alert">
            You have no reminders. Create one using the button above.
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-dark">
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
                                <a href="/reminders/update/<?= $reminder['id'] ?>" class="btn btn-sm btn-outline-secondary">Update</a>
                                <a href="/reminders/delete/<?= $reminder['id'] ?>" class="btn btn-sm btn-outline-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php if (isset($_SESSION['flash'])): ?>
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="reminderToast" class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <?= htmlspecialchars($_SESSION['flash']) ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <script>
        const toastEl = document.getElementById('reminderToast');
        const toast = new bootstrap.Toast(toastEl);
        toast.show();
    </script>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<?php require_once 'app/views/templates/footer.php' ?>
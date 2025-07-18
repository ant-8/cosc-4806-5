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

    <h2>User with Most Reminders</h2>
    <?php if ($data['top_user']): ?>
        <p><?= htmlspecialchars($data['top_user']['username']) ?> — <?= $data['top_user']['reminders_count'] ?> reminder(s)</p>
    <?php else: ?>
        <p>No reminders yet.</p>
    <?php endif; ?>

    <canvas id="topReminderChart" width="400" height="200"></canvas>

    <h2>Total Logins by Username</h2>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Username</th>
                <th>Total Logins</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['login_counts'] as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td><?= $row['total_logins'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <canvas id="loginChart" width="400" height="200"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const loginData = <?= json_encode($data['login_counts']) ?>;
    const loginCtx = document.getElementById('loginChart').getContext('2d');
    new Chart(loginCtx, {
        type: 'bar',
        data: {
            labels: loginData.map(row => row.username),
            datasets: [{
                label: 'Total Logins',
                data: loginData.map(row => row.total_logins),
                backgroundColor: 'blue'
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });

    const topUser = <?= json_encode($data['top_user']) ?>;
    if (topUser && topUser.username) {
        const topCtx = document.getElementById('topReminderChart').getContext('2d');
        new Chart(topCtx, {
            type: 'pie',
            data: {
                labels: [topUser.username, 'Others'],
                datasets: [{
                    data: [topUser.reminders_count, <?= count($data['reminders']) - (int)$data['top_user']['reminders_count'] ?>],
                    backgroundColor: ['blue', '#cccccc']
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Reminders: Admin vs Others'
                    }
                }
            }
        });
    }
</script>
<?php require_once 'app/views/templates/footer.php' ?>

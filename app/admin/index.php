<?php
require '../../config/config.php';
require '../../config/function.php';

requireRole('admin');

logActivity(
    $pdo,
    $_SESSION['user_id'],
    $_SESSION['user_email'],
    'view_activity_logs',
    'success'
);

// Activity Logs Query
$stmt = $pdo->query("
SELECT * FROM activity_logs
ORDER BY activity_log_created_at DESC
");

$activities = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Welcome, Admin!</h1>
    <a href="../../auth/signout.php">Sign Out</a>

    <table border="1">
        <thead>
            <tr>
                <th>Record ID</th>
                <th>User ID</th>
                <th>User Email</th>
                <th>Action</th>
                <th>Status</th>
                <th>IP Address</th>
                <th>User Agent</th>
                <th>Date & Time</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($activities as $activity):?>    
                <tr>
                    <td><?= htmlspecialchars($activity['activity_log_id']) ?></td>
                    <td><?= htmlspecialchars($activity['user_id']) ?></td>
                    <td><?= htmlspecialchars($activity['user_email']) ?></td>
                    <td><?= htmlspecialchars($activity['activity_log_action']) ?></td>
                    <td><?= htmlspecialchars($activity['activity_log_status']) ?></td>
                    <td><?= htmlspecialchars($activity['activity_log_ip_address']) ?></td>
                    <td><?= htmlspecialchars($activity['activity_log_user_agent']) ?></td>
                    <td><?= htmlspecialchars($activity['activity_log_created_at']) ?></td>
                </tr>   
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/3.0.4/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/3.0.4/js/dataTables.bootstrap5.min.js"></script>
</html>
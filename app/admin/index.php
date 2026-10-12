<?php
require '../../config/config.php';


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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Activity Logs</title>
<style>
    body {
    background-color: #fff5f8;
    font-family: Arial, sans-serif;
}

.container {
    background: white;
    padding: 30px;
    margin-top: 40px;
    border-radius: 20px;
    box-shadow: 0 5px 20px rgba(214, 51, 132, 0.10);
}

h1 {
    color: #d63384;
    font-weight: 600;
}

.btn-pink {
    background-color: #d63384;
    color: white;
    border: none;
    border-radius: 20px;
    padding: 8px 20px;
}

.btn-pink:hover {
    background-color: #b02a6f;
    color: white;
}

.table thead th {
    background-color: #d63384;
    color: white;
}

.table tbody tr:hover {
    background-color: #fff0f5;
}
</style>
</head>

<body>

<div class="container mt-4">

    <h1>Welcome, Admin!</h1>

    <a href="../../auth/signout.php" class="btn btn-pink mb-3">
        Sign Out
    </a>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">

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
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/3.0.4/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/3.0.4/js/dataTables.bootstrap5.min.js"></script>

</html>


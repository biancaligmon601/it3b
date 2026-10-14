<?php
require '../../config/config.php';
requireRole('admin');

$section = $_GET['section'] ?? '';
$action = $_GET['action'] ?? '';

if ($section === 'activity-logs') {
    // Activity Logs Query
    $stmt = $pdo->query("
        SELECT *
        FROM activity_logs
        ORDER BY activity_log_created_at DESC
    ");
    $activities = $stmt->fetchAll(PDO::FETCH_ASSOC);
} elseif ($section === 'user-sessions') {
    // User Sessions Query
    $stmt = $pdo->query("
        SELECT
            us.session_id,
            us.user_id,
            u.user_username,
            u.user_email,
            u.user_role,
            us.session_start,
            us.session_end,
            us.session_duration
        FROM user_sessions us
        INNER JOIN users u
            ON us.user_id = u.user_id
        ORDER BY us.session_start DESC
    ");
    $sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Admin Dashboard | Pink Theme</title>
    <style>
        :root {
            --pink: #e879a9;
            --pink-dark: #c94f85;
            --pink-light: #fff0f6;
            --pink-pale: #fff8fb;
            --text: #553444;
            --border: #f3c8da;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Segoe UI", Arial, sans-serif;
            color: var(--text);
            background: linear-gradient(135deg, #fff7fb 0%, #fde7f1 50%, #fff9fc 100%);
        }

        .top-banner {
            padding: 32px 20px 26px;
            color: #fff;
            background: linear-gradient(120deg, #e879a9, #d85b94);
            border-radius: 0 0 28px 28px;
            box-shadow: 0 8px 24px rgba(201, 79, 133, .18);
        }

        .top-banner h1 {
            margin: 0 0 8px;
            font-size: clamp(1.7rem, 4vw, 2.35rem);
            font-weight: 750;
        }

        .top-banner p { margin: 0; color: #fff3f8; }

        .signout-btn {
            color: #c94f85;
            background: #fff;
            border: 1px solid rgba(255,255,255,.8);
            border-radius: 999px;
            padding: 9px 18px;
            font-weight: 650;
            text-decoration: none;
            white-space: nowrap;
        }

        .signout-btn:hover { color: #a83468; background: #fff0f6; }

        .page-wrap { width: min(1200px, 94%); margin: 28px auto 50px; }

        .nav-card {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding: 12px;
            margin-bottom: 24px;
            background: rgba(255,255,255,.85);
            border: 1px solid var(--border);
            border-radius: 18px;
            box-shadow: 0 5px 18px rgba(130, 54, 89, .06);
        }

        .nav-card a {
            display: inline-block;
            padding: 10px 16px;
            color: var(--pink-dark);
            text-decoration: none;
            font-weight: 650;
            border-radius: 12px;
            transition: .2s ease;
        }

        .nav-card a:hover, .nav-card a.active {
            color: #fff;
            background: var(--pink);
        }

        .content-card {
            padding: 24px;
            background: rgba(255,255,255,.94);
            border: 1px solid var(--border);
            border-radius: 20px;
            box-shadow: 0 10px 28px rgba(130, 54, 89, .08);
        }

        .content-card h2 {
            margin: 0 0 6px;
            font-size: 1.5rem;
            font-weight: 750;
            color: #9f3d6a;
        }

        .subtitle { margin-bottom: 20px; color: #987285; }

        .table-responsive { border: 1px solid var(--border); border-radius: 14px; }

        table { margin-bottom: 0 !important; font-size: .92rem; }

        .table thead th {
            padding: 14px 12px;
            color: #87385d;
            background: #ffe4ef;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        .table tbody td {
            padding: 12px;
            color: #624456;
            border-color: #f8e1eb;
            vertical-align: middle;
        }

        .table tbody tr:nth-child(even) td { background: #fff9fc; }
        .table tbody tr:hover td { background: #fff0f6; }

        .empty-state {
            padding: 28px !important;
            text-align: center;
            color: #a4778e !important;
        }

        .footer-note { margin-top: 18px; color: #a4778e; font-size: .85rem; text-align: center; }

        @media (max-width: 576px) {
            .top-banner { padding: 24px 16px; }
            .top-banner .header-row { align-items: flex-start !important; gap: 16px; flex-direction: column; }
            .content-card { padding: 16px; }
        }
    </style>
</head>
<body>
    <header class="top-banner">
        <div class="container header-row d-flex justify-content-between align-items-center gap-3">
            <div>
                <h1>Welcome, Bianca Admin!</h1>
            
            </div>
            <a href="../../auth/signout.php" class="signout-btn">Sign Out ↗</a>
        </div>
    </header>

    <main class="page-wrap">
        <nav class="nav-card" aria-label="Admin sections">
            <a href="index.php?section=activity-logs" class="<?= $section === 'activity-logs' ? 'active' : '' ?>"> Activity Logs</a>
            <a href="index.php?section=user-sessions" class="<?= $section === 'user-sessions' ? 'active' : '' ?>"> User Sessions</a>
        </nav>

        <?php if ($section === 'activity-logs'): ?>
            <section class="content-card">
                <h2>Activity Logs</h2>
                
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Record ID</th>
                                <th>User ID</th>
                                <th>User Email</th>
                                <th>Action</th>
                                <th>Status</th>
                                <th>IP Address</th>
                                <th>User Agent</th>
                                <th>Date &amp; Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($activities)): ?>
                                <tr><td colspan="8" class="empty-state">No activity logs found yet ♡</td></tr>
                            <?php else: ?>
                                <?php foreach ($activities as $activity): ?>
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
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        <?php elseif ($section === 'user-sessions'): ?>
            <section class="content-card">
                <h2>User Sessions</h2>
        
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Session ID</th>
                                <th>User ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Session Start</th>
                                <th>Session End</th>
                                <th>Duration</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($sessions)): ?>
                                <tr><td colspan="8" class="empty-state">No user sessions found yet ♡</td></tr>
                            <?php else: ?>
                                <?php foreach ($sessions as $session): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($session['session_id']) ?></td>
                                        <td><?= htmlspecialchars($session['user_id']) ?></td>
                                        <td><?= htmlspecialchars($session['user_username']) ?></td>
                                        <td><?= htmlspecialchars($session['user_email']) ?></td>
                                        <td><?= htmlspecialchars($session['user_role']) ?></td>
                                        <td><?= htmlspecialchars($session['session_start']) ?></td>
                                        <td><?= $session['session_end'] ? htmlspecialchars($session['session_end']) : 'Active' ?></td>
                                        <td>
                                            <?php
                                            if ($session['session_duration'] !== null) {
                                                $seconds = (int) $session['session_duration'];
                                                $hours = floor($seconds / 3600);
                                                $minutes = floor(($seconds % 3600) / 60);
                                                $seconds = $seconds % 60;
                                                echo sprintf('%02d hr %02d min %02d sec', $hours, $minutes, $seconds);
                                            } else {
                                                echo 'Active';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        <?php else: ?>
            <section class="content-card">
                <h2>Welcome to your Admin Dashboard </h2>
                <p class="subtitle mb-0">Choose <strong>Activity Logs</strong> or <strong>User Sessions</strong> above to view records.</p>
            </section>
        <?php endif; ?>

        <p class="footer-note">Made with love · Admin Dashboard</p>
    </main>
</body>
</html>
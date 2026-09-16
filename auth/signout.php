<?php
require_once '../config/config.php';

if(isset ($_SESSION['user_id'])) {
    // Log sign out activity
    logActivity($pdo,$_SESSION['user_id'],$_SESSION['user_email'],'logout','success');
}

session_start();
session_destroy();
header('Location: ' . BASE_URL . '/index.php');
exit();
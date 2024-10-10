<?php
session_start();
// Check if the user is logged in as admin
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] !== 'Admin') {
    header('Location: login.php');
    exit();
}
?>
<h1>Welcome to the Admin Dashboard</h1>
<a href="logout.php">Logout</a>

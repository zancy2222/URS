<?php
session_start();
// Check if the user is logged in as student leader
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] !== 'Student Leader') {
    header('Location: login.php');
    exit();
}
?>
<h1>Welcome to the Student Leader Dashboard</h1>
<a href="logout.php">Logout</a>

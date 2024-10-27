<?php
include 'db_conn.php';

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: ../Accounts.php"); // Redirect back to the account list page
        exit;
    } else {
        echo "Error deleting account: " . $conn->error;
    }
} else {
    echo "No account ID specified.";
}

$conn->close();
?>

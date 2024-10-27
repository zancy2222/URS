<?php
include 'db_conn.php';

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    
    $sql = "DELETE FROM facilities WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo "Facility deleted successfully";
}
$conn->close();
?>

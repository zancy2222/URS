<?php
include 'db_conn.php';

if (isset($_POST['id']) && isset($_POST['name'])) {
    $id = intval($_POST['id']);
    $name = $_POST['name'];
    
    $sql = "UPDATE facilities SET name = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $name, $id);
    $stmt->execute();
    echo "Facility updated successfully";
}
$conn->close();
?>

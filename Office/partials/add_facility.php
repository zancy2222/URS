<?php
include 'db_conn.php';

if (isset($_POST['name'])) {
    $name = $_POST['name'];
    $sql = "INSERT INTO facilities (name) VALUES (?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("s", $name);
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Facility added successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Error adding facility."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Error preparing statement."]);
    }

    $stmt->close();
}
$conn->close();
?>

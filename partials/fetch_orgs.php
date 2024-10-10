<?php
include 'db_conn.php';

$department_id = $_POST['department']; // Use POST method
$query = "SELECT * FROM student_leader_org WHERE department_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $department_id);
$stmt->execute();
$result = $stmt->get_result();

$options = "";
while ($row = $result->fetch_assoc()) {
    $options .= "<option value='" . $row['org_name'] . "'>" . $row['org_name'] . "</option>";
}

echo $options;
?>

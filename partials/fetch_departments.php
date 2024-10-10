<?php
include 'db_conn.php';

$query = "SELECT * FROM college_department WHERE account_type_id = (SELECT id FROM account_type WHERE account_type = 'Student Leader')";
$result = $conn->query($query);

$options = "";
while ($row = $result->fetch_assoc()) {
    $options .= "<option value='" . $row['id'] . "'>" . $row['department_name'] . "</option>";
}

echo $options;
?>

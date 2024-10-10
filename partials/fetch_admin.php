<?php
include 'db_conn.php';

$query = "SELECT * FROM admin_account WHERE account_type_id = (SELECT id FROM account_type WHERE account_type = 'Admin')";
$result = $conn->query($query);

$options = "";
while ($row = $result->fetch_assoc()) {
    $options .= "<option value='" . $row['role'] . "'>" . $row['role'] . "</option>";
}

echo $options;
?>

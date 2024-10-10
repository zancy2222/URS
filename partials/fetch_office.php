<?php
include 'db_conn.php';

$query = "SELECT * FROM office_account";
$result = $conn->query($query);

$options = "";
while ($row = $result->fetch_assoc()) {
    $options .= "<option value='" . $row['office_name'] . "'>" . $row['office_name'] . "</option>";
}

echo $options;
?>

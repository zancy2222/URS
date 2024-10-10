<?php
include 'db_conn.php';

$query = "SELECT * FROM account_type";
$result = $conn->query($query);

$options = "";
while ($row = $result->fetch_assoc()) {
    $options .= "<option value='" . $row['account_type'] . "'>" . $row['account_type'] . "</option>";
}

echo $options;
?>

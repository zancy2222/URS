<?php
include 'db_conn.php';

// Handle account type selection
if (isset($_POST['account_type'])) {
    $account_type = $_POST['account_type'];

    if ($account_type == '1') { // Admin
        $query = "SELECT id, account_name FROM admin_account";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['id'] . '">' . $row['account_name'] . '</option>';
            }
        }
    } elseif ($account_type == '2') { // Student Leader
        $query = "SELECT id, department_name FROM college_department";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['id'] . '">' . $row['department_name'] . '</option>';
            }
        }
    } elseif ($account_type == '3') { // Office
        $query = "SELECT id, office_name FROM office";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['id'] . '">' . $row['office_name'] . '</option>';
            }
        }
    }
}

// Handle department selection (for organizations)
if (isset($_POST['department_id'])) {
    $department_id = $_POST['department_id'];

    $query = "SELECT id, org_name FROM org WHERE department_id = $department_id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['id'] . '">' . $row['org_name'] . '</option>';
        }
    }
}

$conn->close();
?>

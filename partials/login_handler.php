<?php
session_start();
include 'db_conn.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $account_type = $_POST['account_type'];
    $admin_account = isset($_POST['admin_account']) ? $_POST['admin_account'] : null;
    $department = isset($_POST['department']) ? $_POST['department'] : null;
    $org = isset($_POST['org']) ? $_POST['org'] : null;
    $office = isset($_POST['office']) ? $_POST['office'] : null;

    // Check if the user exists in the database
    $sql = "SELECT * FROM users WHERE username = ? AND account_type_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $username, $account_type);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Check if the user's sub-account matches the login attempt
            if ($account_type == 1 && $user['admin_account_id'] == $admin_account) { // Admin
                // Set session variables
                $_SESSION['username'] = $user['username'];
                $_SESSION['account_type'] = $user['account_type_id'];
                $_SESSION['sub_account'] = $user['admin_account_id'];
                header("Location: ../Admin/index.php");
                exit();
            } elseif ($account_type == 2 && $user['department_id'] == $department && $user['org_id'] == $org) { // Student Leader
                // Set session variables
                $_SESSION['username'] = $user['username'];
                $_SESSION['account_type'] = $user['account_type_id'];
                $_SESSION['sub_account'] = $user['org_id'];
                header("Location: ../StudentLeader/index.php");
                exit();
            } elseif ($account_type == 3 && $user['office_id'] == $office) { // Office
                // Set session variables
                $_SESSION['username'] = $user['username'];
                $_SESSION['account_type'] = $user['account_type_id'];
                header("Location: ../Office/index.php");
                exit();
            } else {
                echo "User account does not match the specified criteria.";
            }
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with this username and account type.";
    }

    $stmt->close();
}

$conn->close();
?>

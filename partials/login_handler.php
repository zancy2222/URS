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
                $_SESSION['admin_account_id'] = $user['admin_account_id'];  // Set this variable

                // Check if admin account is OSDS
                $_SESSION['is_osds'] = ($user['admin_account_id'] == 3); // Assuming OSDS has ID 3

                header("Location: ../Admin/index.php");
                exit();
            } elseif ($account_type == 2 && $user['department_id'] == $department && $user['org_id'] == $org) { // Student Leader
                $_SESSION['username'] = $user['username'];
                $_SESSION['account_type'] = $user['account_type_id'];
                $_SESSION['sub_account'] = $user['org_id'];
                $_SESSION['org_id'] = $user['org_id']; // Store org ID for later use
                $_SESSION['user_id'] = $user['id']; // Ensure user_id is set
                header("Location: ../StudentLeader/index.php");
                exit();
            } elseif ($account_type == 3 && $user['office_id'] == $office) { // Office
                $_SESSION['username'] = $user['username'];
                $_SESSION['account_type'] = $user['account_type_id'];
                $_SESSION['office_id'] = $user['office_id'];
                $_SESSION['user_id'] = $user['id']; // Set user ID for session
                header("Location: ../Office/index.php");
                exit();
            } else {
                echo "<script>alert('User account does not match the specified criteria.'); window.location.href = '../login.php';</script>";
                exit();
            }
        } else {
            echo "<script>alert('Invalid password.'); window.location.href = '../login.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('No user found with this username and account type.'); window.location.href = '../login.php';</script>";
        exit();
    }

    $stmt->close();
}

$conn->close();

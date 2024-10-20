<?php 
include 'partials/db_conn.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $account_type = $_POST['account_type'];
    $admin_account = isset($_POST['admin_account']) ? $_POST['admin_account'] : null;
    $department = isset($_POST['department']) ? $_POST['department'] : null;
    $org = isset($_POST['org']) ? $_POST['org'] : null;
    $office = isset($_POST['office']) ? $_POST['office'] : null;

    // Check if the username already exists for the selected account type
    $check_sql = "SELECT * FROM users WHERE username = ? AND account_type_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    
    if ($check_stmt === false) {
        die("Error preparing statement: " . $conn->error); // Handle error
    }

    $check_stmt->bind_param('si', $username, $account_type);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        echo "Username already exists for this account type.";
    } else {
        // Insert user into the `users` table
        $sql = "INSERT INTO users (username, password, account_type_id, admin_account_id, department_id, org_id, office_id) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error); // Handle error
        }

        $stmt->bind_param('ssiiiii', $username, $password, $account_type, $admin_account, $department, $org, $office);

        if ($stmt->execute()) {
            header("Location: Accounts.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $check_stmt->close();
}

$conn->close();
?>

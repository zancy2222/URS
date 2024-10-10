<?php
    include 'db_conn.php'; // Include your DB connection script

    if (isset($_POST['role_type']) && isset($_POST['role_id'])) {
        $role_type = $_POST['role_type'];
        $role_id = $_POST['role_id'];

        $query = "SELECT password FROM user_passwords WHERE role_type = ? AND role_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $role_type, $role_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            echo $row['password'];
        } else {
            echo "Password not found";
        }

        $stmt->close();
        $conn->close();
    }
?>

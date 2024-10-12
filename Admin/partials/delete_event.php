<?php 
include 'db_conn.php'; // Ensure you have the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and get the POST data
    $event_id = intval($_POST['event_id']);

    // Delete from each relevant event table
    $tables = ['guest_events', 'admin_events', 'student_leader_events', 'office_events'];

    $isDeleted = true; // Track if deletion was successful

    foreach ($tables as $table) {
        $sql = "DELETE FROM $table WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $event_id);
        
        if (!$stmt->execute()) {
            $isDeleted = false; // If any deletion fails, set this to false
            break; // Exit the loop if there's an error
        }
    }

    if ($isDeleted) {
        // Successful deletion
        header("Location: ../view_booking.php?status=deleted");
        exit();
    } else {
        // Handle deletion failure
        echo "Error deleting event: " . $stmt->error;
    }
} else {
    echo "Invalid request.";
}
?>

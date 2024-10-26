<?php 
include 'db_conn.php'; // Ensure database connection is available

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get and sanitize the event ID
    $event_id = intval($_POST['event_id']);

    // Delete the event from admin_events only
    $sql = "DELETE FROM admin_events WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $event_id);

    if ($stmt->execute()) {
        // Successful deletion
        echo "<script>alert('Event deleted Successfully!'); window.location.href = '../view_booking.php';</script>";
        exit();
    } else {
        // Handle deletion failure
        echo "Error deleting event: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}
$conn->close();
?>

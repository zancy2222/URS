<?php
session_start();
include 'db_conn.php';

header('Content-Type: application/json');

$events = [];

// Fetch guest events
$query_guest = "SELECT * FROM guest_events";
$result_guest = $conn->query($query_guest);

// Process guest events
if ($result_guest) {
    while ($row = $result_guest->fetch_assoc()) {
        $events[] = [
            'id' => $row['id'],
            'event_name' => $row['event_name'],
            'start_date' => $row['start_date'],
            'end_date' => $row['end_date'],
            'facility' => $row['facility'],
            'event_description' => $row['event_description'],
            'status' => $row['status'],
            'type' => 'guest' // Indicating the type of event
        ];
    }
}

// Fetch admin events
$query_admin = "SELECT * FROM admin_events";
$result_admin = $conn->query($query_admin);

// Process admin events
if ($result_admin) {
    while ($row = $result_admin->fetch_assoc()) {
        $events[] = [
            'id' => $row['id'],
            'event_name' => $row['event_name'],
            'start_date' => $row['start_date'],
            'end_date' => $row['end_date'],
            'facility' => $row['facility'],
            'event_description' => $row['event_description'],
            'status' => $row['status'], // Include the status field
            'type' => 'admin' // Indicating the type of event
        ];
    }
}

// Fetch student leader events
$query_student_leader = "SELECT * FROM student_leader_events"; // Adjust table name as needed
$result_student_leader = $conn->query($query_student_leader);

// Process student leader events
if ($result_student_leader) {
    while ($row = $result_student_leader->fetch_assoc()) {
        $events[] = [
            'id' => $row['id'],
            'event_name' => $row['event_name'],
            'start_date' => $row['start_date'],
            'end_date' => $row['end_date'],
            'facility' => $row['facility'],
            'event_description' => $row['event_description'],
            'status' => $row['status'], // Include the status field
            'type' => 'student_leader' // Indicating the type of event
        ];
    }
}

// Fetch office events
$query_office_events = "SELECT * FROM office_events"; // Adjust table name as needed
$result_office_events = $conn->query($query_office_events);

// Process office events
if ($result_office_events) {
    while ($row = $result_office_events->fetch_assoc()) {
        $events[] = [
            'id' => $row['id'],
            'event_name' => $row['event_name'],
            'start_date' => $row['start_date'],
            'end_date' => $row['end_date'],
            'facility' => $row['facility'],
            'event_description' => $row['event_description'],
            'status' => $row['status'], // Include the status field
            'type' => 'office' // Indicating the type of event
        ];
    }
}

echo json_encode($events);
$conn->close();
?>

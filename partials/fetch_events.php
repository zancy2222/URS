<?php
session_start();
include 'db_conn.php';

header('Content-Type: application/json');

$events = [];

// Fetch guest events
$query_guest = "SELECT event_name, start_date, end_date, start_time, end_time, facility, event_description, status FROM guest_events";
$result_guest = $conn->query($query_guest);

if ($result_guest) {
    while ($row = $result_guest->fetch_assoc()) {
        $events[] = [
            'event_name' => $row['event_name'],
            'start_date' => $row['start_date'],
            'end_date' => $row['end_date'],
            'start_time' => $row['start_time'], // Fetching the start time
            'end_time' => $row['end_time'], // Fetching the end time
            'facility' => $row['facility'],
            'event_description' => $row['event_description'],
            'status' => $row['status']
        ];
    }
}

// Fetch admin events
$query_admin = "SELECT event_name, start_date, end_date, start_time, end_time, facility, event_description, status FROM admin_events";
$result_admin = $conn->query($query_admin);

if ($result_admin) {
    while ($row = $result_admin->fetch_assoc()) {
        $events[] = [
            'event_name' => $row['event_name'],
            'start_date' => $row['start_date'],
            'end_date' => $row['end_date'],
            'start_time' => $row['start_time'],
            'end_time' => $row['end_time'],
            'facility' => $row['facility'],
            'event_description' => $row['event_description'],
            'status' => $row['status']
        ];
    }
}

// Fetch student leader events
$query_student_leader = "SELECT event_name, start_date, end_date, start_time, end_time, facility, event_description, status FROM student_leader_events";
$result_student_leader = $conn->query($query_student_leader);

if ($result_student_leader) {
    while ($row = $result_student_leader->fetch_assoc()) {
        $events[] = [
            'event_name' => $row['event_name'],
            'start_date' => $row['start_date'],
            'end_date' => $row['end_date'],
            'start_time' => $row['start_time'],
            'end_time' => $row['end_time'],
            'facility' => $row['facility'],
            'event_description' => $row['event_description'],
            'status' => $row['status']
        ];
    }
}

// Fetch office events
$query_office = "SELECT event_name, start_date, end_date, start_time, end_time, facility, event_description, status FROM office_events";
$result_office = $conn->query($query_office);

if ($result_office) {
    while ($row = $result_office->fetch_assoc()) {
        $events[] = [
            'event_name' => $row['event_name'],
            'start_date' => $row['start_date'],
            'end_date' => $row['end_date'],
            'start_time' => $row['start_time'],
            'end_time' => $row['end_time'],
            'facility' => $row['facility'],
            'event_description' => $row['event_description'],
            'status' => $row['status']
        ];
    }
}

echo json_encode($events);
$conn->close();
?>

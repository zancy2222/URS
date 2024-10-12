<?php
session_start();
include 'db_conn.php';

header('Content-Type: application/json');

$query = "SELECT * FROM guest_events";
$result = $conn->query($query);

$events = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $events[] = [
            'id' => $row['id'],
            'event_name' => $row['event_name'],
            'start_date' => $row['start_date'],
            'end_date' => $row['end_date'],
            'facility' => $row['facility'],
            'event_description' => $row['event_description'],
            'status' => $row['status']
        ];
    }
}

echo json_encode($events);
$conn->close();
?>

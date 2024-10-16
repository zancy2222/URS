<?php
session_start();
include 'db_conn.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $eventName = $_POST['eventName'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];
    $facility = $_POST['facility'];
    $eventDescription = $_POST['eventDescription'];

    // File upload handling
    $letterOfRequest = $_FILES['letterOfRequest'];
    $facilityFormRequest = $_FILES['facilityFormRequest'];
    $contractOfLease = $_FILES['contractOfLease'];

    // Store only the filenames
    $letterOfRequestName = null;
    $facilityFormRequestName = null;
    $contractOfLeaseName = null;

    // Upload files if they are uploaded without errors
    if ($letterOfRequest['error'] === UPLOAD_ERR_OK) {
        $letterOfRequestName = basename($letterOfRequest['name']);
        move_uploaded_file($letterOfRequest['tmp_name'], 'uploads/' . $letterOfRequestName);
    }
    if ($facilityFormRequest['error'] === UPLOAD_ERR_OK) {
        $facilityFormRequestName = basename($facilityFormRequest['name']);
        move_uploaded_file($facilityFormRequest['tmp_name'], 'uploads/' . $facilityFormRequestName);
    }
    if ($contractOfLease['error'] === UPLOAD_ERR_OK) {
        $contractOfLeaseName = basename($contractOfLease['name']);
        move_uploaded_file($contractOfLease['tmp_name'], 'uploads/' . $contractOfLeaseName);
    }

    // Generate session id or use existing one
    if (!isset($_SESSION['session_id'])) {
        $_SESSION['session_id'] = uniqid('guest_', true); // Generates a unique session ID
    }
    $session_id = $_SESSION['session_id'];

    // Check for date conflicts

    // Check for overlapping events across all tables
    $conflictQuery = "
    SELECT * FROM (
        SELECT facility, start_date, end_date, start_time, end_time FROM office_events
        UNION ALL
        SELECT facility, start_date, end_date, start_time, end_time FROM admin_events
        UNION ALL
        SELECT facility, start_date, end_date, start_time, end_time FROM student_leader_events
        UNION ALL
        SELECT facility, start_date, end_date, start_time, end_time FROM guest_events
    ) AS all_events
    WHERE facility = ? AND (
        (start_date <= ? AND end_date >= ?) OR 
        (start_date <= ? AND end_date >= ?) OR
        (start_date >= ? AND end_date <= ?)
    )
";

    // Prepare the statement
    $conflictCheck = $conn->prepare($conflictQuery);
    $conflictCheck->bind_param("sssssss", $facility, $endDate, $startDate, $startDate, $endDate, $startDate, $endDate);
    $conflictCheck->execute();
    $result = $conflictCheck->get_result();

    // Check if any rows were returned (indicating a conflict)
    if ($result->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Please choose different dates; the selected dates are already taken."]);
        exit(); // Exit the script if a conflict is found
    }

    // Prepare and bind for inserting event
    $stmt = $conn->prepare("INSERT INTO guest_events (session_id, email, event_name, start_date, end_date, start_time, end_time, facility, event_description, letter_of_request, facility_form_request, contract_of_lease) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssss", $session_id, $email, $eventName, $startDate, $endDate, $startTime, $endTime, $facility, $eventDescription, $letterOfRequestName, $facilityFormRequestName, $contractOfLeaseName);
    
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Event booked successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to book event: " . $stmt->error]);
    }
    
    $stmt->close();
    $conflictCheck->close();
}

$conn->close();
?>

<?php
session_start();
include 'db_conn.php';

// Check if the user is logged in and is a student leader
if (!isset($_SESSION['user_id'])) {
    die("User is not logged in.");
}

// Check if the user_id is set
if (!isset($_SESSION['user_id'])) {
    die("User ID is not set in the session.");
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture form inputs
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

    $letterOfRequestName = null;
    $facilityFormRequestName = null;
    $contractOfLeaseName = null;

    // Handle file uploads if files were uploaded without errors
    if ($letterOfRequest['error'] === UPLOAD_ERR_OK) {
        // Store only the file name
        $letterOfRequestName = basename($letterOfRequest['name']);
        move_uploaded_file($letterOfRequest['tmp_name'], '../../partials/uploads/' . $letterOfRequestName);
    }
    if ($facilityFormRequest['error'] === UPLOAD_ERR_OK) {
        // Store only the file name
        $facilityFormRequestName = basename($facilityFormRequest['name']);
        move_uploaded_file($facilityFormRequest['tmp_name'], '../../partials/uploads/' . $facilityFormRequestName);
    }
    if ($contractOfLease['error'] === UPLOAD_ERR_OK) {
        // Store only the file name
        $contractOfLeaseName = basename($contractOfLease['name']);
        move_uploaded_file($contractOfLease['tmp_name'], '../../partials/uploads/' . $contractOfLeaseName);
    }

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


    // Prepare and bind the statement to insert the event data
    $stmt = $conn->prepare("INSERT INTO student_leader_events (student_leader_id, email, event_name, start_date, end_date, start_time, end_time, facility, event_description, letter_of_request, facility_form_request, contract_of_lease, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')");

    // Fetch student leader ID from the session
    $studentLeaderId = $_SESSION['user_id'];

    // Bind the parameters to the prepared statement
    $stmt->bind_param("isssssssssss", $studentLeaderId, $email, $eventName, $startDate, $endDate, $startTime, $endTime, $facility, $eventDescription, $letterOfRequestName, $facilityFormRequestName, $contractOfLeaseName);
    
    // Execute the query and check if the event was created successfully
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Event created successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to create event: " . $stmt->error]);
    }
    
    // Close the statement and conflict check
    $stmt->close();
    $conflictCheck->close();
}

$conn->close();
?>

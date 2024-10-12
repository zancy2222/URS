<?php
session_start();
include 'db_conn.php';

// Check if the user is an admin
if (!isset($_SESSION['username']) || $_SESSION['account_type'] != 1) {
    header("Location: login.php");
    exit();
}

// Check if the admin_account_id is set
if (!isset($_SESSION['admin_account_id'])) {
    die("Admin account ID is not set in the session.");
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];  // Capture email input
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

    $letterOfRequestPath = null;
    $facilityFormRequestPath = null;
    $contractOfLeasePath = null;

    // Handle file uploads if files were uploaded without errors
    if ($letterOfRequest['error'] === UPLOAD_ERR_OK) {
        $letterOfRequestPath = '../partials/uploads/' . basename($letterOfRequest['name']);
        move_uploaded_file($letterOfRequest['tmp_name'], $letterOfRequestPath);
    }
    if ($facilityFormRequest['error'] === UPLOAD_ERR_OK) {
        $facilityFormRequestPath = '../partials/uploads/' . basename($facilityFormRequest['name']);
        move_uploaded_file($facilityFormRequest['tmp_name'], $facilityFormRequestPath);
    }
    if ($contractOfLease['error'] === UPLOAD_ERR_OK) {
        $contractOfLeasePath = '../partials/uploads/' . basename($contractOfLease['name']);
        move_uploaded_file($contractOfLease['tmp_name'], $contractOfLeasePath);
    }

    // Check for date conflicts
    $conflictCheck = $conn->prepare("SELECT * FROM admin_events WHERE facility = ? AND (
        (start_date <= ? AND end_date >= ?) OR 
        (start_date <= ? AND end_date >= ?) OR
        (start_date >= ? AND end_date <= ?)
    )");

    // Bind parameters to check for conflicts in dates for the selected facility
    $conflictCheck->bind_param("sssssss", $facility, $endDate, $startDate, $startDate, $endDate, $startDate, $endDate);
    $conflictCheck->execute();
    $result = $conflictCheck->get_result();

    // If there is a date conflict, return an error message
    if ($result->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Please choose different dates; the selected dates are already taken."]);
        exit(); // Exit the script
    }

    // Prepare and bind the statement to insert the event data
    $stmt = $conn->prepare("INSERT INTO admin_events (admin_id, email, event_name, start_date, end_date, start_time, end_time, facility, event_description, letter_of_request, facility_form_request, contract_of_lease) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Fetch admin_id from the session
    $admin_id = $_SESSION['admin_account_id'];

    // Bind the parameters to the prepared statement
    $stmt->bind_param("isssssssssss", $admin_id, $email, $eventName, $startDate, $endDate, $startTime, $endTime, $facility, $eventDescription, $letterOfRequestPath, $facilityFormRequestPath, $contractOfLeasePath);
    
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

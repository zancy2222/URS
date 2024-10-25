<?php
session_start();
include 'db_conn.php'; // Adjust path as necessary

// Check if the user is an office user
if (!isset($_SESSION['username']) || $_SESSION['account_type'] != 3) {
    header("Location: ../login.php");
    exit();
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
    $officeName = $_POST['officeName']; // Ensure this variable is defined

    // File upload handling
    $letterOfRequest = $_FILES['letterOfRequest'];
    $facilityFormRequest = $_FILES['facilityFormRequest'];
    $contractOfLease = $_FILES['contractOfLease'];

    // Store only the filenames
    $letterOfRequestName = null;
    $facilityFormRequestName = null;
    $contractOfLeaseName = null;

    // Handle file uploads if files were uploaded without errors
    if ($letterOfRequest['error'] === UPLOAD_ERR_OK) {
        $letterOfRequestName = basename($letterOfRequest['name']);
        move_uploaded_file($letterOfRequest['tmp_name'], '../../partials/uploads/' . $letterOfRequestName);
    }
    if ($facilityFormRequest['error'] === UPLOAD_ERR_OK) {
        $facilityFormRequestName = basename($facilityFormRequest['name']);
        move_uploaded_file($facilityFormRequest['tmp_name'], '../../partials/uploads/' . $facilityFormRequestName);
    }
    if ($contractOfLease['error'] === UPLOAD_ERR_OK) {
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
    $stmt = $conn->prepare("INSERT INTO office_events (user_id, email, event_name, start_date, end_date, start_time, end_time, facility, event_description, letter_of_request, facility_form_request, contract_of_lease, office_name) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Fetch user_id from the session
    $user_id = $_SESSION['user_id'];

    // Bind the parameters to the prepared statement, using only the file names
    $stmt->bind_param("issssssssssss", $user_id, $email, $eventName, $startDate, $endDate, $startTime, $endTime, $facility, $eventDescription, $letterOfRequestName, $facilityFormRequestName, $contractOfLeaseName, $officeName);

    // Execute the query and check if the event was created successfully
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Event booked successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to book event: " . $stmt->error]);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}

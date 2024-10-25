<?php
include 'db_conn.php'; // Ensure connection to the database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $eventId = $_POST['event_id'];
    $eventName = $_POST['event_name'];
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];
    $facility = $_POST['facility'];
    $eventDescription = $_POST['event_description'];

    // Initialize file variables
    $letterOfRequest = $_FILES['letter_of_request'];
    $facilityFormRequest = $_FILES['facility_form_request'];
    $contractOfLease = $_FILES['contract_of_lease'];

    // Fetch current event data from the database
    $currentQuery = "SELECT letter_of_request, facility_form_request, contract_of_lease FROM admin_events WHERE id = ?";
    $stmt = $conn->prepare($currentQuery);
    $stmt->bind_param('i', $eventId);
    $stmt->execute();
    $currentData = $stmt->get_result()->fetch_assoc();
    
    // Prepare update query
    $query = "UPDATE admin_events SET 
                event_name = ?, 
                start_date = ?, 
                end_date = ?, 
                start_time = ?, 
                end_time = ?, 
                facility = ?, 
                event_description = ?";

    $params = [$eventName, $startDate, $endDate, $startTime, $endTime, $facility, $eventDescription];

    // Check if any file uploads exist and process them
    // Letter of Request
    if ($letterOfRequest['error'] === UPLOAD_ERR_OK) {
        $letterOfRequestPath = 'uploads/' . basename($letterOfRequest['name']);
        move_uploaded_file($letterOfRequest['tmp_name'], "../../partials/$letterOfRequestPath");
        $query .= ", letter_of_request = ?";
        $params[] = $letterOfRequestPath;
    } else {
        // If no new file is uploaded, retain the old file path
        $query .= ", letter_of_request = ?";
        $params[] = $currentData['letter_of_request'];
    }

    // Facility Form Request
    if ($facilityFormRequest['error'] === UPLOAD_ERR_OK) {
        $facilityFormRequestPath = 'uploads/' . basename($facilityFormRequest['name']);
        move_uploaded_file($facilityFormRequest['tmp_name'], "../../partials/$facilityFormRequestPath");
        $query .= ", facility_form_request = ?";
        $params[] = $facilityFormRequestPath;
    } else {
        // If no new file is uploaded, retain the old file path
        $query .= ", facility_form_request = ?";
        $params[] = $currentData['facility_form_request'];
    }

    // Contract of Lease
    if ($contractOfLease['error'] === UPLOAD_ERR_OK) {
        $contractOfLeasePath = 'uploads/' . basename($contractOfLease['name']);
        move_uploaded_file($contractOfLease['tmp_name'], "../../partials/$contractOfLeasePath");
        $query .= ", contract_of_lease = ?";
        $params[] = $contractOfLeasePath;
    } else {
        // If no new file is uploaded, retain the old file path
        $query .= ", contract_of_lease = ?";
        $params[] = $currentData['contract_of_lease'];
    }

    // Complete the query
    $query .= " WHERE id = ?";
    $params[] = $eventId;

    // Prepare and execute the statement
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param(str_repeat('s', count($params)), ...$params); // Bind parameters
        if ($stmt->execute()) {
            // Redirect or notify success
            header("Location: ../view_booking.php?msg=Event updated successfully");
            exit();
        } else {
            // Handle execution failure
            echo "Error updating record: " . $stmt->error;
        }
    } else {
        // Handle preparation failure
        echo "Error preparing statement: " . $conn->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Handle invalid request method
    echo "Invalid request method.";
}
?>

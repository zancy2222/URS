<?php
include 'db_conn.php'; // Ensure you have the database connection
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $event_id = $_POST['event_id'];
    $user_id = $_POST['user_id'];
    $comments = $_POST['comments'];
    $options = isset($_POST['options']) ? implode(',', $_POST['options']) : '';
    $status = $_POST['status']; // Get the status from the form

    // Determine event type based on the event_id
    $checkQuery = "
        SELECT 'admin' AS event_type, id FROM admin_events WHERE id = ?
        UNION ALL
        SELECT 'student_leader' AS event_type, id FROM student_leader_events WHERE id = ?
        UNION ALL
        SELECT 'office' AS event_type, id FROM office_events WHERE id = ?
    ";

    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("iii", $event_id, $event_id, $event_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $event_type = $row['event_type']; // Get the event type

        // Retrieve the email address associated with the event
        $emailQuery = "";
        switch ($event_type) {
            case 'admin':
                $emailQuery = "SELECT email FROM admin_events WHERE id = ?";
                break;
            case 'student_leader':
                $emailQuery = "SELECT email FROM student_leader_events WHERE id = ?";
                break;
            case 'office':
                $emailQuery = "SELECT email FROM office_events WHERE id = ?";
                break;
            default:
                echo "Invalid event type.";
                exit();
        }

        $emailStmt = $conn->prepare($emailQuery);
        $emailStmt->bind_param("i", $event_id);
        $emailStmt->execute();
        $emailResult = $emailStmt->get_result();

        if ($emailResult->num_rows > 0) {
            $emailRow = $emailResult->fetch_assoc();
            $recipientEmail = $emailRow['email']; // Get the recipient email

            // Start transaction
            $conn->begin_transaction();

            try {
                // Insert review into the event_reviews table
                $insertQuery = "INSERT INTO event_reviews (event_id, event_type, user_id, comments, options) VALUES (?, ?, ?, ?, ?)";
                $insertStmt = $conn->prepare($insertQuery);
                $insertStmt->bind_param("issss", $event_id, $event_type, $user_id, $comments, $options);
                $insertStmt->execute();

                // Update the event status in the corresponding table
                // Update the event status in the corresponding table
                $updateQuery = "UPDATE {$event_type}_events SET status = ? WHERE id = ?";
                $updateStmt = $conn->prepare($updateQuery);
                $updateStmt->bind_param("si", $status, $event_id);
                $updateStmt->execute();

                // Commit the transaction
                $conn->commit();

                // Prepare to send email notification
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'danielzanbaltazar.forwork@gmail.com';
                $mail->Password = 'nqzk mmww mxin ikve';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Recipients
                $mail->setFrom('danielzanbaltazar.forwork@gmail.com', 'Event Review');
                $mail->addAddress($recipientEmail); // Send to the event's associated email

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'New Event Review Submitted';
                $mail->Body = "A new review has been submitted for event ID: $event_id.<br>
                               User ID: $user_id.<br>
                               Comments: $comments.<br>
                               Options: $options.<br>
                               The event status has been updated to: <strong>$status</strong>.";

                $mail->send();
                echo 'Review submitted and notification sent.';
            } catch (Exception $e) {
                $conn->rollback(); // Rollback the transaction if something fails
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo "No email address found for the specified event.";
        }
        $emailStmt->close();
    } else {
        echo "Invalid event ID.";
    }

    $stmt->close();
    $conn->close();

    // Redirect or show a success message
    header('Location: ../Process_booking.php?success=Review submitted and email notification sent.');
    exit();
}

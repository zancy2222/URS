<?php
include 'db_conn.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and get the POST data
    $event_id = intval($_POST['event_id']);
    $status = $_POST['status'];
    $event_type = $_POST['event_type']; // Get event type from form

    // Determine which table to update based on the event type
    switch ($event_type) {
        case 'guest':
            $table = 'guest_events';
            break;
        case 'admin':
            $table = 'admin_events';
            break;
        case 'student_leader':
            $table = 'student_leader_events';
            break;
        case 'office':
            $table = 'office_events';
            break;
        default:
            // Invalid event type
            die('Invalid event type.');
    }

    // Update query for the correct table
    $sql = "UPDATE $table SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $status, $event_id);

    if ($stmt->execute()) {
        // Fetch the email for notifications
        $emailQuery = "SELECT email FROM $table WHERE id = ?";
        $stmt = $conn->prepare($emailQuery);
        $stmt->bind_param('i', $event_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $emails = [];
        while ($row = $result->fetch_assoc()) {
            $emails[] = $row['email'];
        }

        // Send email notification
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'danielzanbaltazar.forwork@gmail.com';
            $mail->Password = 'nqzk mmww mxin ikve'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Email content
            $mail->isHTML(true);
            $mail->setFrom('danielzanbaltazar.forwork@gmail.com', 'URSFEMSS'); 
            $mail->Subject = 'Event Status Update';
            $mail->Body = "Dear User,<br>Your event status has been updated to: <strong>$status</strong>.<br>Thank you.";

            // Loop through each email and send notifications
            foreach ($emails as $email) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) { // Check if the email format is valid
                    $mail->addAddress($email); // Add each recipient
                    $mail->send();
                    $mail->clearAddresses(); // Clear addresses for next iteration
                }
            }
        } catch (Exception $e) {
            echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        // Redirect back or show a success message
        header("Location: ../view_booking.php?status=success");
        exit();
    } else {
        // Handle the error
        echo "Error updating record: " . $stmt->error;
    }
} else {
    echo "Invalid request.";
}
?>

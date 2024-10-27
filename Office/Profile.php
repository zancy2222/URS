<?php 
session_start();
include 'partials/db_conn.php'; // Ensure connection to the database

// Change account_type from 2 (admin) to 3 (office)
if (!isset($_SESSION['username']) || $_SESSION['account_type'] != 3) {
    header("Location: login.php");
    exit();
}

// Get the logged-in user's details
$username = $_SESSION['username'];
$query = "SELECT u.username, u.password, at.account_type, u.office_id
          FROM users u
          JOIN account_type at ON u.account_type_id = at.id
          WHERE u.username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "No user data found!";
    exit();
}

// Get current file paths before form submission
$current_event_query = "SELECT letter_of_request, facility_form_request, contract_of_lease FROM office_events WHERE user_id = ?";
$current_stmt = $conn->prepare($current_event_query);
$current_stmt->bind_param('i', $user['office_id']); // Change admin_account_id to office_id
$current_stmt->execute();
$current_result = $current_stmt->get_result();
$current_files = $current_result->fetch_assoc();

// Handle form submission for updating profile information
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // File uploads
    $uploads_dir = '../partials/uploads/'; // Set the directory for file uploads

    // Prepare file variables to only save filenames
    $letter_of_request = $_FILES['letter_of_request']['name'] ? basename($_FILES['letter_of_request']['name']) : $current_files['letter_of_request'];
    $facility_form_request = $_FILES['facility_form_request']['name'] ? basename($_FILES['facility_form_request']['name']) : $current_files['facility_form_request'];
    $contract_of_lease = $_FILES['contract_of_lease']['name'] ? basename($_FILES['contract_of_lease']['name']) : $current_files['contract_of_lease']; // Change default to current value

    // Move uploaded files
    $upload_success = true; // Flag to check if all uploads are successful
    if ($_FILES['letter_of_request']['name']) {
        if (!move_uploaded_file($_FILES['letter_of_request']['tmp_name'], $uploads_dir . $letter_of_request)) {
            echo "Error uploading Letter of Request.";
            $upload_success = false;
        }
    }
    if ($_FILES['facility_form_request']['name']) {
        if (!move_uploaded_file($_FILES['facility_form_request']['tmp_name'], $uploads_dir . $facility_form_request)) {
            echo "Error uploading Facility Form Request.";
            $upload_success = false;
        }
    }
    if ($_FILES['contract_of_lease']['name']) {
        if (!move_uploaded_file($_FILES['contract_of_lease']['tmp_name'], $uploads_dir . $contract_of_lease)) {
            echo "Error uploading Contract of Lease.";
            $upload_success = false;
        }
    }

    // Proceed if all uploads were successful
    if ($upload_success) {
        // Get the office user's ID
        $office_id = $user['office_id']; // Change admin_id to office_id

        // Prepare the event update query
        $event_update_query = "UPDATE office_events 
                               SET letter_of_request = ?, facility_form_request = ?, contract_of_lease = ?
                               WHERE user_id = ?";
        $stmt = $conn->prepare($event_update_query);
        $stmt->bind_param('ssii', 
            $letter_of_request, 
            $facility_form_request, 
            $contract_of_lease, 
            $office_id // Change admin_id to office_id
        );

        // Execute the update and check for errors
        if ($stmt->execute()) {
            echo "Profile updated successfully!";
            header("Location: Acc_Credentials.php");
            exit();
        } else {
            echo "Failed to update profile. Error: " . $stmt->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URSMFEMSS Homepage</title>
    <!--BOOTSTRAP LINK-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>

        @font-face { 
        font-family: "Hussar Bold Web Edition";
        src: url("https://db.onlinewebfonts.com/t/60020c76d48f22e20a23b37c056cb339.eot");
        src: url("https://db.onlinewebfonts.com/t/60020c76d48f22e20a23b37c056cb339.eot?#iefix")format("embedded-opentype"),
        url("https://db.onlinewebfonts.com/t/60020c76d48f22e20a23b37c056cb339.woff2")format("woff2"),
        url("https://db.onlinewebfonts.com/t/60020c76d48f22e20a23b37c056cb339.woff")format("woff"),
        url("https://db.onlinewebfonts.com/t/60020c76d48f22e20a23b37c056cb339.ttf")format("truetype"),
        url("https://db.onlinewebfonts.com/t/60020c76d48f22e20a23b37c056cb339.svg#Hussar Bold Web Edition")format("svg");
        }

        .navbar-brand {
            font-family: Hussar Bold Web Edition;
        }  

        #mainNavbar {
            height: auto;
        }
            
        #mainNavbar .navbar-brand {
            font-size: 1em;
        } 

        .bg-primary-custom {
            background-color: #004AAD !important;
        }

        .navbar-nav .nav-item .nav-link {
            background-color: white;
            font-size: 12px;
        }
        
        #mainNavbar .navbar-nav .nav-item .nav-link {
            color:#004AAD;
            padding:2px;
            padding-left:5px;
            width: 180px;
            height: 25px;
        }

        #mainNavbar .navbar-nav .nav-item .nav-link img {
            width: 20px; height: 20px;
        }

        #mainNavbar .dropdown-menu .dropdown-item {
            font-size: 13px; color: #004AAD; padding: 0px; margin-right:5px;
        }
        
        .dropdown-item {
            font-size: 12px;
        }

        /*dropdown images sizing*/
        #mainNavbar .dropdown-menu .dropdown-item img {
            width: 20px; height: 20px; margin:5px;
        }

        .navbar-nav .nav-item {
            margin-right: 15px; 
        }

        @media only screen and (max-width: 960px) {
        #mainNavbar .navbar-brand {
            font-size: 1em;
            font-weight: bold;
        } 

        .navbar-nav .nav-item .nav-link {
            background-color: white;
            font-size: 12px;
        }
        
        .dropdown-item {
            font-size: 10px;
        }

        .navbar-nav .nav-item {
            margin-right: 5px; 
        }
        }

        
        .legend-section {
            margin-top: 20px;
        }

        .legend-title {
            font-family: 'Arial', sans-serif;
            font-weight: bold;
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }

        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }

        .status-approve {
            background-color: green;
        }

        .status-pending {
            background-color: blue;
        }

        .status-reject {
            background-color: red;
        }

        .status-onhold {
            background-color: orange;
        }

        .upcoming-events-section {
            background-color: #004AAD;
            color: white;
            padding: 15px;
        }

        .event-list {
            height: 300px;
            overflow-y: auto;
            background-color: white;
            color: white;
            padding: 15px;
            margin-top: 10px;
        }

        .table {
            margin-top: 15px;
            background-color: white;
        }

        /* Dropdown container styling */
        .mb-3 {
            margin-bottom: 1.5rem;
            /* Adjust spacing as needed */
        }

        /* Label styling */
        .form-label {
            font-family: 'Microsoft Sans Serif', sans-serif;
            /* Font family */
            font-size: 16px;
            /* Font size */
            font-weight: 600;
            /* Font weight */
            color: #333;
            /* Label color */
            margin-bottom: 0.5rem;
            /* Space between label and dropdown */
        }

        /* Dropdown select styling */
        .form-select {
            display: block;
            /* Ensures the select takes full width */
            width: 100%;
            /* Full width */
            padding: 0.375rem 0.75rem;
            /* Padding inside the dropdown */
            font-size: 14px;
            /* Font size */
            line-height: 1.5;
            /* Line height */
            color: #495057;
            /* Text color */
            background-color: #fff;
            /* Background color */
            background-clip: padding-box;
            /* Background clip */
            border: 1px solid #ced4da;
            /* Border color */
            border-radius: 0.375rem;
            /* Border radius */
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            /* Transition effects */
        }

        /* Dropdown focus styling */
        .form-select:focus {
            border-color: #80bdff;
            /* Border color on focus */
            outline: 0;
            /* Remove default outline */
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            /* Box shadow on focus */
        }

        /* Option styling */
        .form-select option {
            color: #495057;
            /* Option text color */
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .form-label {
                font-size: 14px;
                /* Smaller font on mobile */
            }

            .form-select {
                font-size: 12px;
                /* Smaller font on mobile */
            }
        }
        .container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 8px;
    box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
}

h1 {
    font-size: 28px;
    margin-bottom: 20px;
    text-align: center;
    color: #004AAD;
}

.form-group {
    margin-bottom: 15px;
}

label {
    font-weight: 600;
    font-size: 16px;
    color: #004AAD;
}

input.form-control,
select.form-control {
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ced4da;
    border-radius: 4px;
    box-shadow: none;
    transition: border-color 0.3s ease-in-out;
}

input.form-control:focus,
select.form-control:focus {
    border-color: #004AAD;
    outline: none;
    box-shadow: 0 0 5px rgba(0, 74, 173, 0.3);
}

button.btn-primary {
    width: 100%;
    padding: 10px;
    font-size: 18px;
    font-weight: bold;
    background-color: #004AAD;
    border: none;
    border-radius: 4px;
    transition: background-color 0.3s ease-in-out;
}

button.btn-primary:hover {
    background-color: #00348f;
}

@media (max-width: 768px) {
    .container {
        padding: 15px;
    }

    h1 {
        font-size: 24px;
    }

    input.form-control,
    select.form-control {
        font-size: 14px;
    }

    button.btn-primary {
        font-size: 16px;
    }
}

    </style>


</head>

<body class="d-flexbox vw-100 vh-100">

    <!--HEADER-->        
    <!-- First Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary-custom" id="mainNavbar">
        <a class="navbar-brand" href="index.php">University of Rizal System - Morong Facilities E-Monitoring and Scheduling System</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="true" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse navbar-expand" id="navbarSupportedContent">
            <ul class="ml-auto navbar-nav">
            <li id="vbr" class="nav-item">
                    <a class="nav-link rounded-pill" href="view_booking.php">
                        <img src="Header_Images/vbr.png" alt="Icon" />
                        View Booking Requests
                    </a>
                </li>

                <li id="acc" class="nav-item dropdown">
                    <a class="nav-link rounded-pill dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="Header_Images/account.png" alt="Icon" />
                        Account&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a id="admin1" class="dropdown-item" href="Acc_Credentials.php" id="profileLink">
                            <img src="Header_Images/account.png" alt="Icon" />
                            Profile</a>
                            
                            <a id="admin2" class="dropdown-item" href="Accounts.php">
                                <img src="Header_Images/switch_account.png" alt="Icon" />
                                Switch to Admin Account
                            </a>

                        <a id="signout" class="dropdown-item" href="../login.php">
                            <img src="Header_Images/sign_out.png" alt="Icon" />
                            Log out</a>
                    </div>

                </li>

            </ul>
        </div>
    </nav>
   
<div class="container">
    <h1>Upload Documents</h1>
    <form method="POST" action="Acc_Credentials.php" id="profileForm" enctype="multipart/form-data">
        <div class="form-group">
            <label for="letter_of_request">Letter of Request</label>
            <input type="file" class="form-control" id="letter_of_request" name="letter_of_request" >
        </div>

        <div class="form-group">
            <label for="facility_form_request">Facility Form Request</label>
            <input type="file" class="form-control" id="facility_form_request" name="facility_form_request" >
        </div>

        <div class="form-group">
            <label for="contract_of_lease">Contract of Lease</label>
            <input type="file" class="form-control" id="contract_of_lease" name="contract_of_lease" >
        </div>

        <button type="submit" class="btn btn-primary">Update Documents</button>
    </form>
</div>
    <!-- FullCalendar JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<script>
    $(document).ready(function() {
        // Show/hide fields based on account type selection
        $('#account_type').change(function() {
            var accountType = $(this).val();
            
            if (accountType == '1') {  // Admin
                $('#admin_fields').show();
                $('#student_leader_fields').hide();
                $('#org_fields').hide();
                $('#office_fields').hide();
                
                // Fetch admin accounts via AJAX
                $.ajax({
                    url: 'get_data.php',
                    type: 'POST',
                    data: { account_type: accountType },
                    success: function(response) {
                        $('#admin_account').html(response);
                    }
                });
                
            } else if (accountType == '2') {  // Student Leader
                $('#student_leader_fields').show();
                $('#admin_fields').hide();
                $('#org_fields').show();
                $('#office_fields').hide();
                
                // Fetch departments via AJAX
                $.ajax({
                    url: 'get_data.php',
                    type: 'POST',
                    data: { account_type: accountType },
                    success: function(response) {
                        $('#department').html(response);
                    }
                });
                
            } else if (accountType == '3') {  // Office
                $('#office_fields').show();
                $('#admin_fields').hide();
                $('#student_leader_fields').hide();
                $('#org_fields').hide();
                
                // Fetch offices via AJAX
                $.ajax({
                    url: 'get_data.php',
                    type: 'POST',
                    data: { account_type: accountType },
                    success: function(response) {
                        $('#office').html(response);
                    }
                });
            } else {
                // Hide all optional fields if no valid account type is selected
                $('#admin_fields').hide();
                $('#student_leader_fields').hide();
                $('#org_fields').hide();
                $('#office_fields').hide();
            }
        });

        // Fetch organizations based on selected department (for Student Leaders)
        $('#department').change(function() {
            var departmentId = $(this).val();
            $.ajax({
                url: 'get_data.php',
                type: 'POST',
                data: { department_id: departmentId },
                success: function(response) {
                    $('#organization').html(response);
                }
            });
        });
    });
</script>


</body>
</html>
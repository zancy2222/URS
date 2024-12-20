<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['account_type'] != 1) {
    header("Location: ../login.php");
    exit();
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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
            color: #004AAD;
            padding: 2px;
            padding-left: 5px;
            width: 180px;
            height: 25px;
        }

        #mainNavbar .navbar-nav .nav-item .nav-link img {
            width: 20px;
            height: 20px;
        }

        #mainNavbar .dropdown-menu .dropdown-item {
            font-size: 13px;
            color: #004AAD;
            padding: 0px;
            margin-right: 5px;
        }

        .dropdown-item {
            font-size: 12px;
        }

        /*dropdown images sizing*/
        #mainNavbar .dropdown-menu .dropdown-item img {
            width: 20px;
            height: 20px;
            margin: 5px;
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

        /* Style the table and make it responsive */
        .table td {
            vertical-align: middle;
        }

        .table td button {
            margin-bottom: 5px;
            /* Add spacing between buttons */
        }

        .table td .btn-sm {
            width: 100%;
            /* Ensure buttons take full width within their cell */
            min-width: 120px;
            /* Optional: Set a minimum width for buttons */
        }

        /* Make buttons stack vertically on smaller screens */
        @media (max-width: 768px) {
            .table td {
                display: flex;
                flex-wrap: wrap;
                /* Allow buttons to wrap */
                gap: 5px;
                /* Space between buttons */
            }

            .table td .btn-sm {
                width: auto;
                /* Reset to default for smaller screens */
                flex: 1;
                /* Flex-grow to use available space */
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
                <?php if (!isset($_SESSION['is_osds']) || !$_SESSION['is_osds']): ?>
                    <li id="vbr" class="nav-item">
                        <a class="nav-link rounded-pill" href="view_booking.php">
                            <img src="Header_Images/vbr.png" alt="Icon" />
                            View Booking Requests
                        </a>
                    </li>

                    <li id="pbr" class="nav-item">
                        <a class="nav-link rounded-pill" href="Process_booking.php">
                            <img src="Header_Images/pbr.png" alt="Icon" />
                            Process Booking Requests
                        </a>
                    </li>
                <?php endif; ?>

                <li id="acc" class="nav-item dropdown">
                    <a class="nav-link rounded-pill dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="Header_Images/account.png" alt="Icon" />
                        Account&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a id="admin1" class="dropdown-item" href="Acc_Credentials.php" id="profileLink">
                            <img src="Header_Images/account.png" alt="Icon" />
                            Profile</a>
                        <?php if (isset($_SESSION['is_osds']) && $_SESSION['is_osds']): ?>
                            <a id="admin2" class="dropdown-item" href="Accounts.php">
                                <img src="Header_Images/switch_account.png" alt="Icon" />
                                Switch to Admin Account
                            </a>
                        <?php endif; ?>

                        <a id="signout" class="dropdown-item" href="../logout.php">
                            <img src="Header_Images/sign_out.png" alt="Icon" />
                            Log out</a>
                    </div>

                </li>

            </ul>
        </div>
    </nav>
    <!-- <h1>Welcome to Admin Dashboard (View booking), <?php echo $_SESSION['username']; ?>!</h1> -->
    <div class="container mt-5">
        <h2 class="mb-4">Booking Events</h2>
        <?php
        // Ensure database connection
        include 'partials/db_conn.php';

        $statusFilter = $_GET['status'] ?? '';
        $facilityFilter = $_GET['facility'] ?? '';
        $startDateFilter = $_GET['start_date'] ?? '';
        $timestampFilter = $_GET['timestamp'] ?? '';
        ?>
        <form method="get" class="mb-4">
            <div class="row">
                <div class="col-md-3">
                    <label for="statusFilter">Status</label>
                    <select id="statusFilter" name="status" class="form-control">
                        <option value="">All</option>
                        <option value="Approve" <?php if ($statusFilter == 'Approve') echo 'selected'; ?>>Approve</option>
                        <option value="Pending" <?php if ($statusFilter == 'Pending') echo 'selected'; ?>>Pending</option>
                        <option value="Reject" <?php if ($statusFilter == 'Reject') echo 'selected'; ?>>Reject</option>
                        <option value="On Hold" <?php if ($statusFilter == 'On Hold') echo 'selected'; ?>>On Hold</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="facilityFilter">Facility</label>
                    <input type="text" id="facilityFilter" name="facility" class="form-control" value="<?php echo htmlspecialchars($facilityFilter); ?>">
                </div>

                <div class="col-md-3">
                    <label for="startDateFilter">Start Date</label>
                    <input type="date" id="startDateFilter" name="start_date" class="form-control" value="<?php echo htmlspecialchars($startDateFilter); ?>">
                </div>

                <div class="col-md-3">
                    <label for="timestampFilter">Timestamp</label>
                    <input type="date" id="timestampFilter" name="timestamp" class="form-control" value="<?php echo htmlspecialchars($timestampFilter); ?>">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>

        <!-- Table to display booking events -->
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Event Name</th>
                    <th>Account Name</th>
                    <th>Status</th>
                    <th>Timestamp</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Facility</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'partials/db_conn.php'; // Ensure connection to the database

                $query = "
                SELECT id, event_name, account_name, start_date, end_date, start_time, end_time, facility, status, 
                       event_description, letter_of_request, facility_form_request, contract_of_lease, created_at AS timestamp, 
                       'admin' AS event_type
                FROM admin_events
                WHERE 1=1";
            
            // Apply filters to admin events
            if (!empty($statusFilter)) {
                $query .= " AND status = '" . $conn->real_escape_string($statusFilter) . "'";
            }
            if (!empty($facilityFilter)) {
                $query .= " AND facility LIKE '%" . $conn->real_escape_string($facilityFilter) . "%'";
            }
            if (!empty($startDateFilter)) {
                $query .= " AND start_date = '" . $conn->real_escape_string($startDateFilter) . "'";
            }
            if (!empty($timestampFilter)) {
                $query .= " AND DATE(created_at) = '" . $conn->real_escape_string($timestampFilter) . "'";
            }
            
            // UNION with student_leader_events query and apply the same filters
            $query .= " UNION ALL
                SELECT id, event_name, org_name AS account_name, start_date, end_date, start_time, end_time, facility, status, 
                       event_description, letter_of_request, facility_form_request, contract_of_lease, created_at AS timestamp, 
                       'student_leader' AS event_type
                FROM student_leader_events
                WHERE 1=1";
            
            if (!empty($statusFilter)) {
                $query .= " AND status = '" . $conn->real_escape_string($statusFilter) . "'";
            }
            if (!empty($facilityFilter)) {
                $query .= " AND facility LIKE '%" . $conn->real_escape_string($facilityFilter) . "%'";
            }
            if (!empty($startDateFilter)) {
                $query .= " AND start_date = '" . $conn->real_escape_string($startDateFilter) . "'";
            }
            if (!empty($timestampFilter)) {
                $query .= " AND DATE(created_at) = '" . $conn->real_escape_string($timestampFilter) . "'";
            }
            
            // UNION with office_events query and apply the same filters
            $query .= " UNION ALL
                SELECT id, event_name, office_name AS account_name, start_date, end_date, start_time, end_time, facility, status, 
                       event_description, letter_of_request, facility_form_request, contract_of_lease, created_at AS timestamp, 
                       'office' AS event_type
                FROM office_events
                WHERE 1=1";
            
            if (!empty($statusFilter)) {
                $query .= " AND status = '" . $conn->real_escape_string($statusFilter) . "'";
            }
            if (!empty($facilityFilter)) {
                $query .= " AND facility LIKE '%" . $conn->real_escape_string($facilityFilter) . "%'";
            }
            if (!empty($startDateFilter)) {
                $query .= " AND start_date = '" . $conn->real_escape_string($startDateFilter) . "'";
            }
            if (!empty($timestampFilter)) {
                $query .= " AND DATE(created_at) = '" . $conn->real_escape_string($timestampFilter) . "'";
            }
            
            // Order by timestamp (newest first)
            $query .= " ORDER BY timestamp DESC";
            
            // Execute the query
            $result = $conn->query($query);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <tr>
                            <td><?php echo $row['event_name']; ?></td>
                            <td><?php echo $row['account_name']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td><?php echo $row['timestamp']; ?></td>
                            <td><?php echo $row['start_date']; ?></td>
                            <td><?php echo $row['end_date']; ?></td>
                            <td><?php echo $row['facility']; ?></td>
                            <td>
                                <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#viewModal<?php echo $row['id']; ?>">View</button>
                                <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#reviewModal<?php echo $row['id']; ?>">Review Form</button>
                            </td>
                        </tr>

                        <!-- View Modal -->
                        <!-- View Modal -->
                        <div class="modal fade" id="viewModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="viewModalLabel">View Event</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Event Name:</strong> <?php echo $row['event_name']; ?></p>
                                        <p><strong>Start Date:</strong> <?php echo $row['start_date']; ?></p>
                                        <p><strong>End Date:</strong> <?php echo $row['end_date']; ?></p>
                                        <p><strong>Start Time:</strong> <?php echo $row['start_time']; ?></p>
                                        <p><strong>End Time:</strong> <?php echo $row['end_time']; ?></p>
                                        <p><strong>Facility:</strong> <?php echo $row['facility']; ?></p>
                                        <p><strong>Status:</strong> <?php echo $row['status']; ?></p>
                                        <p><strong>Description:</strong> <?php echo !empty($row['event_description']) ? $row['event_description'] : 'N/A'; ?></p>
                                        <p><strong>Letter of Request:</strong>
                                            <?php if (!empty($row['letter_of_request'])): ?>
                                                <a href="../partials/uploads/<?php echo $row['letter_of_request']; ?>" target="_blank">Download</a>
                                            <?php else: ?>
                                                N/A
                                            <?php endif; ?>
                                        </p>
                                        <p><strong>Facility Form Request:</strong>
                                            <?php if (!empty($row['facility_form_request'])): ?>
                                                <a href="../partials/uploads/<?php echo $row['facility_form_request']; ?>" target="_blank">Download</a>
                                            <?php else: ?>
                                                N/A
                                            <?php endif; ?>
                                        </p>
                                        <p><strong>Contract of Lease:</strong>
                                            <?php if (!empty($row['contract_of_lease'])): ?>
                                                <a href="../partials/uploads/<?php echo $row['contract_of_lease']; ?>" target="_blank">Download</a>
                                            <?php else: ?>
                                                N/A
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <!-- <button type="button" class="btn btn-light" title="View Reviews" data-toggle="modal" data-target="#reviewModal<?php echo $row['id']; ?>">
                                            <i class="fas fa-eye"></i> Reviews
                                        </button>
                                        <button type="button" class="btn btn-light" title="Edit Event" data-toggle="modal" data-target="#editModal<?php echo $row['id']; ?>">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button> -->
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Review Form Modal -->
                        <div class="modal fade" id="reviewModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviewModalLabel">Review Form for <?php echo $row['event_name']; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="partials/submit_review.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="event_id" value="<?php echo $row['id']; ?>">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['admin_account_id']; ?>"> <!-- Assuming you store user ID in session -->

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" name="status" required>
                            <option value="Approve" <?php if ($row['status'] == 'Approve') echo 'selected'; ?>>Approve</option>
                            <option value="Pending" <?php if ($row['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                            <option value="Reject" <?php if ($row['status'] == 'Reject') echo 'selected'; ?>>Reject</option>
                            <option value="On Hold" <?php if ($row['status'] == 'On Hold') echo 'selected'; ?>>On Hold</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="event_name">Event Name</label>
                        <input type="text" class="form-control" name="event_name" value="<?php echo $row['event_name']; ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="options">Options</label>
                        <div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="options[]" value="Change Data" id="option1">
                                <label class="form-check-label" for="option1">Change Data</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="options[]" value="Change Time" id="option2">
                                <label class="form-check-label" for="option2">Change Time</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="options[]" value="Resubmit Proposal" id="option3">
                                <label class="form-check-label" for="option3">Resubmit Proposal</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="options[]" value="Resubmit Student Activity Form" id="option4">
                                <label class="form-check-label" for="option4">Resubmit Student Activity Form</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="options[]" value="Resubmit Facility Request Form" id="option5">
                                <label class="form-check-label" for="option5">Resubmit Facility Request Form</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="comments">Other Comments</label>
                        <textarea class="form-control" name="comments" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit Review</button>
                </div>
            </form>
        </div>
    </div>
</div>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel">Edit Event</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="partials/edit_event.php" method="POST" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <input type="hidden" name="event_id" value="<?php echo $row['id']; ?>">
                                            <div class="form-group">
                                                <label for="eventName<?php echo $row['id']; ?>">Event Name</label>
                                                <input type="text" id="eventName<?php echo $row['id']; ?>" name="event_name" class="form-control" value="<?php echo $row['event_name']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="startDate<?php echo $row['id']; ?>">Start Date</label>
                                                <input type="date" id="startDate<?php echo $row['id']; ?>" name="start_date" class="form-control" value="<?php echo $row['start_date']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="endDate<?php echo $row['id']; ?>">End Date</label>
                                                <input type="date" id="endDate<?php echo $row['id']; ?>" name="end_date" class="form-control" value="<?php echo $row['end_date']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="startTime<?php echo $row['id']; ?>">Start Time</label>
                                                <input type="time" id="startTime<?php echo $row['id']; ?>" name="start_time" class="form-control" value="<?php echo $row['start_time']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="endTime<?php echo $row['id']; ?>">End Time</label>
                                                <input type="time" id="endTime<?php echo $row['id']; ?>" name="end_time" class="form-control" value="<?php echo $row['end_time']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="facility<?php echo $row['id']; ?>">Facility</label>
                                                <input type="text" id="facility<?php echo $row['id']; ?>" name="facility" class="form-control" value="<?php echo $row['facility']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="eventDescription<?php echo $row['id']; ?>">Event Description</label>
                                                <textarea id="eventDescription<?php echo $row['id']; ?>" name="event_description" class="form-control"><?php echo $row['event_description']; ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="letterOfRequest<?php echo $row['id']; ?>">Letter of Request (if applicable)</label>
                                                <input type="file" id="letterOfRequest<?php echo $row['id']; ?>" name="letter_of_request" class="form-control">
                                                <small class="form-text text-muted">Current File: <?php echo !empty($row['letter_of_request']) ? $row['letter_of_request'] : 'None'; ?></small>
                                            </div>
                                            <div class="form-group">
                                                <label for="facilityFormRequest<?php echo $row['id']; ?>">Facility Form Request (if applicable)</label>
                                                <input type="file" id="facilityFormRequest<?php echo $row['id']; ?>" name="facility_form_request" class="form-control">
                                                <small class="form-text text-muted">Current File: <?php echo !empty($row['facility_form_request']) ? $row['facility_form_request'] : 'None'; ?></small>
                                            </div>
                                            <div class="form-group">
                                                <label for="contractOfLease<?php echo $row['id']; ?>">Contract of Lease (if applicable)</label>
                                                <input type="file" id="contractOfLease<?php echo $row['id']; ?>" name="contract_of_lease" class="form-control">
                                                <small class="form-text text-muted">Current File: <?php echo !empty($row['contract_of_lease']) ? $row['contract_of_lease'] : 'None'; ?></small>
                                            </div>
                                            <div class="form-group">
                                                <label for="status<?php echo $row['id']; ?>">Status</label>
                                                <input type="text" id="status<?php echo $row['id']; ?>" name="status" class="form-control" value="<?php echo $row['status']; ?>" disabled>
                                                <small class="form-text text-muted">Status cannot be changed.</small>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Delete Event</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete the event "<?php echo $row['event_name']; ?>"?
                                    </div>
                                    <div class="modal-footer">
                                        <form action="partials/delete_event.php" method="POST">
                                            <input type="hidden" name="event_id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                <?php
                    }
                } else {
                    echo "<tr><td colspan='8' class='text-center'>No events found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>


    <!-- FullCalendar JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>




</body>

</html>
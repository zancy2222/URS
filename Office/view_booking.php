<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['account_type'] != 3) {
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

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Event Name</th>
                    <th>Organization Name</th>
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

                // Query only student_leader_events
                $query = "SELECT id, event_name, office_name, start_date, end_date, start_time, end_time, facility, status, 
                  event_description, letter_of_request, facility_form_request, contract_of_lease, created_at AS timestamp 
                  FROM office_events
                  WHERE 1=1";

                // Apply filters (if necessary)
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

                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['event_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['office_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td><?php echo htmlspecialchars($row['timestamp']); ?></td>
                            <td><?php echo htmlspecialchars($row['start_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['end_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['facility']); ?></td>
                            <td>
                                <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#viewModal<?php echo $row['id']; ?>">View</button>
                            </td>
                        </tr>

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
                                        <button type="button" class="btn btn-light" title="View Reviews" data-toggle="modal" data-target="#reviewModal<?php echo $row['id']; ?>">
                                            <i class="fas fa-eye"></i> Reviews
                                        </button>
                                        <button type="button" class="btn btn-light" title="Edit Event" data-toggle="modal" data-target="#editModal<?php echo $row['id']; ?>">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Review Modal -->
                        <div class="modal fade" id="reviewModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="reviewModalLabel">Event Reviews for <?php echo htmlspecialchars($row['event_name']); ?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <?php
                                        // Fetch reviews for this event
                                        $eventId = $row['id'];
                                        $reviewQuery = "SELECT comments, options FROM event_reviews WHERE event_id = ?";
                                        $stmt = $conn->prepare($reviewQuery);
                                        $stmt->bind_param('i', $eventId);
                                        $stmt->execute();
                                        $resultReviews = $stmt->get_result();

                                        if ($resultReviews->num_rows > 0) {
                                            while ($review = $resultReviews->fetch_assoc()) {
                                                echo '<div class="review-item">';
                                                echo '<p><strong>Comments:</strong> ' . htmlspecialchars($review['comments']) . '</p>';
                                                echo '<p><strong>Options:</strong> ' . htmlspecialchars($review['options']) . '</p>';
                                                echo '</div>';
                                                echo '<hr>';
                                            }
                                        } else {
                                            echo '<p>No reviews available for this event.</p>';
                                        }

                                        $stmt->close();
                                        ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
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
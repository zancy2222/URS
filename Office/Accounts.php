<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['account_type'] != 3) {
    header("Location: login.php");
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

        .nav-tabs .nav-link {
            color: #004AAD;
            font-weight: bold;
            padding: 10px 20px;
        }

        .nav-tabs .nav-link.active {
            background-color: #004AAD;
            color: white;
        }

        /* Styling for account holders and facilities info cards */
        .info-card {
            border: 1px solid #004AAD;
            border-radius: 4px;
            margin-top: 15px;
        }

        .info-card-header {
            background-color: #004AAD;
            color: white;
            font-weight: bold;
            padding: 10px;
            font-size: 16px;
            border-top-left-radius: 4px;
            border-top-right-radius: 4px;
        }

        .info-card-body {
            padding: 10px;
            font-size: 14px;
            font-family: Arial, sans-serif;
        }

        /* Styling for the Add button */
        .add-button {
            background-color: #004AAD;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
        }

        .add-button i {
            margin-right: 5px;
        }

        /* Icon buttons */
        .icon-buttons {
            display: inline-flex;
            gap: 5px;
        }

        .icon-buttons .btn {
            border-radius: 50%;
            padding: 2px 5px;
            font-size: 14px;
            color: white;
        }

        .icon-buttons .btn-success {
            background-color: #28a745;
        }

        .icon-buttons .btn-danger {
            background-color: #dc3545;
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

                        <a id="signout" class="dropdown-item" href="../login.php">
                            <img src="Header_Images/sign_out.png" alt="Icon" />
                            Log out</a>
                    </div>

                </li>

            </ul>
        </div>
    </nav>
    <div class="container mt-5">
        <!-- Tabs for Accounts and Facilities -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link" id="accounts-tab" href="#accounts" role="tab" aria-controls="accounts" aria-selected="true">ACCOUNTS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" id="facilities-tab" data-toggle="tab" href="#facilities" role="tab" aria-controls="facilities" aria-selected="false">FACILITIES</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <!-- Facilities Tab Content -->
            <?php
            include 'partials/db_conn.php';

            // Fetch all facilities
            $sql = "SELECT * FROM facilities";
            $result = $conn->query($sql);
            ?>

            <div class="tab-pane fade show active" id="facilities" role="tabpanel" aria-labelledby="facilities-tab">
                <div class="info-card">
                    <div class="info-card-header">FACILITIES INFORMATION</div>
                    <div class="info-card-body">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>NAME</th>
                                    <th>ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                                        <td class="icon-buttons">
                                            <button class="btn btn-primary edit-btn" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['name']; ?>" data-toggle="modal" data-target="#editFacilityModal"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-danger delete-btn" data-id="<?php echo $row['id']; ?>" data-toggle="modal" data-target="#deleteFacilityModal"><i class="fas fa-trash-alt"></i></button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                        <button class="add-button" data-toggle="modal" data-target="#addFacilityModal"><i class="fas fa-plus"></i> Add Facility</button>
                    </div>
                </div>
            </div>


            <!-- Edit Facility Modal -->
            <div class="modal fade" id="editFacilityModal" tabindex="-1" aria-labelledby="editFacilityModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editFacilityModalLabel">Edit Facility</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="editFacilityForm">
                                <div class="form-group">
                                    <label for="editFacilityName">Facility Name</label>
                                    <input type="text" class="form-control" id="editFacilityName" name="name" required>
                                    <input type="hidden" id="editFacilityId" name="id">
                                </div>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Add Facility Modal -->
            <div class="modal fade" id="addFacilityModal" tabindex="-1" aria-labelledby="addFacilityModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addFacilityModalLabel">Add Facility</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="addFacilityForm">
                                <div class="form-group">
                                    <label for="addFacilityName">Facility Name</label>
                                    <input type="text" class="form-control" id="addFacilityName" name="name" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Facility</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Delete Facility Modal -->
            <div class="modal fade" id="deleteFacilityModal" tabindex="-1" aria-labelledby="deleteFacilityModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteFacilityModalLabel">Confirm Delete</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete this facility?</p>
                            <input type="hidden" id="deleteFacilityId" value="">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Success Modal -->
            <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="successModalLabel">Success</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Your facility has been successfully added.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admin Access Modal -->
            <div class="modal fade" id="adminAccessModal" tabindex="-1" aria-labelledby="adminAccessModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="adminAccessModalLabel">Access Restricted</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Only Admin OSDS can access this section. Please log in as an Admin to proceed.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FullCalendar JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Simulated admin check - replace this with your actual admin checking logic
        const isAdmin = false; // Change to true if the user is an admin

        document.getElementById('accounts-tab').addEventListener('click', function(event) {
            if (!isAdmin) {
                event.preventDefault(); // Prevent tab from changing
                $('#adminAccessModal').modal('show'); // Show admin access modal
            }
        });
    </script>
    <script>
        // Edit Facility Modal
        $(document).on("click", ".edit-btn", function() {
            var facilityId = $(this).data("id");
            var facilityName = $(this).data("name");
            $("#editFacilityId").val(facilityId);
            $("#editFacilityName").val(facilityName);
        });

        // Add Facility Form Submission
        $("#addFacilityForm").on("submit", function(event) {
            event.preventDefault();
            var facilityName = $("#addFacilityName").val();

            $.ajax({
                url: 'partials/add_facility.php',
                method: 'POST',
                data: {
                    name: facilityName
                },
                dataType: 'json', // Expect a JSON response
                success: function(response) {
                    if (response.success) {
                        $('#successModal .modal-body').text(response.message); // Set the success message
                        $('#successModal').modal('show'); // Show the success modal
                        setTimeout(function() {
                            location.reload(); // Reload to show updated list after modal is closed
                        }, 2000); // Optional: reload after 2 seconds
                    } else {
                        alert(response.message); // Handle error message
                    }
                },
                error: function() {
                    alert("Error adding facility.");
                }
            });
        });

        // Delete Facility Confirmation
        $(document).on("click", ".delete-btn", function() {
            var facilityId = $(this).data("id");
            $("#deleteFacilityId").val(facilityId);
        });

        // Confirm Delete
        $("#confirmDelete").on("click", function() {
            var facilityId = $("#deleteFacilityId").val();

            $.ajax({
                url: 'partials/delete_facility.php',
                method: 'POST',
                data: {
                    id: facilityId
                },
                success: function(response) {
                    location.reload(); // Reload to show updated list
                },
                error: function() {
                    alert("Error deleting facility.");
                }
            });
        });

        // Edit Facility Form Submission
        $("#editFacilityForm").on("submit", function(event) {
            event.preventDefault();
            var facilityId = $("#editFacilityId").val();
            var facilityName = $("#editFacilityName").val();

            $.ajax({
                url: 'partials/edit_facility.php',
                method: 'POST',
                data: {
                    id: facilityId,
                    name: facilityName
                },
                success: function(response) {
                    location.reload(); // Reload to show updated list
                },
                error: function() {
                    alert("Error updating facility.");
                }
            });
        });
    </script>

</body>

</html>
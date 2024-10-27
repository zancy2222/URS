<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['account_type'] != 1) {
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

                        <a id="signout" class="dropdown-item" href="../logout.php">
                            <img src="Header_Images/sign_out.png" alt="Icon" />
                            Log out</a>
                    </div>

                </li>

            </ul>
        </div>
    </nav>
    <div class="container mt-5">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="accounts-tab" data-toggle="tab" href="#accounts" role="tab" aria-controls="accounts" aria-selected="true">ACCOUNTS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="facilities-tab"  href="#facilities" role="tab" aria-controls="facilities" aria-selected="false">FACILITIES</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <!-- Accounts Tab Content -->
            <!-- Accounts tab with Account Holders Table -->
            <div class="tab-pane fade show active" id="accounts" role="tabpanel" aria-labelledby="accounts-tab">
                <div class="info-card">
                    <div class="info-card-header">ACCOUNT HOLDERS:</div>
                    <div class="info-card-body">
                        <?php
                        include 'partials/db_conn.php';

                        // Fetch all account details without password
                        $sql = "
    SELECT u.id, u.username, at.account_type, 
           COALESCE(a.account_name, cd.department_name, o.office_name) AS account_name,
           CASE
               WHEN a.account_name IS NOT NULL THEN 'Admin'
               WHEN cd.department_name IS NOT NULL THEN 'Student Leader'
               WHEN o.office_name IS NOT NULL THEN 'Office'
           END AS display_type
    FROM users u
    JOIN account_type at ON u.account_type_id = at.id
    LEFT JOIN admin_account a ON u.admin_account_id = a.id
    LEFT JOIN college_department cd ON u.department_id = cd.id
    LEFT JOIN office o ON u.office_id = o.id;
";
                        $result = $conn->query($sql);
                        ?>

                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Account Type</th>
                                    <th>Account Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                                        <td><?php echo htmlspecialchars($row['display_type']); ?></td>
                                        <td><?php echo htmlspecialchars($row['account_name']); ?></td>
                                        <td class="icon-buttons">
                                            <button class="btn btn-primary edit-btn" data-id="<?php echo $row['id']; ?>" data-username="<?php echo $row['username']; ?>" data-display-type="<?php echo $row['display_type']; ?>" data-toggle="modal" data-target="#editAccountModal"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-danger delete-btn" data-id="<?php echo $row['id']; ?>" data-toggle="modal" data-target="#deleteAccountModal"><i class="fas fa-trash-alt"></i></button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>

                        <?php
                        $conn->close();
                        ?>


                        <button class="add-button" data-toggle="modal" data-target="#addAccountModal"><i class="fas fa-plus"></i> Add Account Holders</button>
                    </div>
                </div>
            </div>

            <!-- Edit Account Modal -->
            <!-- Edit Account Modal -->
            <div class="modal fade" id="editAccountModal" tabindex="-1" aria-labelledby="editAccountModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editAccountModalLabel">Edit Account</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="editAccountForm" action="partials/update_account.php" method="POST">
                                <input type="hidden" name="user_id" id="editUserId">
                                <div class="form-group">
                                    <label for="editUsername">Username</label>
                                    <input type="text" class="form-control" id="editUsername" name="username" required>
                                </div>
                                <div class="form-group">
                                    <label for="editAccountType">Account Type</label>
                                    <input type="text" class="form-control" id="editAccountType" name="account_type" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="editPassword">Password</label>
                                    <input type="password" class="form-control" id="editPassword" name="password" placeholder="Leave blank to keep unchanged">
                                </div>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Account Modal -->
            <div class="modal fade" id="addAccountModal" tabindex="-1" aria-labelledby="addAccountModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addAccountModalLabel">Add Account Holder</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="registrationForm" action="register.php" method="POST">
                                <div class="form-group">
                                    <label for="username">Username:</label>
                                    <input type="text" name="username" class="form-control" required><br>
                                </div>
                                <div class="form-group">
                                    <label for="account_type">Account Type:</label>
                                    <select name="account_type" id="account_type" class="form-control" required>
                                        <option value="">Select Account Type</option>
                                        <option value="1">Admin</option>
                                        <option value="2">Student Leader</option>
                                        <option value="3">Office</option>
                                    </select><br>
                                </div>
                                <!-- Admin Account (if Admin) -->
                                <div id="admin_fields" style="display: none;">
                                    <label for="admin_account">Admin Account:</label>
                                    <select name="admin_account" id="admin_account" class="form-control">
                                        <!-- Admin accounts will be populated via AJAX -->
                                    </select><br>
                                </div>
                                <!-- College and Org (if Student Leader) -->
                                <div id="student_leader_fields" style="display: none;">
                                    <label for="department">College Department:</label>
                                    <select name="department" id="department" class="form-control">
                                        <!-- Departments will be populated via AJAX -->
                                    </select><br>

                                    <label for="org">Organization:</label>
                                    <select name="org" id="org" class="form-control">
                                        <!-- Organizations will be populated based on the department selection via AJAX -->
                                    </select><br>
                                </div>
                                <!-- Office (if Office) -->
                                <div id="office_fields" style="display: none;">
                                    <label for="office">Office:</label>
                                    <select name="office" id="office" class="form-control">
                                        <!-- Offices will be populated via AJAX -->
                                    </select><br>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password:</label>
                                    <input type="password" name="password" class="form-control" required><br>
                                </div>
                                <button type="submit" class="btn btn-primary">Register</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="deleteAccountModal" tabindex="-1" role="dialog" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="partials/delete_account.php" method="POST">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteAccountModalLabel">Confirm Delete</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete this account?</p>
                                <!-- Hidden field to store the account ID -->
                                <input type="hidden" name="id" id="deleteAccountId" value="">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Success Modal -->
            <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="successModalLabel">Registration Successful</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Your account has been successfully registered.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Error Modal -->
            <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="errorModalLabel">Registration Error</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <?php echo $_SESSION['registration_error']; ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

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
                            <p>Only Office (GSO) can access this section.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
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

        document.getElementById('facilities-tab').addEventListener('click', function(event) {
            if (!isAdmin) {
                event.preventDefault(); // Prevent tab from changing
                $('#adminAccessModal').modal('show'); // Show admin access modal
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#account_type').change(function() {
                var accountType = $(this).val();
                if (accountType == '1') {
                    $('#admin_fields').show();
                    $('#student_leader_fields').hide();
                    $('#office_fields').hide();
                    // Fetch admin accounts via AJAX
                    $.ajax({
                        url: 'get_data.php',
                        type: 'POST',
                        data: {
                            account_type: accountType
                        },
                        success: function(response) {
                            $('#admin_account').html(response);
                        }
                    });
                } else if (accountType == '2') {
                    $('#student_leader_fields').show();
                    $('#admin_fields').hide();
                    $('#office_fields').hide();
                    // Fetch departments via AJAX
                    $.ajax({
                        url: 'get_data.php',
                        type: 'POST',
                        data: {
                            account_type: accountType
                        },
                        success: function(response) {
                            $('#department').html(response);
                        }
                    });
                } else if (accountType == '3') {
                    $('#office_fields').show();
                    $('#admin_fields').hide();
                    $('#student_leader_fields').hide();
                    // Fetch offices via AJAX
                    $.ajax({
                        url: 'get_data.php',
                        type: 'POST',
                        data: {
                            account_type: accountType
                        },
                        success: function(response) {
                            $('#office').html(response);
                        }
                    });
                } else {
                    $('#admin_fields').hide();
                    $('#student_leader_fields').hide();
                    $('#office_fields').hide();
                }
            });

            // Fetch organizations when department is selected
            $('#department').change(function() {
                var departmentId = $(this).val();
                $.ajax({
                    url: 'get_data.php',
                    type: 'POST',
                    data: {
                        department_id: departmentId
                    },
                    success: function(response) {
                        $('#org').html(response);
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Show success or error modals if session flags are set
            <?php if (isset($_SESSION['registration_success']) && $_SESSION['registration_success']): ?>
                $('#successModal').modal('show');
                <?php unset($_SESSION['registration_success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['registration_error'])): ?>
                $('#errorModal').modal('show');
                <?php unset($_SESSION['registration_error']); ?>
            <?php endif; ?>

            // Additional JavaScript for dynamic field display based on account type
            $('#account_type').change(function() {
                var accountType = $(this).val();
                $('#admin_fields, #student_leader_fields, #office_fields').hide();
                if (accountType == '1') {
                    $('#admin_fields').show();
                    // Load admin account options via AJAX
                } else if (accountType == '2') {
                    $('#student_leader_fields').show();
                    // Load college department options via AJAX
                } else if (accountType == '3') {
                    $('#office_fields').show();
                    // Load office options via AJAX
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.edit-btn').on('click', function() {
                var userId = $(this).data('id');
                var username = $(this).data('username');
                var displayType = $(this).data('display-type');

                $('#editUserId').val(userId);
                $('#editUsername').val(username);
                $('#editAccountType').val(displayType);
                $('#editPassword').val('');
            });
        });
    </script>
    <script>
        $(document).on("click", ".delete-btn", function() {
            var accountId = $(this).data("id");
            $("#deleteAccountId").val(accountId);
        });
    </script>

</body>

</html>
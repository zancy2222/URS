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

    </style>


</head>

<body class="d-flexbox vw-100 vh-100">

    <!--HEADER-->        
    <!-- First Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary-custom" id="mainNavbar">
        <a class="navbar-brand" href="#">University of Rizal System - Morong Facilities E-Monitoring and Scheduling System</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="true" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse navbar-expand" id="navbarSupportedContent">
        <ul class="ml-auto navbar-nav">
            <li id="vbr" class="nav-item">
                <a class="nav-link rounded-pill" href="View_Booking_Requests/view_booking_requests.php">
                    <img src="Header_Images/vbr.png" alt="Icon"/>
                    View Booking Requests
                    </a>
            </li>
    
            <li id="pbr" class="nav-item">
            <a class="nav-link rounded-pill" href="Process_Booking_Request/process_booking_request.php">
            <img src="Header_Images/pbr.png" alt="Icon"/>
            Process Booking Requests</a>
            </li>
            <li id="acc" class="nav-item dropdown">
            <a class="nav-link rounded-pill dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="Header_Images/account.png" alt="Icon"/>
                    Account&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown" >
                <a id="admin1" class="dropdown-item" href="Admin/Admin1.php" id="profileLink">
                <img src="Header_Images/account.png" alt="Icon"/>
                Profile</a>
                <a id="admin2" class="dropdown-item" href="Admin/Admin2.php">
                <img src="Header_Images/switch_account.png" alt="Icon"/>
                Switch to Admin Account</a>
                <a id="signout" class="dropdown-item" href="../login.php"> 
                <img src="Header_Images/sign_out.png" alt="Icon"/>
                Log out</a>
            </div>
            
            </li>
            
        </ul>
        </div>
    </nav>
    <h1>Welcome to Office Dashboard, <?php echo $_SESSION['username']; ?>!</h1>

    <div class="container mt-4">
        <!-- Grid for Calendar and Upcoming Events -->
        <div class="row">
            <!-- Calendar Section (Left Column) -->
            <div class="col-md-6">
                <!-- "Book an Event" Button -->
                <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#bookEventModal">Book an Event</button>



                <div id="calendar"></div>

                <!-- Legends Section -->
                <div class="legend-section">
                    <h5 class="legend-title">LEGENDS</h5>
                    <div class="legend-item"><span class="legend-color status-approve"></span>Approve</div>
                    <div class="legend-item"><span class="legend-color status-pending"></span>Pending</div>
                    <div class="legend-item"><span class="legend-color status-reject"></span>Reject</div>
                    <div class="legend-item"><span class="legend-color status-onhold"></span>On Hold</div>
                </div>
            </div>

            <!-- Upcoming Events Section (Right Column) -->
            <div class="col-md-6">

                <!-- Dropdown for Facilities -->
                <div class="mb-3">
                    <label for="facilityFilter" class="form-label">Filter by Facility</label>
                    <select id="facilityFilter" class="form-select">
                        <option value="all">All Facilities</option>
                        <option value="EARTS">EARTS</option>
                        <option value="FUNCTION HALL">FUNCTION HALL</option>
                        <option value="GYMNASIUM">GYMNASIUM</option>
                        <option value="QUADRANGLE">QUADRANGLE</option>
                        <option value="AVEC">AVEC</option>
                    </select>
                </div>
                <div class="upcoming-events-section">
                    <h4>UPCOMING EVENTS</h4>
                    <table class="table table-bordered table-striped mt-4">
    <thead>
        <tr>
            <th>Event Name</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody id="upcomingEventsBody">
        <!-- Events will be dynamically added here -->
    </tbody>
</table>

                </div>
            </div>
        </div>
    </div>

<!-- Book Event Modal -->
<div class="modal fade" id="bookEventModal" tabindex="-1" role="dialog" aria-labelledby="bookEventModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookEventModalLabel">Book an Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="bookingForm" enctype="multipart/form-data"> <!-- Add enctype for file uploads -->
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="form-group">
                        <label for="eventName">Event Name</label>
                        <input type="text" class="form-control" id="eventName" name="eventName" placeholder="Enter event name" required>
                    </div>
                    <div class="form-group">
                        <label for="startDate">Start Date</label>
                        <input type="date" class="form-control" id="startDate" name="startDate" required>
                    </div>
                    <div class="form-group">
                        <label for="endDate">End Date</label>
                        <input type="date" class="form-control" id="endDate" name="endDate">
                    </div>
                    <div class="form-group">
                        <label for="startTime">Start Time</label>
                        <input type="time" class="form-control" id="startTime" name="startTime" required>
                    </div>
                    <div class="form-group">
                        <label for="endTime">End Time</label>
                        <input type="time" class="form-control" id="endTime" name="endTime">
                    </div>
                    <div class="form-group">
                        <label for="facility">Facility</label>
                        <select class="form-control" id="facility" name="facility" required>
                            <option value="EARTS">EARTS</option>
                            <option value="FUNCTION HALL">FUNCTION HALL</option>
                            <option value="GYMNASIUM">GYMNASIUM</option>
                            <option value="QUADRANGLE">QUADRANGLE</option>
                            <option value="AVEC">AVEC</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="eventDescription">Description</label>
                        <textarea class="form-control" id="eventDescription" name="eventDescription" rows="3" placeholder="Enter event description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="letterOfRequest">Letter of Request (PDF)</label>
                        <input type="file" class="form-control" id="letterOfRequest" name="letterOfRequest" accept=".pdf">
                    </div>
                    <div class="form-group">
                        <label for="facilityFormRequest">Facility Form Request (PDF)</label>
                        <input type="file" class="form-control" id="facilityFormRequest" name="facilityFormRequest" accept=".pdf">
                    </div>
                    <div class="form-group">
                        <label for="contractOfLease">Contract of Lease (PDF)</label>
                        <input type="file" class="form-control" id="contractOfLease" name="contractOfLease" accept=".pdf">
                    </div>
                    <button type="submit" class="btn btn-primary">Book</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Event Details Modal -->
<div class="modal fade" id="eventDetailsModal" tabindex="-1" role="dialog" aria-labelledby="eventDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventDetailsModalLabel">Event Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Event Name:</strong> <span id="eventDetailName"></span></p>
                <p><strong>Start Date:</strong> <span id="eventDetailStartDate"></span></p>
                <p><strong>End Date:</strong> <span id="eventDetailEndDate"></span></p>
                <p><strong>Start Time:</strong> <span id="eventDetailStartTime"></span></p>
                <p><strong>End Time:</strong> <span id="eventDetailEndTime"></span></p>
                <p><strong>Facility:</strong> <span id="eventDetailFacility"></span></p>
                <p><strong>Description:</strong> <span id="eventDetailDescription"></span></p>
                <p><strong>Status:</strong> <span id="eventDetailStatus"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
$(document).ready(function() {
    $('#bookingForm').on('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        var formData = new FormData(this); // Create a FormData object from the form

        $.ajax({
            url: '../partials/book_event.php', // Replace with the path to your PHP file
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                var result = JSON.parse(response);
                if (result.status === 'success') {
                    alert(result.message); // Handle success
                    location.reload(); // Reload the page

                } else {
                    alert(result.message); // Handle error
                }
            },
            error: function() {
                alert('An error occurred. Please try again.'); // Handle AJAX error
            }
        });
    });
});

</script>
<script>
    // FullCalendar Initialization
// FullCalendar Initialization
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: [], // Start with an empty events array

        eventClick: function(info) {
            // Show the event details in the modal
            $('#eventDetailName').text(info.event.title);
            $('#eventDetailStartDate').text(info.event.start.toLocaleDateString());
            $('#eventDetailEndDate').text(info.event.end ? info.event.end.toLocaleDateString() : 'N/A');
            $('#eventDetailStartTime').text(info.event.start.toLocaleTimeString());
            $('#eventDetailEndTime').text(info.event.end ? info.event.end.toLocaleTimeString() : 'N/A');
            $('#eventDetailFacility').text(info.event.extendedProps.facility);
            $('#eventDetailDescription').text(info.event.extendedProps.description);
            $('#eventDetailStatus').text(info.event.extendedProps.status);

            // Open the modal
            $('#eventDetailsModal').modal('show');
        }
    });

    // Fetch events from the server
    fetch('../partials/fetch_events.php') // Create this file to fetch events
        .then(response => response.json())
        .then(events => {
            events.forEach(event => {
                // Calculate the correct end date
                const endDate = new Date(event.end_date);
                endDate.setDate(endDate.getDate() + 1); // Set end date to the next day

                calendar.addEvent({
                    title: event.event_name,
                    start: event.start_date,
                    end: endDate.toISOString().split('T')[0], // Convert back to YYYY-MM-DD
                    extendedProps: {
                        facility: event.facility,
                        description: event.event_description,
                        status: event.status
                    },
                    color: getColorBasedOnStatus(event.status) // Set the color based on status
                });
                $('#upcomingEventsBody').append(`
                    <tr>
                        <td><a href="#" class="event-link" data-event-name="${event.event_name}" data-start-date="${event.start_date}" data-end-date="${endDate.toISOString().split('T')[0]}" data-facility="${event.facility}" data-description="${event.event_description}" data-status="${event.status}">${event.event_name}</a></td>
                        <td>${event.start_date}</td>
                        <td>${endDate.toISOString().split('T')[0]}</td> <!-- Display end date -->
                        <td><span class="legend-color status-${event.status.toLowerCase()}"></span>${event.status}</td>
                    </tr>
                `);
            });
            calendar.render(); // Render the calendar after events are added
        });

    function getColorBasedOnStatus(status) {
        switch (status) {
            case 'Approve':
                return 'green'; // Approved
            case 'Pending':
                return 'blue'; // Pending
            case 'Reject':
                return 'red'; // Rejected
            case 'On Hold':
                return 'orange'; // On Hold
            default:
                return 'gray'; // Default color for any unknown status
        }
    }

    // Filtering functionality
    document.getElementById('facilityFilter').addEventListener('change', function() {
        const selectedFacility = this.value;

        // Re-fetch or filter events based on the selected facility
        calendar.getEvents().forEach(event => {
            if (selectedFacility === 'all' || event.extendedProps.facility === selectedFacility) {
                event.setProp('display', 'auto'); // Show the event
            } else {
                event.setProp('display', 'none'); // Hide the event
            }
        });
    });
});

</script>


</body>
</html>
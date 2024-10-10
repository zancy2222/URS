<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URSMFEMSS Homepage</title>
    <style>
        @font-face {
            font-family: "Hussar Bold Web Edition";
            src: url("https://db.onlinewebfonts.com/t/60020c76d48f22e20a23b37c056cb339.eot");
            src: url("https://db.onlinewebfonts.com/t/60020c76d48f22e20a23b37c056cb339.eot?#iefix") format("embedded-opentype"),
                url("https://db.onlinewebfonts.com/t/60020c76d48f22e20a23b37c056cb339.woff2") format("woff2"),
                url("https://db.onlinewebfonts.com/t/60020c76d48f22e20a23b37c056cb339.woff") format("woff"),
                url("https://db.onlinewebfonts.com/t/60020c76d48f22e20a23b37c056cb339.ttf") format("truetype"),
                url("https://db.onlinewebfonts.com/t/60020c76d48f22e20a23b37c056cb339.svg#Hussar Bold Web Edition") format("svg");
        }

        .hussar {
            font-family: Hussar Bold Web Edition;
        }

        .header {
            font-family: Hussar Bold Web Edition;
            color: #FFFFFF;
            background-color: #004AAD;
            text-align: center;
        }

        .btn-success {
            background-color: #00BF63;
            border: none;
        }

        .navbar-custom {
            background-color: #004AAD;
        }

        .navbar-brand {
            color: white;
            font-family: 'Hussar Bold Web Edition';
        }

        .navbar-brand:hover {
            color: #00BF63;
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

    <!-- FullCalendar CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

    <!-- HEADER -->
    <nav class="navbar navbar-expand-lg navbar-custom" id="mainNavbar">
        <a class="navbar-brand" href="#">University of Rizal System - Morong Facilities E-Monitoring and Scheduling System</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="true" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div>
            <button type="button" onclick="window.location.href='../Log_In/login.php?logout=true';" class="btn btn-success btn-sm">LOG IN</button>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Grid for Calendar and Upcoming Events -->
        <div class="row">
            <!-- Calendar Section (Left Column) -->
            <div class="col-md-6">
                <!-- "Book an Event" Button -->
                <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#bookEventModal">Book an Event</button>


                <!-- Calendar Container -->
                <div id="calendar"></div>


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
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Event Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="upcomingEventsBody">
                            <tr>
                                <td><a href="#" class="event-link" data-event-name="Event 1" data-start-date="2024-10-10" data-end-date="2024-10-12" data-start-time="09:00" data-end-time="17:00" data-facility="FUNCTION HALL" data-description="Description for Event 1" data-status="Pending">Event 1</a></td>
                                <td>2024-10-10</td>
                                <td>2024-10-12</td>
                                <td><span class="legend-color status-pending"></span>Pending</td>
                            </tr>
                            <tr>
                                <td><a href="#" class="event-link" data-event-name="Event 2" data-start-date="2024-10-15" data-end-date="2024-10-16" data-start-time="10:00" data-end-time="14:00" data-facility="GYMNASIUM" data-description="Description for Event 2" data-status="Approve">Event 2</a></td>
                                <td>2024-10-15</td>
                                <td>2024-10-16</td>
                                <td><span class="legend-color status-approve"></span>Approve</td>
                            </tr>
                            <!-- Add more events here -->
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
                    <form>
                        <div class="form-group">
                            <label for="eventName">Event Name</label>
                            <input type="text" class="form-control" id="eventName" placeholder="Enter event name">
                        </div>
                        <div class="form-group">
                            <label for="startDate">Start Date</label>
                            <input type="date" class="form-control" id="startDate">
                        </div>
                        <div class="form-group">
                            <label for="endDate">End Date</label>
                            <input type="date" class="form-control" id="endDate">
                        </div>
                        <div class="form-group">
                            <label for="startTime">Start Time</label>
                            <input type="time" class="form-control" id="startTime">
                        </div>
                        <div class="form-group">
                            <label for="endTime">End Time</label>
                            <input type="time" class="form-control" id="endTime">
                        </div>
                        <div class="form-group">
                            <label for="facility">Facility</label>
                            <select class="form-control" id="facility">
                                <option value="EARTS">EARTS</option>
                                <option value="FUNCTION HALL">FUNCTION HALL</option>
                                <option value="GYMNASIUM">GYMNASIUM</option>
                                <option value="QUADRANGLE">QUADRANGLE</option>
                                <option value="AVEC">AVEC</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="eventDescription">Description</label>
                            <textarea class="form-control" id="eventDescription" rows="3"></textarea>
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

    <!-- Bootstrap JavaScript and dependencies (jQuery, Popper.js) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // FullCalendar Initialization
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: [{
                        title: 'Event 1',
                        start: '2024-10-10',
                        end: '2024-10-12',
                        extendedProps: {
                            status: 'Approved',
                            facility: 'FUNCTION HALL',
                            description: 'Description for Event 1'
                        },
                        color: getColorBasedOnStatus('Approved')
                    },
                    {
                        title: 'Event 2',
                        start: '2024-10-15',
                        end: '2024-10-16',
                        extendedProps: {
                            status: 'Pending',
                            facility: 'GYMNASIUM',
                            description: 'Description for Event 2'
                        },
                        color: getColorBasedOnStatus('Pending')
                    }
                ],
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

            function getColorBasedOnStatus(status) {
                switch (status) {
                    case 'Approved':
                        return 'green';
                    case 'Pending':
                        return 'blue';
                    case 'Rejected':
                        return 'red';
                    case 'On Hold':
                        return 'orange';
                    default:
                        return 'gray';
                }
            }

            calendar.render();

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

            // Handle event link clicks to open the event details modal
            $('.event-link').on('click', function() {
                $('#eventDetailName').text($(this).data('event-name'));
                $('#eventDetailStartDate').text($(this).data('start-date'));
                $('#eventDetailEndDate').text($(this).data('end-date'));
                $('#eventDetailStartTime').text($(this).data('start-time'));
                $('#eventDetailEndTime').text($(this).data('end-time'));
                $('#eventDetailFacility').text($(this).data('facility'));
                $('#eventDetailDescription').text($(this).data('description'));
                $('#eventDetailStatus').text($(this).data('status'));

                $('#eventDetailsModal').modal('show');
            });
        });
    </script>

</body>

</html>
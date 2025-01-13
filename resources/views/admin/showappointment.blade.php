<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Kanna Dentist Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/jvectormap/jquery-jvectormap.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/owl-carousel-2/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/owl-carousel-2/owl.theme.default.min.css') }}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css2/style.css') }}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ asset('/assets/img/kanna_fav.png') }}" />
    <style>
        .status {
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
        }
        .status-pending {
            background-color: orange;
        }
        .status-accepted {
            background-color: green;
        }
        .status-canceled {
            background-color: red;
        }
        .action-button {
            transition: opacity 0.3s ease;
        }
        .action-button.disabled {
            opacity: 0.5;
            pointer-events: none;
        }

        .loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            text-align: center;
            padding-top: 20%;
        }

        .loading-spinner {
            display: inline-block;
            width: 50px;
            height: 50px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

         /* Added style for filter bar text color */
         #doctor-filter, #status-filter, #reset-filters-btn {
            color: black; /* Set text color to black */
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>
<body>
    <!-- Loading overlay -->
    <div id="loading-overlay" class="loading-overlay">
        <div class="loading-spinner"></div>
        <div>Loading...</div>
    </div>

    <div class="container-scroller">
        <!-- partial:partials/_sidebar.html -->
        @include('admin.sidebar')
        <!-- partial -->
        @include('admin.navbar')
        <!-- partial -->

        <div class="container-fluid page-body-wrapper">
            <div class="table-container">
                <select id="doctor-filter">
                    <option value="">Select Doctor</option>
                    <option value="Dr. Walter White">Dr. Walter White</option>
                    <option value="Dr. Sarah Jhonson">Dr. Sarah Jhonson</option>
                    <option value="Dr. William Anderson">Dr. William Anderson</option>
                    <option value="Dr. Amanda Jepson">Dr. Amanda Jepson</option>
                </select>
                <select id="status-filter">
                    <option value="">Filter by Status</option>
                    <option value="Pending">Pending</option>
                    <option value="Accepted">Accepted</option>
                    <option value="Canceled">Canceled</option>
                </select>
                <button id="reset-filters-btn" class="btn btn-secondary">Reset Filters</button>
                <table>
                    <thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Date</th>
                            <th>Name Doctor</th>
                            <th>Service</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                        <tbody>
                            @foreach($data as $appoint)
                            <tr id="appointment-{{ $appoint->id }}" data-doctor="{{ $appoint->doctor }}" data-status="{{ $appoint->status }}">
                                <td>{{$appoint->name}}</td>
                                <td>{{$appoint->email}}</td>
                                <td>{{$appoint->phone}}</td>
                                <td>{{$appoint->appointment_date}}</td>
                                <td>{{$appoint->doctor}}</td>
                                <td>{{$appoint->services}}</td>
                                <td>{{$appoint->message}}</td>
                                <td>
                                    <span id="status-{{$appoint->id}}" class="status {{ $appoint->status === 'Accepted' ? 'status-accepted' : ($appoint->status === 'Canceled' ? 'status-canceled' : 'status-pending') }}">
                                        {{$appoint->status}}
                                    </span>
                                </td>
                                <td>
                                    @if($appoint->status === 'pending')
                                        <button id="accept-btn-{{$appoint->id}}" class="btn btn-success action-button accept-btn" data-id="{{ $appoint->id }}">Accept</button>
                                        <button id="cancel-btn-{{$appoint->id}}" class="btn btn-danger action-button cancel-btn" data-id="{{ $appoint->id }}">Cancel</button>
                                    @else
                                        <button class="btn btn-success action-button disabled">Accept</button>
                                        <button class="btn btn-danger action-button disabled">Cancel</button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ asset('admin/assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ asset('admin/assets/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendors/progressbar.js/progressbar.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendors/jvectormap/jquery-jvectormap.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('admin/assets/vendors/owl-carousel-2/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery.cookie.js') }}" type="text/javascript"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('admin/assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('admin/assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('admin/assets/js/misc.js') }}"></script>
    <script src="{{ asset('admin/assets/js/settings.js') }}"></script>
    <script src="{{ asset('admin/assets/js/todolist.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script>
    function updateStatus(id, action) {
        const statusElement = document.getElementById(`status-${id}`);
        const acceptButton = document.getElementById(`accept-btn-${id}`);
        const cancelButton = document.getElementById(`cancel-btn-${id}`);
        const loadingOverlay = document.getElementById('loading-overlay');
        const url = action === 'accept' ? `/appointment/accept/${id}` : `/appointment/cancel/${id}`;

        // Show loading overlay and disable buttons
        loadingOverlay.style.display = 'block';
        acceptButton.disabled = true;
        cancelButton.disabled = true;

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (action === 'accept') {
                    statusElement.textContent = 'Accepted';
                    statusElement.className = 'status status-accepted';
                } else if (action === 'cancel') {
                    statusElement.textContent = 'Canceled';
                    statusElement.className = 'status status-canceled';
                }

                // Disable action buttons after status update
                acceptButton.disabled = true;
                cancelButton.disabled = true;
            } else {
                console.error('Error:', data);
                alert('Failed to update status. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while processing your request.');
        })
        .finally(() => {
            // Hide loading overlay
            loadingOverlay.style.display = 'none';
        });
    }

    function filterAppointments() {
    const doctorFilter = document.getElementById('doctor-filter').value;
    const statusFilter = document.getElementById('status-filter').value.toLowerCase(); // Ubah filter ke huruf kecil

    document.querySelectorAll('tbody tr').forEach(function(row) {
        const doctor = row.getAttribute('data-doctor');
        const status = row.getAttribute('data-status').toLowerCase(); // Ubah status data ke huruf kecil

        const doctorMatch = !doctorFilter || doctor === doctorFilter;
        const statusMatch = !statusFilter || status === statusFilter;

        if (doctorMatch && statusMatch) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}


    function resetFilters() {
        document.getElementById('doctor-filter').value = '';
        document.getElementById('status-filter').value = '';
        filterAppointments();
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.accept-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                const appointmentId = this.getAttribute('data-id');
                updateStatus(appointmentId, 'accept');
            });
        });

        document.querySelectorAll('.cancel-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                const appointmentId = this.getAttribute('data-id');
                updateStatus(appointmentId, 'cancel');
            });
        });

        document.getElementById('doctor-filter').addEventListener('change', filterAppointments);
        document.getElementById('status-filter').addEventListener('change', filterAppointments);
        document.getElementById('reset-filters-btn').addEventListener('click', resetFilters);
    });
</script>

    <!-- End custom js for this page -->
</body>
</html>

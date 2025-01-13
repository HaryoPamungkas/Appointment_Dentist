<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Kanna Dentist Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="admin/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="admin/assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="admin/assets/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="admin/assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="admin/assets/vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="admin/assets/vendors/owl-carousel-2/owl.theme.default.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="admin/assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/img/kanna_fav.png" />
    <!-- Add these links in the <head> section of your HTML -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
    <style>
        /* Custom CSS for table */
        .table-container {
            margin: 20px auto;
            max-width: 800px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ebedf2;
        }

        .table th {
            background-color: #f5f6f8;
            font-weight: 600;
            color: #6b6e80;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .table-container {
            margin: 20px auto;
            max-width: 800px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        /* Styles for respond button */
        .respond-btn {
            background-color: grey;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .respond-btn:hover {
            background-color: green ;
        }

        /* Styles for Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 8px;
            color: #000;
        }

        .modal-header, .modal-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-footer {
            margin-top: 20px;
        }

        .modal-header h2 {
            margin: 0;
        }

        .modal-body {
            margin: 20px 0;
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

        /* Success Modal */
        .success-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            text-align: center;
            padding-top: 20%;
        }

        .success-content {
            background-color: green;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 8px;
            color: #fff;
        }

        .success-content p {
            margin: 0;
        }

        .responded-btn {
    background-color: #ccc;
    color: #666;
    padding: 5px 10px;
    border: none;
    border-radius: 4px;
    cursor: not-allowed;
}

    </style>
</head>
<body>
    <!-- Loading overlay -->
    <div id="loading-overlay" class="loading-overlay">
        <div class="loading-spinner"></div>
        <div>Loading...</div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="success-modal">
        <div class="success-content">
            <p>Response sent successfully!</p>
            <button id="closeSuccessBtn">Close</button>
        </div>
    </div>

    <div class="container-scroller">
        <!-- partial:partials/_sidebar.html -->
        @include('admin.sidebar')
        <!-- partial -->

        @include('admin.navbar') 

        <!-- dashboard -->
        <div class="container-fluid page-body-wrapper">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="contact-messages">
                        <!-- Data will be dynamically added here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Dialog -->
    <div id="responseModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Respond to Message</h2>
                <button id="closeModalBtn">&times;</button>
            </div>
            <div class="modal-body">
                <form id="responseForm">
                    <input type="hidden" id="messageId" name="messageId">
                    <div>
                        <label for="response">Response:</label>
                        <textarea id="response" name="response" rows="4" style="width: 100%;"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="sendResponseBtn" type="button">Send</button>
                <button id="closeModalBtnFooter" type="button">Close</button>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        fetchContactMessages();

        document.getElementById('closeModalBtn').addEventListener('click', closeModal);
        document.getElementById('closeModalBtnFooter').addEventListener('click', closeModal);
        document.getElementById('sendResponseBtn').addEventListener('click', sendResponse);
        document.getElementById('closeSuccessBtn').addEventListener('click', closeSuccessModal);
    });

    function fetchContactMessages() {
        fetch('/contact/messages')
            .then(response => response.json())
            .then(data => {
                const messagesContainer = document.getElementById('contact-messages');
                messagesContainer.innerHTML = '';

                data.forEach(message => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${message.name}</td>
                        <td>${message.email}</td>
                        <td>${message.subject}</td>
                        <td>${message.message}</td>
                        <td>
                            ${message.responded ? '<button class="responded-btn" disabled>Responded</button>' : `<button class="respond-btn" data-id="${message.id}" data-email="${message.email}">Respond</button>`}
                        </td>
                    `;
                    messagesContainer.appendChild(row);
                });

                document.querySelectorAll('.respond-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const messageId = this.getAttribute('data-id');
                        openModal(messageId);
                    });
                });
            })
            .catch(error => console.error('Error fetching contact messages:', error));
    }

    function openModal(messageId) {
        document.getElementById('messageId').value = messageId;
        document.getElementById('responseModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('responseModal').style.display = 'none';
    }

    function closeSuccessModal() {
        document.getElementById('successModal').style.display = 'none';
    }

    function sendResponse() {
        const messageId = document.getElementById('messageId').value;
        const responseMessage = document.getElementById('response').value;
        const loadingOverlay = document.getElementById('loading-overlay');

        closeModal(); // Close response modal before showing loading overlay
        loadingOverlay.style.display = 'block';

        fetch('/contact/send-response', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                messageId: messageId,
                response: responseMessage
            })
        })
        .then(response => response.json())
        .then(data => {
            loadingOverlay.style.display = 'none';

            if (data.status === 'success') {
                // Show success modal
                document.getElementById('successModal').style.display = 'block';

                // Close success modal and update button text after closing
                document.getElementById('closeSuccessBtn').addEventListener('click', function() {
                    document.getElementById('successModal').style.display = 'none';

                    // Update button in the table to 'responded'
                    const respondBtn = document.querySelector(`button[data-id="${messageId}"]`);
                    if (respondBtn) {
                        respondBtn.classList.remove('respond-btn');
                        respondBtn.classList.add('responded-btn');
                        respondBtn.disabled = true;
                        respondBtn.innerHTML = 'Responded';
                    }
                });
            } else {
                alert('Failed to send response.');
            }
            fetchContactMessages(); // Refresh contact messages list
        })
        .catch(error => {
            console.error('Error sending response:', error);
            loadingOverlay.style.display = 'none';
            alert('Failed to send response.');
        });
    }
</script>

</body>
</html>

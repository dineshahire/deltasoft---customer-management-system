<?php
// Start the session
session_start();

// Include database connection
include 'db.php';

// Generate CSRF token if it doesn't exist
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}


// Logout functionality
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: lo.php'); // Redirect to login page after logout
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="admin_dashboard.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e7f1ff;
        }

        .navbar {
            background-color: #003366;
        }

        .navbar-brand {
            color: white !important;
            flex: 1;
            text-align: center;
        }

        .sidebar {
            background-color: #003366;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            border-right: 1px solid #ddd;
            z-index: 1000;
            padding: 15px;
        }

        .nav-link {
            color: white;
            margin-bottom: 10px;
        }

        .nav-link:hover {
            color: #cce5ff;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        .content-section {
            display: none;
        }

        .active-section {
            display: block;
        }

        table {
            color: black;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid grey;
        }

        th {
            background-color: #f0f0f0;
        }

        .sidebar-logo {
            width: 100px;
            margin: 15px 0;
        }

        .btn-primary {
            margin-right: 10px;
        }

        /* Toggle Switch Styles */
        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 24px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+ .slider {
            background-color: #28a745;
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
            <button class="btn btn-primary d-md-none" id="sidebarToggle" onclick="toggleSidebar()">
                <i class="bi bi-list"></i> Menu
            </button>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar">
                <div class="position-sticky">
                    <div class="d-flex align-items-center mb-3">
                        <img src="logo.png" alt="Logo" class="sidebar-logo">
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="showSection('customer-list-section')">
                                <i class="bi bi-list"></i> Customer List
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="showSection('complaints-details-section')">
                                <i class="bi bi-exclamation-triangle"></i> Complaints Details
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="showSection('feedback')">
                                <i class="bi bi-chat-dots"></i> Feedback
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="showSection('staff')">
                                <i class="bi bi-people"></i> Staff
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?logout=true">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="main-content col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <!-- Display Success/Error Messages -->
                <?php
                if (isset($_GET['msg'])) {
                    $msg = htmlspecialchars($_GET['msg']);
                    echo "<div class='alert alert-info alert-dismissible fade show' role='alert'>
                            $msg
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                          </div>";
                }
                ?>

                <!-- Customer List Section -->
                <div id="customer-list-section" class="content-section active-section">
                    <h1>Customer List</h1>
                    <div class="d-flex justify-content-end mb-3">
                    <input type="text" id="searchBar" placeholder="Search..." class="form-control" style="width: 300px; background-color: #e7f1ff; color: white;">
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Database connection parameters
                            $servername = "localhost";
                            $username_db = "root";
                            $password_db = "";
                            $database = "register";

                            // Create connection
                            $connection = new mysqli($servername, $username_db, $password_db, $database);

                            // Check connection
                            if ($connection->connect_error) {
                                die("Connection failed: " . $connection->connect_error);
                            }

                            // Execute query to select only the required columns
                            $sql = "SELECT id, name, email FROM form";
                            $result = $connection->query($sql);

                            // Check if the query was successful
                            if (!$result) {
                                die("Invalid query: " . $connection->error);
                            }

                            // Fetch data and display it
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>" . htmlspecialchars($row["id"]) . "</td>
                                    <td>" . htmlspecialchars($row["name"]) . "</td>
                                    <td>" . htmlspecialchars($row["email"]) . "</td>
                                </tr>";
                            }

                            // Close the connection
                            $connection->close();
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Complaints Details Section -->
                <div id="complaints-details-section" class="content-section">
                    <h1>Complaints Details</h1>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Priority</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Database connection parameters
                            $connection = new mysqli($servername, $username_db, $password_db, $database);

                            // Check connection
                            if ($connection->connect_error) {
                                die("Connection failed: " . $connection->connect_error);
                            }

                            // Execute query
                            $sql = "SELECT * FROM complaints";
                            $result = $connection->query($sql);

                            // Check if the query was successful
                            if (!$result) {
                                die("Invalid query: " . $connection->error);
                            }

                            // Fetch data and display it
                            while ($row = $result->fetch_assoc()) {
                                // Determine the current status
                                $isActive = $row["active"] == 1 ? "checked" : "";
                                // Determine the priority display
                                switch ($row["priority"]) {
                                    case 1:
                                        $priorityLabel = "High";
                                        $priorityClass = "text-warning";
                                        break;
                                    case 2:
                                        $priorityLabel = "Critical";
                                        $priorityClass = "text-danger";
                                        break;
                                    default:
                                        $priorityLabel = "Normal";
                                        $priorityClass = "text-secondary";
                                }

                                echo "<tr>
                                    <td>" . htmlspecialchars($row["id"]) . "</td>
                                    <td>" . htmlspecialchars($row["product"]) . "</td>
                                    <td>" . htmlspecialchars($row["title"]) . "</td>
                                    <td>" . htmlspecialchars($row["description"]) . "</td>
                                    <td>" . htmlspecialchars($row["date"]) . "</td>
                                    <td>
                                    <form action='toggle_status.php' method='post' style='display:inline;'>
                                        <input type='hidden' name='id' value='" . htmlspecialchars($row["id"]) . "'>
                                        <input type='hidden' name='csrf_token' value='" . htmlspecialchars($_SESSION['csrf_token']) . "'>
                                        <label class='switch'>
                                            <input type='checkbox' name='active' value='1' " . $isActive . " onchange='this.form.submit()'>
                                            <span class='slider'></span>
                                        </label>
                                    </form>

                                    </td>
                                    <td>
                                        <form action='set_priority.php' method='post' class='d-inline'>
                                            <input type='hidden' name='id' value='" . htmlspecialchars($row["id"]) . "'>
                                            <select name='priority' class='form-select form-select-sm d-inline w-auto' onchange='this.form.submit()'>
                                                <option value='0' " . ($row["priority"] == 0 ? "selected" : "") . ">Normal</option>
                                                <option value='1' " . ($row["priority"] == 1 ? "selected" : "") . ">High</option>
                                                <option value='2' " . ($row["priority"] == 2 ? "selected" : "") . ">Critical</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>";
                            }

                            // Close the connection
                            $connection->close();
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Feedback Section -->
                <div id="feedback" class="content-section">
                    <h1>Feedback</h1>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User ID</th>
                                <th>Product Satisfaction</th>
                                <th>Service Satisfaction</th>
                                <th>Team Satisfaction</th>
                                <th>Date and Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Database connection parameters
                            $connection = new mysqli($servername, $username_db, $password_db, $database);

                            // Execute query
                            $sql = "SELECT * FROM feedback";
                            $result = $connection->query($sql);

                            // Check if the query was successful
                            if (!$result) {
                                die("Invalid query: " . $connection->error);
                            }

                            // Fetch data and display it
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>" . htmlspecialchars($row["id"]) . "</td>
                                    <td>" . htmlspecialchars($row["user_id"]) . "</td>
                                    <td>" . htmlspecialchars($row["product_satisfaction"]) . "</td>
                                    <td>" . htmlspecialchars($row["service_satisfaction"]) . "</td>
                                    <td>" . htmlspecialchars($row["team_satisfaction"]) . "</td>
                                    <td>" . htmlspecialchars($row["submitted_at"]) . "</td>";
                                // Only include created_at if it exists
                                if (isset($row["created_at"])) {
                                    echo "<td>" . htmlspecialchars($row["created_at"]) . "</td>";
                                }
                                echo "</tr>";
                            }

                            // Close the connection
                            $connection->close();
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Staff Section -->
                <div id="staff" class="content-section">
                    <h1>Staff</h1>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Database connection parameters
                            $connection = new mysqli($servername, $username_db, $password_db, $database);

                            // Check connection
                            if ($connection->connect_error) {
                                die("Connection failed: " . $connection->connect_error);
                            }

                            // Fetch staff data
                            $sql = "SELECT * FROM staff";
                            $result = $connection->query($sql);

                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>" . htmlspecialchars($row["id"]) . "</td>
                                    <td>" . htmlspecialchars($row["name"]) . "</td>
                                    <td>" . htmlspecialchars($row["email"]) . "</td>
                                </tr>";
                            }

                            // Close the connection
                            $connection->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (Optional if you need interactive components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function showSection(sectionId) {
        const sections = document.querySelectorAll('.content-section');
        sections.forEach(section => {
            section.classList.remove('active-section');
        });
        document.getElementById(sectionId).classList.add('active-section');
    }

    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('d-none');
    }

    // Search functionality
    document.getElementById('searchBar').addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#customer-list-section tbody tr');

        rows.forEach(row => {
            const cells = row.getElementsByTagName('td');
            let match = false;

            for (let i = 1; i < cells.length; i++) { // Start from index 1 to skip ID
                if (cells[i].textContent.toLowerCase().indexOf(filter) > -1) {
                    match = true;
                    break;
                }
            }

            row.style.display = match ? '' : 'none'; // Show or hide row based on match
        });
    });
</script>

</body>

</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Google link -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />

    <!-- My CSS -->
    <link rel="stylesheet" href="/Assets/css/Dashboard-page/dashboard-style.css">

    <!-- My Js -->
    <script src="/Assets/js/Dashboard-js/dashboard-script.js"></script>
    <script src="/Assets/js/Dashboard-js/order.js"></script>
</head>
<body>
    <div class="container">
        <!-- Sidebar Section -->
        <aside>
            <div class="toggle">
                <div class="logo">
                    <img src="/Assets/css/Dashboard-page/Images/logo.png" alt="">
                    <h2>Dash<span class="danger">Board</span></h2>
                </div>
                <div class="close" id="close-btn">
                    <span class="material-symbols-outlined">
                        close
                    </span>
                </div>
            </div>

            <div class="sidebar">
                <a href="#">
                    <span class="material-symbols-outlined">
                        dashboard
                    </span>
                    <h3>Dashboard</h3>
                </a>
                <a href="#">
                    <span class="material-symbols-outlined">
                        person_outline
                    </span>
                    <h3>Users</h3>
                </a>
                <a href="#">
                    <span class="material-symbols-outlined">
                        receipt_long
                    </span>
                    <h3>History</h3>
                </a>
                <a href="#" class="active">
                    <span class="material-symbols-outlined">
                        insights
                    </span>
                    <h3>Analytics</h3>
                </a>
                <a href="#" class="active">
                    <span class="material-symbols-outlined">
                        mail_outline
                    </span>
                    <h3>Tickets</h3>
                    <span class="message-count">27</span>
                </a>
                <a href="#" class="active">
                    <span class="material-symbols-outlined">
                        inventory
                    </span>
                    <h3>Sale List</h3>
                </a>
                <a href="#" class="active">
                    <span class="material-symbols-outlined">
                        report
                    </span>
                    <h3>Reports</h3>
                </a>
                <a href="#" class="active">
                    <span class="material-symbols-outlined">
                        settings
                    </span>
                    <h3>Settings</h3>
                </a>
                <a href="#" class="active">
                    <span class="material-symbols-outlined">
                        add
                    </span>
                    <h3>New Login</h3>
                </a>
                <a href="#" class="active">
                    <span class="material-symbols-outlined">
                        logout
                    </span>
                    <h3>Logout</h3>
                </a>
            </div>
        </aside>
        <!-- End of Sidebar Section -->
    </div>
</body>
</html>
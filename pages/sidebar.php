<!DOCTYPE html>
<html lang="en">
<head>
    <!-- My Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap" rel="stylesheet">

    <!-- My Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* CSS untuk sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 60px; /* Width for the collapsed sidebar */
            height: 100%;
            background-color: #333;
            overflow-x: hidden;
            transition: width 0.3s;
        }

        .sidebar.active {
            width: 200px; /* Width for the expanded sidebar */
            z-index: 999;
        }

        .content {
            transition: margin-left 0.3s;
            margin-left: 60px; /* Default margin for closed sidebar */
            padding: 20px;
            flex-grow: 1;
        }

        .content.active {
            margin-left: 200px; /* Adjust this value to match sidebar width */
        }

        .sidebar a {
            padding: 7rem 0 0 1.3rem;
            text-decoration: none;
            color: white;
            display: flex;
            align-items: center;
        }

        .sidebar a .text {
            display: none; /* Initially hide text */
            margin-left: 10px; /* Space between icon and text */
        }

        .sidebar.active a .text {
            display: inline; /* Show text when sidebar is active */
        }

        /* Button style */
        .toggle-button {
            position: fixed;
            top: 20px;
            left: 0.5rem; /* Slightly to the right of the sidebar */
            font-size: 1.5rem;
            background-color: #333;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
            z-index: 1000; /* Ensure it’s above other content */
        }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <a href="dashboard-page.php"><i class="fa-solid fa-house"></i><span class="text"> Home</span></a>
        <a href="stores-page.php"><i class="fa-solid fa-cart-shopping"></i><span class="text"> My Store</span></a>
        <a href="financialreport-page.php"><i class="fa-solid fa-clipboard"></i><span class="text"> Financial</span></a>
        <a href="../process/logout.php"><i class="fa-solid fa-right-from-bracket"></i><span class="text"> Log Out</span></a>
    </div>

    <button class="toggle-button" onclick="toggleSidebar()">☰</button>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const content = document.querySelector('.content');
            sidebar.classList.toggle('active');
            content.classList.toggle('active');
        }
    </script>
</body>
</html>

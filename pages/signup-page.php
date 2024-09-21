<?php
// Memanggil file config untuk koneksi database
require '../config/config.php';

// Memulai sesi
session_start();

// Memeriksa apakah pengguna sudah login dengan memeriksa session
if(!empty($_SESSION["users_id"])){
    // Jika pengguna sudah login, redirect ke halaman dashboard atau halaman lain yang diinginkan
    header("Location: dashboard-page.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>

    <!-- My Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap" rel="stylesheet">

    <!-- My style -->
    <style>
        /* Basic styling */

        :root {
            --primary: #E3E1D9;
            --bg: #F2EFE5;
            --third: #C7C8CC;
            --nav: #495464;
            --font: #424242;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins';
            background-color: var(--bg);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow-x: hidden;
        }

        .container {
            background-color: var(--primary);
            padding: 2rem;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            max-width: 400px;
            width: 100%;
        }

        h2 {
            text-align: center;
            color: var(--font);
            margin-bottom: 1.5rem;
        }

        .form-singup form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 0.5rem;
            color: var(--font);
        }

        input {
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            width: 100%;
        }

        button {
            padding: 0.75rem;
            background-color: var(--nav);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: var(--font);
        }

        .extra {
            text-align: center;
            margin-top: 1rem;
        }

        .extra a {
            color: #007bff;
            text-decoration: none;
        }

        .extra a:hover {
            text-decoration: underline;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .container {
                padding: 1.5rem;
                box-shadow: none;
                border-radius: 10px;
                box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            }

            input, button {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="judul">
        <h2>Registration</h2>
        </div>
        
        <div class="form-singup">
            <form action="../process/signup.php" method="post">
                <label for="username">Username : </label>
                <input type="text" name="username" id="username" required > <br>
                <label for="email">Email : </label>
                <input type="email" name="email" id="email" required > <br>
                <label for="pass">Password : </label>
                <input type="password" name="pass" id="pass" required > <br>
                <label for="confpass">Confirm Password : </label>
                <input type="password" name="confpass" id="confpass" required> <br>
                <button type="submit" name="submit">Register</button>
            </form>
        </div>
        <div class="extra">
            Already have account? <a href="login-page.php">Log In</a>
        </div>
    </div>
</body>
</html>
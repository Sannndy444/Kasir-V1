<?php
// Memanggil file config untuk koneksi database
require 'config/config.php';

// Memulai sesi
session_start();

// Memeriksa apakah pengguna sudah login dengan memeriksa session
if(!empty($_SESSION["id"])){
    // Jika pengguna sudah login, redirect ke halaman dashboard atau halaman lain yang diinginkan
    header("Location: pages/dashboard-page.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir Simpel</title>

    <!-- My Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap" rel="stylesheet">

    <!-- My Icon -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">

    <!-- My Script -->
    <script src="js/script.js"></script>

    <!-- My Style -->
    <link rel="stylesheet" href="css/styles.css">

    <style>

        @media only screen and (min-width: 1280px) {
            header {
                background-color: var(--nav);
                padding: 1rem 0;
                text-align: center;
                z-index: 999;
            }
            .navbar {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin: 0 auto;
                padding: 0 1rem;
            }
            .logo {
                width: 9rem;
                padding: 0.5rem 3rem 0.5rem 1rem;
            }

            .nav {
                list-style: none;
                padding: 0;
                margin: 0;
                display: flex;
            }

            /* Agar navbar list diratakan secara horizontal */
            .navB {
                display: flex;
                flex-direction: row; /* Item secara horizontal */
                justify-content: space-around; /* Rata dengan jarak antar item */
                align-items: center; /* Rata secara vertikal */
                width: 100%; /* Membuat list menu menyesuaikan lebar */
                padding: 0;
            }

            .navB li {
                list-style: none;
                margin: 0 1rem; /* Memberi jarak antar item */
            }

            .navB li a {
                text-decoration: none;
                color: white;
                font-size: 1.6rem;
            }

            .navB a:hover {
                color: var(--bg);
            }

            .navB a::after {
                content: '';
                display: block;
                border-bottom: 0.1rem solid var(--bg);
                transform: scaleX(0);
                transition: 0.2s linear;
            }

            .navB a:hover::after {
                transform: scaleX(0.5);
            }

            .hamburger, .sidebar {
                visibility: hidden;
            }

        }

        @media screen and (min-width: 1025px) and (max-width: 1279px) {
            header {
                background-color: var(--nav);
                padding: 1rem 0;
                text-align: center;
                z-index: 999;
            }
            .navbar {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin: 0 auto;
                padding: 0 1rem;
            }
            .logo {
                width: 9rem;
                padding: 0.5rem 3rem 0.5rem 1rem;
            }

            .nav {
                list-style: none;
                padding: 0;
                margin: 0;
                display: flex;
            }

            /* Agar navbar list diratakan secara horizontal */
            .navB {
                display: flex;
                flex-direction: row; /* Item secara horizontal */
                justify-content: space-around; /* Rata dengan jarak antar item */
                align-items: center; /* Rata secara vertikal */
                width: 100%; /* Membuat list menu menyesuaikan lebar */
                padding: 0;
            }

            .navB li {
                list-style: none;
                margin: 0 1rem; /* Memberi jarak antar item */
            }

            .navB li a {
                text-decoration: none;
                color: white;
                font-size: 1.5rem;
            }
            
            .navB a:hover {
                color: var(--bg);
            }

            .navB a::after {
                content: '';
                display: block;
                border-bottom: 0.1rem solid var(--bg);
                transform: scaleX(0);
                transition: 0.2s linear;
            }

            .navB a:hover::after {
                transform: scaleX(0.5);
            }

            .hamburger, .sidebar {
                visibility: hidden;
            }

        }

        @media screen and (max-width: 1024px) and (min-width: 769px) {
            header {
                background-color: var(--nav);
                padding: 1rem 0;
                text-align: center;
                z-index: 999;
            }
            .navbar {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin: 0 auto;
                padding: 0 1rem;
            }
            .logo {
                width: 9rem;
                padding: 0.5rem 3rem 0.5rem 1rem;
            }

            .nav {
                list-style: none;
                padding: 0;
                margin: 0;
                display: flex;
            }

            /* Agar navbar list diratakan secara horizontal */
            .navB {
                display: flex;
                flex-direction: row; /* Item secara horizontal */
                justify-content: space-around; /* Rata dengan jarak antar item */
                align-items: center; /* Rata secara vertikal */
                width: 100%; /* Membuat list menu menyesuaikan lebar */
                padding: 0;
            }

            .navB li {
                list-style: none;
                margin: 0 1rem; /* Memberi jarak antar item */
            }

            .navB li a {
                text-decoration: none;
                color: white;
                font-size: 1.3rem;
            }

            .navB a:hover {
                color: var(--bg);
            }

            .navB a::after {
                content: '';
                display: block;
                border-bottom: 0.1rem solid var(--bg);
                transform: scaleX(0);
                transition: 0.2s linear;
            }

            .navB a:hover::after {
                transform: scaleX(0.5);
            }

            .hamburger, .sidebar {
                visibility: hidden;
            }

        }

        @media only screen and (max-width: 768px) and (min-width: 0px) {
            header {
                background-color: var(--nav);
                padding: 1rem 0;
                text-align: center;
                z-index: 999;
                position: relative;
            }
            .navbar {
                display: flex;
                flex-wrap: wrap;
                margin: 0 auto;
                padding: 0 1rem;
            }
            .logo {
                width: 9rem;
                padding: 0.5rem 3rem 0.5rem 1rem;
            }
            .nav {
                visibility: hidden;
            }

            .hamburger {
                visibility: visible;
                display: flex;
                font-size: 3rem;
                position: absolute;
                right: 1rem;
                cursor: pointer;
                padding: 0.5rem 1rem 0 0;
                z-index: 1;
            }

            .sidebar {
                height: 100%;
                width: 0;
                position: fixed;
                z-index: 1;
                top: 0;
                right: 0;
                background-color: var(--nav);
                opacity: 90%;
                overflow-x: hidden;
                transition: 0.5s;
                padding-top: 9rem;
            }

            .sidebar a {
                padding: 10px 15px;
                text-decoration: none;
                font-size: 25px;
                color: var(--primary);
                display: block;
                transition: 0.3s;
            }

            .sidebar a:hover {
                color: var(--bg);
            }

            .sidebar .closebtn {
                position: absolute;
                top: 0;
                right: 25px;
                font-size: 36px;
                margin-left: 50px;
            }



        }
        
        
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="navbar">
                <div class="logo">
                    <img class="logo" src="assets/logo-2.png" alt="">
                </div>
                <div class="nav">
                    <ul class="navB">
                        <li><a href="#about">Tentang Kami</a></li>
                        <li><a href="#fitur">Fitur Kami</a></li>
                        <li><a href="#contact">Hubungi Kami</a></li>
                        <li><a href="#join">SingUp</a></li>
                    </ul>
                </div>
                <div class="hamburger" onclick="toggleSidebar()">&#9776;</div>
            </div>
        </header>
        <div class="sidebar" id="sidebar">
        <a href="javascript:void(0)" class="closebtn" onclick="toggleSidebar()">&times;</a>
        <a href="#about">Tentang Kami</a>
        <a href="#fitur">Fitur Kami</a>
        <a href="#contact">Hubungi Kami</a>
        <a href="pages/signup-page.php">SingUp</a>
    </div>
        
        <!-- <div class="head">
            <h2>
                
            </h2>
        </div> -->
        
    </div>

    <?php include 'pages/landing-page.php'; ?>
</body>
</html>
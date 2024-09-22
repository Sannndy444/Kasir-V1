<?php
// Mulai sesi PHP
session_start();

// Memanggil file config untuk koneksi database
require '../config/config.php';



// Memeriksa apakah pengguna sudah login dengan memeriksa session ID
if (!empty($_SESSION["users_id"])) {
    $user_id = $_SESSION["users_id"];
    
    // Melakukan query untuk mendapatkan data pengguna berdasarkan ID
    $result = mysqli_query($conn, "SELECT * FROM users WHERE users_id = $user_id");
    
    // Memeriksa apakah query berhasil dan ada data yang diambil
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Ambil store_id dari session
        $store_id = $_SESSION['store_id'] ?? null;

        // Memeriksa apakah store_id ada
        if (empty($store_id)) {
            // Arahkan ke halaman untuk menambahkan toko
            header("Location: addstore-page.php");
            exit();
        }

        // Menentukan query berdasarkan peran user
        $store_query = "";
        if ($row['role'] === 'admin') {
            // Jika user adalah admin, cari store_id berdasarkan owner_id
            $store_query = "SELECT store_id FROM stores WHERE owner_id = '$user_id'";
        } elseif ($row['role'] === 'kasir') {
            // Jika user adalah kasir, cari store_id berdasarkan store_id di session
            $store_query = "SELECT store_id FROM stores WHERE store_id = '$store_id'";
        }

        // Jika ada query untuk store, jalankan
        if ($store_query) {
            $store_result = mysqli_query($conn, $store_query);
            if ($store_result && mysqli_num_rows($store_result) > 0) {
                $store_row = mysqli_fetch_assoc($store_result);
                $_SESSION['store_id'] = $store_row['store_id'];
            } else {
                // Jika tidak ada store yang ditemukan, arahkan ke halaman untuk menambahkan toko
                header("Location: addstore-page.php");
                exit();
            }
        }
    } else {
        // Jika query gagal atau tidak ada data, redirect ke halaman login
        header("Location: login-page.php");
        exit();
    }
} else {
    // Jika session ID tidak ada, redirect ke halaman login
    header("Location: login-page.php");
    exit();
}

// var_dump($_SESSION);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- My style -->
    <!-- <link rel="stylesheet" href="../css/styles.css"> -->
    <style>
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
            color: #fff;
            background-color: var(--bg);
            overflow-x: hidden;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .dash-content {
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 10rem 0 0 0;
        }

        h2 {
            font-size: 5rem;
            color: var(--font);
            flex: 1 1 auto;
            padding: 0 20rem 0 20rem; 
        }

        h2 span {
            color: var(--nav);
        }

        img {
            width: 50rem;
            flex: 1 1 auto;
            padding: 5rem 0 0 5rem;
            right: 1rem;
        }

        @media only screen and (min-width: 1280px) {
            .dash-content {
                display: flex;
                flex-direction: column;
                justify-content: space-around;
                align-items: center;
                padding: 5rem 0 0 0;
            }

            h2 {
                font-size: 5rem;
                padding: 2rem 0 0 8rem;
            }
            img {
                width: 45rem;
                position: absolute;
                z-index: -1;
                top: 23rem;
                right: 1rem;
            }
        }

        @media screen and (min-width: 1025px) and (max-width: 1279px) {
            .dash-content {
                display: flex;
                flex-direction: column;
                justify-content: space-around;
                align-items: center;
                padding: 5rem 0 0 0;
            }

            h2 {
                font-size: 5rem;
                padding: 2rem 0 0 8rem;
            }
            img {
                width: 35rem;
                position: absolute;
                z-index: -1;
                top: 23rem;
                right: 1rem;
            }
        }

        @media screen and (max-width: 1024px) and (min-width: 769px) {
            .dash-content {
                display: flex;
                flex-direction: column;
                justify-content: space-around;
                align-items: center;
                padding: 5rem 0 0 0;
            }

            h2 {
                font-size: 5rem;
                padding: 2rem 0 0 8rem;
            }
            img {
                width: 35rem;
                position: absolute;
                z-index: -1;
                top: 23rem;
                right: 1rem;
            }
        }

        @media only screen and (max-width: 768px) and (min-width: 0px)  {
            .dash-content {
                display: flex;
                flex-direction: column;
                justify-content: space-around;
                align-items: center;
                padding: 5rem 0 0 0;
            }

            h2 {
                font-size: 4rem;
                padding: 5rem 0 0 8rem;
            }
            img {
                position: absolute;
                width: 35rem;
                top: 30rem;
                right: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <?php include 'sidebar.php'; ?>
        </div>
        <div class="content">
            <div class="dash-content">
                <h2>Welcome to <br> Kasir Simple <br> <span> <?php echo $row['username']; ?></span></h2>
                <img src="../assets/12.png" alt="">
            </div>
        </div>
        
    </div>


    
</body>
</html>
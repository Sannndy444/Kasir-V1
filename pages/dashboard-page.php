<?php
// Mulai sesi PHP
session_start();

// Memanggil file config untuk koneksi database
require '../config/config.php';



// Memeriksa apakah pengguna sudah login dengan memeriksa session ID
if (!empty($_SESSION["users_id"])) {
    $user_id = $_SESSION["users_id"];
    $store_id = $_SESSION['store_id'];
    
    // Melakukan query untuk mendapatkan data pengguna berdasarkan ID
    $result = mysqli_query($conn, "SELECT * FROM users WHERE users_id = $user_id");
    $store = mysqli_query($conn, "SELECT store_id FROM stores WHERE store_id = '$store_id'");
    
    // Memeriksa apakah query berhasil dan ada data yang diambil
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Menentukan query berdasarkan peran user
        $store_query = "";
        if ($row['role'] === 'admin') {
            // Jika user adalah owner, cari store_id berdasarkan owner_id
            $store_query = "SELECT store_id FROM stores WHERE owner_id = '$user_id'";
        } elseif ($row['role'] === 'kasir') {
            // Jika user adalah kasir, cari store_id berdasarkan cashier_id di tabel cashiers
            $store_query = "SELECT store_id FROM stores WHERE store_id = '$store_id'";
        }

        // Jika ada query untuk store, jalankan
        if ($store_query) {
            $store_result = mysqli_query($conn, $store_query);
            if ($store_result && mysqli_num_rows($store_result) > 0) {
                $store_row = mysqli_fetch_assoc($store_result);
                $_SESSION['store_id'] = $store_row['store_id'];
            }
        }
    } else {
        // Jika query gagal atau tidak ada data, redirect ke halaman login
        header("Location: login-page.php");
        exit;
    }
} else {
    // Jika session ID tidak ada, redirect ke halaman login
    header("Location: login-page.php");
    exit;
}

var_dump($_SESSION);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome to Dashboard, <?php echo $row['username']; ?></h2> <br>
    <a href="addstore-page.php">Add Store</a>
    <a href="transaction-page.php">Transaction</a>
    <a href="financialreport-page.php">Financial Report</a>
    <a href="stores-page.php">View Stores</a>
    <a href="../process/logout.php">Log Out</a>
</body>
</html>
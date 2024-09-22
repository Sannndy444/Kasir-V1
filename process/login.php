<?php
require '../config/config.php';
session_start();

if (isset($_POST['login'])) {
    // Mengambil dan membersihkan input
    $usermail = mysqli_real_escape_string($conn, $_POST["usermail"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    
    // Query untuk mengambil data user berdasarkan username atau email
    $query = "SELECT users_id, password, role, store_id FROM users WHERE username = '$usermail' OR email = '$usermail'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query Error: " . mysqli_error($conn)); // Menangani error query
    }

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $hashed_pass = $row['password'];

        // Verifikasi password
        if (password_verify($password, $hashed_pass)) {
            $_SESSION['users_id'] = $row['users_id'];
            $_SESSION['role'] = $row['role'];
            
            // Cek role pengguna
            if ($row['role'] === 'admin') {
                // Jika pengguna adalah admin, ambil store_id dari tabel stores berdasarkan owner_id
                $user_id = $_SESSION['users_id'];
                $store_query = "SELECT store_id FROM stores WHERE owner_id = '$user_id'";
                $store_result = mysqli_query($conn, $store_query);

                if (!$store_result) {
                    die("Store Query Error: " . mysqli_error($conn)); // Menangani error query
                }

                if (mysqli_num_rows($store_result) > 0) {
                    $store_row = mysqli_fetch_assoc($store_result);
                    $_SESSION['store_id'] = $store_row['store_id'];
                }
            } elseif ($row['role'] === 'kasir') {
                // Jika pengguna adalah kasir, ambil store_id langsung dari tabel users
                $_SESSION['store_id'] = $row['store_id'];
            }

            // Periksa jika store_id tidak ada
            if (empty($_SESSION['store_id'])) {
                header("Location: ../pages/addstore-page.php");  // Arahkan ke halaman addstore
                exit;
            }

            header("Location: ../pages/dashboard-page.php");  // Arahkan pengguna setelah login
            exit;
        } else {
            $_SESSION['error'] = 'Password salah.';
            header("Location: ../pages/login-page.php");
            exit;
        }
    } else {
        $_SESSION['error'] = 'Email tidak ditemukan.';
        header("Location: ../pages/login-page.php");
        exit;
    }
}
?>

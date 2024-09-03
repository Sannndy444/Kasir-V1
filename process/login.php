<?php
session_start();
require '../config/config.php';

if(isset($_POST['submit'])){
    $usermail = $_POST["usermail"];
    $password = $_POST["password"];
    
    // Query untuk mengambil data user berdasarkan username atau email
    $query = "SELECT * FROM users WHERE username = '$usermail' OR email = '$usermail'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        $hashed_pass = $row['password'];

        // Memeriksa apakah password yang dimasukkan sesuai dengan password yang di-hash
        if(password_verify($password, $hashed_pass)){
            // Jika password benar, set session untuk login dan ID user
            $_SESSION["login"] = true;
            $_SESSION["id"] = $row["id"];
            $_SESSION["role"] = $row["role"];
            var_dump($_SESSION);
            header("location: ../pages/dashboard-page.php");
            exit;
        } else {
            echo "<script>alert('Wrong Password');</script>";
        }
    } else {
        echo "<script>alert('Username Not Registered');</script>";
    }
}
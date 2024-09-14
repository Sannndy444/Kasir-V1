<?php 

require '../config/config.php';

session_start();

if(isset($_POST['login'])){
    $usermail = mysqli_real_escape_string($conn,$_POST["usermail"]);
    $password = mysqli_real_escape_string($conn, $_POST["pass"]);

    $query = "SELECT user_id, password, role, store_id FROM users WHERE username = '$usermail' OR password = '$password'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $hashed_pass = $row['password'];


    } else {
        echo "<script>alert('Username atau password salah.'); window.location.href = '../pages/cashierlogin-page.php';</script>";
    }
}
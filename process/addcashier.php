<?php
require '../config/config.php';
session_start();

if(isset($_POST['submit']) && isset($_SESSION['users_id'])){
    $username = mysqli_real_escape_string($conn, $_POST['unameC']);
    $email = mysqli_real_escape_string($conn, $_POST['emailC']);
    $pass = $_POST['passC'];
    $confpass = $_POST['conpassC'];
    $store_id = $_SESSION['store_id'];
    $role = 'kasir';

    $duplicate = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username' OR email = '$email'");
    if(mysqli_num_rows($duplicate) > 0){
        echo
        "<script>
            alert('Username or Email already taken'); window.location.href = '../pages/addcashier-page.php';
        </script>";
    } else {
        if($pass == $confpass){
            $hashed_pass = password_hash($pass, PASSWORD_BCRYPT);
    
            $query = "INSERT INTO users (username, email, password, store_id, role) VALUES ('$username', '$email', '$hashed_pass', '$store_id', '$role')";
            echo $query;
            if (mysqli_query($conn, $query)) {
                echo
                "<script>
                alert('Add Cashier successfully'); window.location.href = '../pages/stores-page.php';
                </script>";
            } else {
                echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
            }
        } else {
            echo
            "<script>
                alert('Password is not match');
            </script>";
        }
    }
} 
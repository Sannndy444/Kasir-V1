<?php
require '../config/config.php';
session_start();

if(isset($_SESSION['id'])) {
    if(isset($_POST['submit'])) {
        $ntoko = mysqli_real_escape_string($conn, $_POST['ntoko']);
        $owid = intval($_SESSION['id']);

        

        // Pastikan nama toko tidak kosong
        if(!empty($ntoko)) {
            $query = "INSERT INTO stores (store_name, owner_id) VALUES ('$ntoko', '$owid')";
            if (mysqli_query($conn, $query)) {
                // Redirect menggunakan header
                header("Location: ../pages/stores-page.php");
                exit();
            } else {
                echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
            }
        } else {
            echo "<script>alert('Store name cannot be empty.');</script>";
        }
    }
} else {
    echo "<script>alert('You need to be logged in to create a store.');</script>";
    header("Location: ../pages/login-page.php");
    exit();
}

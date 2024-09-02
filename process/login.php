<?php
require '../config/config.php';

if(isset($_POST['submit'])){
    $usermail = $_POST["usermail"];
    $password = $_POST["password"];
    $query = "SELECT * FROM users WHERE username = '$usermail' OR email = '$usermail'";
    $result = mysqli_query($conn ,$query);

    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        $hashed_pass = $row['password'];

        if(password_verify($password, $hashed_pass)){
            $_SESSION["login"] = true;
            $_SESSION["id"] + $row["id"];
            header("location: ../pages/dashboard-page.php");
        } else {
            echo
            "<script>
                alert('Wrong Password');
            </script>";
        }
    } else {
        echo
        "<script>
            alert('Username Not Resgitered');
        </script>";
    }
}
?>
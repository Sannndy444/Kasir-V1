<?php 
require '../config/config.php';

if(isset($_POST['submit'])){
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = $_POST['pass'];
    $confpass = $_POST['confpass'];
    $role = 'kasir';

    $duplicate = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username' OR email = '$email'");
    if(mysqli_num_rows($duplicate) > 0){
        echo
        "<script>
            alert('Username or Email already taken');
        </script>";
    } else {
        if($pass == $confpass){
            $hashed_pass = password_hash($pass, PASSWORD_BCRYPT);

            $query = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$hashed_pass', '$role')";
            echo $query;
            if (mysqli_query($conn, $query)) {
                echo
                "<script>
                alert('Registration successfully'); window.location.href = '../pages/login-page.php';
                </script>";
            } else {
                echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
            }
        } else {
            echo
            "<script>
                alert('Username or Email has already taken');
            </script>";
        }
    }
}
?>
<?php 
require '../config.php';

if(isset($_POST['submit'])){
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = $_POST['pass'];
    $confpass = $_POST['confpass'];
    $role = 'superadmin';

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
                alert('Registration successfully'); window.location.href = 'pages/login-page.php';
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
<body>
    <div class="container">
        <div class="judul">
        <h2>Registration</h2>
        </div>
        
        <div class="form-singup">
            <form action="" method="post">
                <label for="username">Username : </label>
                <input type="text" name="username" id="username" required > <br>
                <label for="email">Email : </label>
                <input type="email" name="email" id="email" required > <br>
                <label for="pass">Password : </label>
                <input type="password" name="pass" id="pass" required > <br>
                <label for="confpass">Confirm Password : </label>
                <input type="password" name="confpass" id="confpass" required> <br>
                <button type="submit" name="submit">Register</button>
            </form>
        </div>
        <div class="extra">
            Already have account? <a href="login-page.php">Log In</a>
        </div>
    </div>
</body>
</html>
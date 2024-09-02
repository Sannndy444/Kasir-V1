<?php
require '../config.php';

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
            header("location: dashboard-page.php");
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
</head>
<body>
    <div class="container">
        <div class="judul">
            <h2>Log In</h2>
        </div>
        <div class="login-form">
            <form action="" method="post">
                <label for="usermail">Username or Email : </label>
                <input type="text" name="usermail" id="usermail" require> <br>
                <label for="password">Passwsord : </label>
                <input type="password" name="password" id="password" require> <br>
                <button type="submit" name="submit">Log In</button>
            </form>
            
        </div>
        <div class="extra">
            Dont have account? <a href="singup-page.php">Sign Up</a>
        </div>
    </div>
</body>
</html>
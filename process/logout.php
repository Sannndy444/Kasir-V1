<?php
require '../config/config.php';

// $_SESSION["login"] = true;
session_unset();
session_destroy();
header("Location: ../pages/login-page.php");

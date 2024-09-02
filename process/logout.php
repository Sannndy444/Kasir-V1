<?php
require '../config.php';

// $_SESSION["login"] = true;
session_unset();
session_destroy();
header("Location: login-page.php");
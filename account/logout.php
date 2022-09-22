<?php ob_start(); session_start();
    unset($_SESSION['emp_login']);
    unset($_SESSION['emp_last_login_timestamp']);
    header("Location: ../index");

?>

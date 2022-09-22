<?php ob_start(); session_start();
unset($_SESSION['adm_login']);
unset($_SESSION['adm_last_login_timestamp']);
header("Location: index");

?>

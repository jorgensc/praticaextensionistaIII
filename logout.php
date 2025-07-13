<?php
include_once 'config.php'; 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$_SESSION = array();

session_destroy();

header("location: " . BASE_URL . "login.php");
exit;
?>
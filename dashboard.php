<?php
include_once 'config.php';

redirect_if_not_logged_in();

if (is_admin()) {
    header("location: " . BASE_URL . "admin/index.php");
} else {
    header("location: " . BASE_URL . "index.php");
    exit;
}
?>
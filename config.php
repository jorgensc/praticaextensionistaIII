<?php
session_start();

//config do Banco
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'coloratto_db');

define('BASE_URL', '/coloratto/');

//Teste banco
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

//Checa
if ($conn->connect_error) {
    die("Erro de conexão com o banco de dados: " . $conn->connect_error);
}

//function de autenticação
function is_logged_in() {
    return isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
}

function is_admin() {
    return is_logged_in() && isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function redirect_if_not_logged_in() {
    if (!is_logged_in()) {
        header("location: " . BASE_URL . "login.php");
        exit;
    }
}

function redirect_if_not_admin() {
    if (!is_admin()) {
        header("location: " . BASE_URL . "login.php");
        exit;
    }
}
?>
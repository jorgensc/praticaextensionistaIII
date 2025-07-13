<?php
include_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST["full_name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"] ?? ''); 
    $service_type = trim($_POST["service_type"]);
    $message = trim($_POST["message"]);

    if (empty($full_name) || empty($email) || empty($service_type) || empty($message)) {
        $_SESSION['status_message'] = "Preencha todos os campos obrigatórios.";
        $_SESSION['old_input'] = $_POST; 
        header("location: " . BASE_URL . "orçamentos.php?status=error");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['status_message'] = "Formato de e-mail inválido.";
        $_SESSION['old_input'] = $_POST;
        header("location: " . BASE_URL . "orçamentos.php?status=error");
        exit();
    }

    $sql = "INSERT INTO budgets (full_name, email, phone, service_type, message) VALUES (?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssss", $param_full_name, $param_email, $param_phone, $param_service_type, $param_message);
        
        $param_full_name = $full_name;
        $param_email = $email;
        $param_phone = $phone;
        $param_service_type = $service_type;
        $param_message = $message;

        if ($stmt->execute()) {
            header("location: " . BASE_URL . "orçamentos.php?status=success");
            exit();
        } else {
            $_SESSION['status_message'] = "Ops! Algo deu errado ao enviar o orçamento. Tente novamente mais tarde.";
            $_SESSION['old_input'] = $_POST;
            header("location: " . BASE_URL . "orçamentos.php?status=error");
            exit();
        }
        $stmt->close();
    } else {
        $_SESSION['status_message'] = "Erro na preparação da consulta.";
        $_SESSION['old_input'] = $_POST;
        header("location: " . BASE_URL . "orçamentos.php?status=error");
        exit();
    }

    $conn->close();
} else {
    // Se não for uma requisição POST, redireciona para a página de orçamento
    header("location: " . BASE_URL . "orçamentos.php");
    exit();
}
?>
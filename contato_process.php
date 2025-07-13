<?php
include_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $subject = trim($_POST["subject"] ?? '');
    $message = trim($_POST["message"]);

    //validação
    if (empty($name) || empty($email) || empty($message)) {
        $_SESSION['status_message'] = "Por favor, preencha todos os campos obrigatórios.";
        $_SESSION['old_input'] = $_POST;
        header("location: " . BASE_URL . "contact.php?status=error");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['status_message'] = "Formato de e-mail inválido.";
        $_SESSION['old_input'] = $_POST;
        header("location: " . BASE_URL . "contact.php?status=error");
        exit();
    }

    $sql = "INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssss", $param_name, $param_email, $param_subject, $param_message);
        
        $param_name = $name;
        $param_email = $email;
        $param_subject = $subject;
        $param_message = $message;

        if ($stmt->execute()) {
            header("location: " . BASE_URL . "contact.php?status=success");
            exit();
        } else {
            $_SESSION['status_message'] = "Ops! Algo deu errado ao enviar sua mensagem. Por favor, tente novamente mais tarde.";
            $_SESSION['old_input'] = $_POST;
            header("location: " . BASE_URL . "contact.php?status=error");
            exit();
        }
        $stmt->close();
    } else {
        $_SESSION['status_message'] = "Erro na preparação da query.";
        $_SESSION['old_input'] = $_POST;
        header("location: " . BASE_URL . "contact.php?status=error");
        exit();
    }

    $conn->close();
} else {
    header("location: " . BASE_URL . "contact.php");
    exit();
}
?>
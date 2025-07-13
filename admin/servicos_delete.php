<?php
include_once '../config.php';
redirect_if_not_admin();

if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $id = trim($_GET["id"]);

    $sql_select_image = "SELECT image_path FROM services WHERE id = ?";
    if ($stmt_select = $conn->prepare($sql_select_image)) {
        $stmt_select->bind_param("i", $param_id);
        $param_id = $id;

        if ($stmt_select->execute()) {
            $stmt_select->bind_result($image_path_to_delete);
            $stmt_select->fetch();
            $stmt_select->close();

            $sql_delete = "DELETE FROM services WHERE id = ?";
            if ($stmt_delete = $conn->prepare($sql_delete)) {
                $stmt_delete->bind_param("i", $param_id);

                if ($stmt_delete->execute()) {
                    if (!empty($image_path_to_delete) && file_exists('../' . $image_path_to_delete)) {
                        unlink('../' . $image_path_to_delete);
                    }
                    $_SESSION['status_message'] = "Serviço excluído com sucesso!";
                } else {
                    $_SESSION['status_message'] = "Erro ao excluir o serviço. Tente novamente.";
                }
                $stmt_delete->close();
            } else {
                $_SESSION['status_message'] = "Erro de preparação de query para exclusão.";
            }
        } else {
            $_SESSION['status_message'] = "Erro ao buscar caminho da imagem para exclusão.";
        }
    } else {
        $_SESSION['status_message'] = "Erro de preparação de query para selecionar imagem.";
    }
} else {
    $_SESSION['status_message'] = "ID do serviço não fornecido para exclusão.";
}

$conn->close();

header("location: " . BASE_URL . "admin/servicos_list.php");
exit();
?>
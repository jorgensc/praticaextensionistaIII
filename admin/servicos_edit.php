<?php
include_once '../config.php';
redirect_if_not_admin();

$pageTitle = "Editar Serviço";

$id = $name = $description = $price_range = $image_path = "";
$name_err = $description_err = $price_range_err = $image_err = "";

if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $id = trim($_GET["id"]);

    $sql = "SELECT name, description, price_range, image_path FROM services WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $param_id);
        $param_id = $id;

        if ($stmt->execute()) {
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                $stmt->bind_result($name, $description, $price_range, $image_path);
                $stmt->fetch();
            } else {
                $_SESSION['status_message'] = "Serviço não encontrado.";
                header("location: " . BASE_URL . "admin/servicos_list.php");
                exit();
            }
        } else {
            echo "Ops! Algo deu errado ao buscar o serviço. Por favor, tente novamente mais tarde.";
        }
        $stmt->close();
    }
} else {
    $_SESSION['status_message'] = "ID do serviço não fornecido.";
    header("location: " . BASE_URL . "admin/servicos_list.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["name"]))) {
        $name_err = "Por favor, insira o nome do serviço.";
    } else {
        $name = trim($_POST["name"]);
    }

    $description = trim($_POST["description"]);
    $price_range = trim($_POST["price_range"]);

    $new_image_path = $image_path;
    if (isset($_FILES["new_image"]) && $_FILES["new_image"]["error"] == 0) {
        $target_dir = "../assets/img/servicos/";
        $image_name = basename($_FILES["new_image"]["name"]);
        $target_file = $target_dir . $image_name;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["new_image"]["tmp_name"]);
        if($check !== false) {
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                $image_err = "Desculpe, apenas arquivos JPG, JPEG, PNG e GIF são permitidos.";
            } else {
                if (move_uploaded_file($_FILES["new_image"]["tmp_name"], $target_file)) {
                    $new_image_path = "assets/img/servicos/" . $image_name;
                } else {
                    $image_err = "Desculpe, houve um erro ao fazer o upload da nova imagem.";
                }
            }
        } else {
            $image_err = "O arquivo não é uma imagem.";
        }
    }

    if (empty($name_err) && empty($image_err)) {
        
        $sql = "UPDATE services SET name = ?, description = ?, price_range = ?, image_path = ? WHERE id = ?";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssssi", $param_name, $param_description, $param_price_range, $param_image_path, $param_id);
            
            $param_name = $name;
            $param_description = $description;
            $param_price_range = $price_range;
            $param_image_path = $new_image_path;
            $param_id = $id;

            if ($stmt->execute()) {
                $_SESSION['status_message'] = "Serviço atualizado com sucesso!";
                header("location: " . BASE_URL . "admin/servicos_list.php");
                exit();
            } else {
                echo "Ops! Algo deu errado ao atualizar o serviço. Por favor, tente novamente mais tarde.";
            }
            $stmt->close();
        }
    }
}

include '../header.php';
?>

        <section class="page-section">
            <div class="container">
                <h2 class="section-heading text-center">Editar Serviço</h2>
                <hr style="width: 100px; border-top: 3px solid #F26B1D; margin: 1rem auto 3rem auto;">

                <div class="form-section">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id; ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Nome do Serviço</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($name); ?>" required>
                            <span class="invalid-feedback"><?php echo $name_err; ?></span>
                        </div>    
                        <div class="form-group mt-3">
                            <label>Descrição</label>
                            <textarea name="description" class="form-control <?php echo (!empty($description_err)) ? 'is-invalid' : ''; ?>" rows="5"><?php echo htmlspecialchars($description); ?></textarea>
                            <span class="invalid-feedback"><?php echo $description_err; ?></span>
                        </div>
                        <div class="form-group mt-3">
                            <label>Faixa de Preço</label>
                            <input type="text" name="price_range" class="form-control <?php echo (!empty($price_range_err)) ? 'is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($price_range); ?>">
                            <span class="invalid-feedback"><?php echo $price_range_err; ?></span>
                        </div>
                        <div class="form-group mt-3">
                            <label>Imagem Atual</label><br>
                            <?php if (!empty($image_path) && file_exists('../' . $image_path)): ?>
                                <img src="<?php echo BASE_URL . htmlspecialchars($image_path); ?>" alt="Imagem do Serviço" style="max-width: 150px; height: auto; display: block; margin-bottom: 10px;">
                            <?php else: ?>
                                <p>Nenhuma imagem atual.</p>
                            <?php endif; ?>
                            <label class="mt-2">Nova Imagem (opcional)</label>
                            <input type="file" name="new_image" class="form-control <?php echo (!empty($image_err)) ? 'is-invalid' : ''; ?>">
                            <span class="invalid-feedback"><?php echo $image_err; ?></span>
                        </div>
                        <div class="form-group text-center mt-4">
                            <input type="submit" class="btn btn-primary" value="Atualizar Serviço" style="background-color: #F26B1D; border-color: #F26B1D;">
                            <a href="<?php echo BASE_URL; ?>admin/servicos_list.php" class="btn btn-secondary ms-2">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </section>

<?php
$conn->close();
include '../footer.php';
?>
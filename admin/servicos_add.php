<?php
include_once '../config.php';
redirect_if_not_admin();

$pageTitle = "Adicionar Serviço";
include '../header.php';

$name = $description = $price_range = $image_path = "";
$name_err = $description_err = $price_range_err = $image_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["name"]))) {
        $name_err = "Por favor, insira o nome do serviço.";
    } else {
        $name = trim($_POST["name"]);
    }

    $description = trim($_POST["description"]);
    $price_range = trim($_POST["price_range"]);

    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $target_dir = "../assets/img/servicos/";
        $image_name = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                $image_err = "Desculpe, apenas arquivos JPG, JPEG, PNG e GIF são permitidos.";
            } else {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image_path = "assets/img/servicos/" . $image_name;
                } else {
                    $image_err = "Desculpe, houve um erro ao fazer o upload do seu arquivo.";
                }
            }
        } else {
            $image_err = "O arquivo não é uma imagem.";
        }
    } else {
        $image_path = ""; 
    }

    if (empty($name_err) && empty($image_err)) {
        
        $sql = "INSERT INTO services (name, description, price_range, image_path) VALUES (?, ?, ?, ?)";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssss", $param_name, $param_description, $param_price_range, $param_image_path);
            
            $param_name = $name;
            $param_description = $description;
            $param_price_range = $price_range;
            $param_image_path = $image_path;

            if ($stmt->execute()) {
                $_SESSION['status_message'] = "Serviço adicionado com sucesso!";
                header("location: " . BASE_URL . "admin/servicos_list.php");
                exit();
            } else {
                echo "Ops! Algo deu errado ao inserir o serviço. Por favor, tente novamente mais tarde.";
            }
            $stmt->close();
        }
    }
}
?>

        <section class="page-section">
            <div class="container">
                <h2 class="section-heading text-center">Adicionar Novo Serviço</h2>
                <hr style="width: 100px; border-top: 3px solid #F26B1D; margin: 1rem auto 3rem auto;">

                <div class="form-section">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
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
                            <label>Faixa de Preço (ex: "R$ 500-1000" ou "Sob Consulta")</label>
                            <input type="text" name="price_range" class="form-control <?php echo (!empty($price_range_err)) ? 'is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($price_range); ?>">
                            <span class="invalid-feedback"><?php echo $price_range_err; ?></span>
                        </div>
                        <div class="form-group mt-3">
                            <label>Imagem do Serviço</label>
                            <input type="file" name="image" class="form-control <?php echo (!empty($image_err)) ? 'is-invalid' : ''; ?>">
                            <span class="invalid-feedback"><?php echo $image_err; ?></span>
                        </div>
                        <div class="form-group text-center mt-4">
                            <input type="submit" class="btn btn-primary" value="Adicionar Serviço" style="background-color: #F26B1D; border-color: #F26B1D;">
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
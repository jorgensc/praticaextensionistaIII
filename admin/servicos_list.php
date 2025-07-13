<?php
include_once '../config.php';
redirect_if_not_admin();

$pageTitle = "Gerenciar Serviços";
include '../header.php';

$status_message = '';
if (isset($_SESSION['status_message'])) {
    $status_message = $_SESSION['status_message'];
    unset($_SESSION['status_message']);
}

$sql = "SELECT id, name, description, price_range, image_path FROM services ORDER BY name ASC";
$result = $conn->query($sql);

?>

        <section class="page-section">
            <div class="container">
                <h2 class="section-heading text-center">Gerenciar Serviços</h2>
                <hr style="width: 100px; border-top: 3px solid #F26B1D; margin: 1rem auto 3rem auto;">

                <?php if ($status_message): ?>
                    <div class="alert alert-info text-center"><?php echo $status_message; ?></div>
                <?php endif; ?>

                <div class="text-center mb-4">
                    <a href="<?php echo BASE_URL; ?>admin/servicos_add.php" class="btn btn-primary" style="background-color: #F26B1D; border-color: #F26B1D;">Adicionar Novo Serviço</a>
                    <a href="<?php echo BASE_URL; ?>admin/index.php" class="btn btn-secondary ms-2">Voltar ao Painel</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover bg-faded">
                        <thead class="table-dark" style="background-color: #1D1D1D !important; color: #F3F1EC;">
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th>Faixa de Preço</th>
                                <th>Imagem</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row["id"] . "</td>";
                                    echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                                    echo "<td>" . htmlspecialchars(substr($row["description"], 0, 100)) . "...</td>";
                                    echo "<td>" . htmlspecialchars($row["price_range"]) . "</td>";
                                    echo "<td>";
                                    if (!empty($row["image_path"]) && file_exists('../' . $row["image_path"])) {
                                        echo "<img src='" . BASE_URL . htmlspecialchars($row["image_path"]) . "' alt='" . htmlspecialchars($row["name"]) . "' style='width: 80px; height: 60px; object-fit: cover;'>";
                                    } else {
                                        echo "N/A";
                                    }
                                    echo "</td>";
                                    echo "<td>";
                                    echo "<a href='" . BASE_URL . "admin/servicos_edit.php?id=" . $row["id"] . "' class='btn btn-sm btn-info me-2'><i class='fas fa-edit'></i> Editar</a>";
                                    echo "<a href='" . BASE_URL . "admin/servicos_delete.php?id=" . $row["id"] . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Tem certeza que deseja excluir este serviço?\")'><i class='fas fa-trash'></i> Excluir</a>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center'>Nenhum serviço cadastrado ainda.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

<?php
$conn->close();
include '../footer.php';
?>
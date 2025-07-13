<?php
include_once 'config.php';

$pageTitle = "Clientes";
include 'header.php';

$sql = "SELECT name, description, image_path FROM clients ORDER BY name ASC";
$result = $conn->query($sql);

?>

        <section class="page-section">
            <div class="container">
                <h2 class="section-heading text-center">Casos de Sucesso</h2>
                <hr style="width: 100px; border-top: 3px solid #F26B1D; margin: 1rem auto 3rem auto;">
                <div class="intro-text text-center">
                    <p>Temos orgulho de cada projeto que realizamos. Veja alguns dos trabalhos que fizemos e o que nossos clientes dizem sobre a Coloratto Tintas.</p>
                </div>

                <div class="row">
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo '<div class="col-lg-6 mb-4">';
                            echo '  <div class="client-card d-flex flex-column flex-md-row align-items-center">';
                            if (!empty($row["image_path"]) && file_exists('./' . $row["image_path"])) {
                                echo '    <img src="' . BASE_URL . htmlspecialchars($row["image_path"]) . '" alt="' . htmlspecialchars($row["name"]) . '" class="img-fluid me-md-4 mb-3 mb-md-0" style="max-width: 250px; height: 180px; object-fit: cover;">';
                            } else {
                                echo '    <img src="https://via.placeholder.com/250x180/CCCCCC/FFFFFF?text=Cliente" alt="Imagem Padrão Cliente" class="img-fluid me-md-4 mb-3 mb-md-0" style="max-width: 250px; height: 180px; object-fit: cover;">';
                            }
                            echo '    <div class="text-center text-md-start">';
                            echo '      <h3>' . htmlspecialchars($row["name"]) . '</h3>';
                            echo '      <p class="mb-0">' . htmlspecialchars($row["description"]) . '</p>';
                            echo '    </div>';
                            echo '  </div>';
                            echo '</div>';
                        }
                    } else {
                        echo "<div class='col-12 text-center'><p>Nenhum cliente/projeto cadastrado ainda.</p></div>";
                    }
                    ?>
                </div>
            </div>
        </section>

<?php
$conn->close();
include 'footer.php';
?>
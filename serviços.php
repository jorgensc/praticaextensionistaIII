<?php
include_once 'config.php';

$pageTitle = "Nossos Serviços";
include 'header.php';

$sql = "SELECT name, description, price_range, image_path FROM services ORDER BY name ASC";
$result = $conn->query($sql);

?>

        <section class="page-section">
            <div class="container">
                <h2 class="section-heading text-center">O Que Fazemos</h2>
                <hr style="width: 100px; border-top: 3px solid #F26B1D; margin: 1rem auto 3rem auto;">
                <div class="intro-text text-center">
                    <p>Oferecemos uma ampla gama de serviços de pintura e acabamento, adaptados às suas necessidades. Nossa equipe está pronta para entregar resultados que superam suas expectativas.</p>
                </div>

                <div class="row">
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo '<div class="col-lg-4 col-md-6 mb-4">';
                            echo '  <div class="service-box">';
                            if (!empty($row["image_path"]) && file_exists('./' . $row["image_path"])) {
                                echo '    <img src="' . BASE_URL . htmlspecialchars($row["image_path"]) . '" alt="' . htmlspecialchars($row["name"]) . '" class="img-fluid">';
                            } else {
                                echo '    <img src="https://via.placeholder.com/400x200/CCCCCC/FFFFFF?text=Serviço+Coloratto" alt="Imagem Padrão" class="img-fluid">';
                            }
                            echo '    <h3>' . htmlspecialchars($row["name"]) . '</h3>';
                            echo '    <p>' . htmlspecialchars($row["description"]) . '</p>';
                            echo '    <p class="text-primary fw-bold">' . htmlspecialchars($row["price_range"]) . '</p>';
                            echo '    <a href="' . BASE_URL . 'orçamentos.php" class="btn btn-primary btn-sm">Solicitar Orçamento</a>';
                            echo '  </div>';
                            echo '</div>';
                        }
                    } else {
                        echo "<div class='col-12 text-center'><p>Nenhum serviço disponível no momento.</p></div>";
                    }
                    ?>
                </div>
            </div>
        </section>

<?php
$conn->close();
include 'footer.php';
?>
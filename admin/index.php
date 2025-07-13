<?php
include_once '../config.php';

redirect_if_not_admin();

$pageTitle = "Painel Admin";
include '../header.php';
?>

        <section class="page-section">
            <div class="container">
                <h2 class="section-heading text-center">Bem-vindo ao Painel Administrativo, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h2>
                <hr style="width: 100px; border-top: 3px solid #F26B1D; margin: 1rem auto 3rem auto;">

                <div class="row">
                    <div class="col-lg-10 mx-auto">
                        <div class="bg-faded rounded p-5 text-center">
                            <p class="mb-4">Aqui você pode gerenciar os dados do seu site Coloratto Tintas.</p>
                            <div class="list-group">
                                <a href="<?php echo BASE_URL; ?>admin/servicos_list.php" class="list-group-item list-group-item-action">Gerenciar Serviços (CRUD)</a>
                                <a href="<?php echo BASE_URL; ?>admin/relatorio_orcamentos.php" class="list-group-item list-group-item-action">Ver Solicitações de Orçamento (Relatório)</a>
                                <a href="<?php echo BASE_URL; ?>logout.php" class="list-group-item list-group-item-action text-danger mt-3">Sair</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

<?php
include '../footer.php';
?>
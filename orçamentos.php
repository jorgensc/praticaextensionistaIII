<?php
$pageTitle = "Solicitar Orçamento";
include 'header.php';

$status_message = '';
$status_class = ''; 

if (isset($_GET['status'])) {
    if ($_GET['status'] == 'success') {
        $status_message = "Sua solicitação de orçamento foi enviada com sucesso! Em breve entraremos em contato.";
        $status_class = 'alert-success';
    } elseif ($_GET['status'] == 'error') {
        $status_message = "Houve um erro ao enviar sua solicitação de orçamento. Por favor, tente novamente.";
        $status_class = 'alert-danger';
    }
}

$full_name = $_SESSION['old_input']['full_name'] ?? '';
$email = $_SESSION['old_input']['email'] ?? '';
$phone = $_SESSION['old_input']['phone'] ?? '';
$message = $_SESSION['old_input']['message'] ?? '';
$service_type = $_SESSION['old_input']['service_type'] ?? '';

unset($_SESSION['old_input']);

?>

        <section class="page-section">
            <div class="container">
                <h2 class="section-heading text-center">Solicite Seu Orçamento</h2>
                <hr style="width: 100px; border-top: 3px solid #F26B1D; margin: 1rem auto 3rem auto;">
                <div class="intro-text text-center">
                    <p>Preencha o formulário abaixo e nossa equipe entrará em contato para entender suas necessidades e oferecer a melhor solução em pintura para você.</p>
                </div>

                <div class="form-section">
                    <?php if ($status_message): ?>
                        <div class="alert <?php echo $status_class; ?> text-center" role="alert">
                            <?php echo $status_message; ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo BASE_URL; ?>processa_orcamento.php" method="post">
                        <div class="form-group mb-3">
                            <label for="full_name">Nome Completo</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo htmlspecialchars($full_name); ?>" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="phone">Telefone (opcional)</label>
                            <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label for="service_type">Tipo de Serviço Desejado</label>
                            <select class="form-control" id="service_type" name="service_type" required>
                                <option value="">Selecione um serviço</option>
                                <option value="Pintura Interna" <?php echo ($service_type == 'Pintura Interna' ? 'selected' : ''); ?>>Pintura Interna</option>
                                <option value="Pintura Externa" <?php echo ($service_type == 'Pintura Externa' ? 'selected' : ''); ?>>Pintura Externa</option>
                                <option value="Restauração de Fachadas" <?php echo ($service_type == 'Restauração de Fachadas' ? 'selected' : ''); ?>>Restauração de Fachadas</option>
                                <option value="Pintura de Grades e Portões" <?php echo ($service_type == 'Pintura de Grades e Portões' ? 'selected' : ''); ?>>Pintura de Grades e Portões</option>
                                <option value="Texturas e Efeitos" <?php echo ($service_type == 'Texturas e Efeitos' ? 'selected' : ''); ?>>Texturas e Efeitos</option>
                                <option value="Pintura Comercial" <?php echo ($service_type == 'Pintura Comercial' ? 'selected' : ''); ?>>Pintura Comercial</option>
                                <option value="Outros" <?php echo ($service_type == 'Outros' ? 'selected' : ''); ?>>Outros</option>
                            </select>
                        </div>
                        <div class="form-group mb-4">
                            <label for="message">Mensagem / Detalhes do Projeto</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required><?php echo htmlspecialchars($message); ?></textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">Enviar Solicitação</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

<?php include 'footer.php'; ?>
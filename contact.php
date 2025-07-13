<?php
$pageTitle = "Contato";
include 'header.php';

$status_message = '';
$status_class = '';

if (isset($_GET['status'])) {
    if ($_GET['status'] == 'success') {
        $status_message = "Sua mensagem foi enviada com sucesso! Em breve entraremos em contato.";
        $status_class = 'alert-success';
    } elseif ($_GET['status'] == 'error') {
        $status_message = "Houve um erro ao enviar sua mensagem. Por favor, tente novamente.";
        $status_class = 'alert-danger';
    }
}


$name = $_SESSION['old_input']['name'] ?? '';
$email = $_SESSION['old_input']['email'] ?? '';
$subject = $_SESSION['old_input']['subject'] ?? '';
$message = $_SESSION['old_input']['message'] ?? '';

unset($_SESSION['old_input']);

?>

        <section class="page-section">
            <div class="container">
                <h2 class="section-heading text-center">Fale Conosco</h2>
                <hr style="width: 100px; border-top: 3px solid #F26B1D; margin: 1rem auto 3rem auto;">
                <div class="intro-text text-center">
                    <p>Tem alguma dúvida, sugestão ou precisa de informações adicionais? Entre em contato conosco!</p>
                </div>

                <div class="form-section">
                    <?php if ($status_message): ?>
                        <div class="alert <?php echo $status_class; ?> text-center" role="alert">
                            <?php echo $status_message; ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo BASE_URL; ?>contato_process.php" method="post">
                        <div class="form-group mb-3">
                            <label for="name">Seu Nome</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email">Seu Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="subject">Assunto</label>
                            <input type="text" class="form-control" id="subject" name="subject" value="<?php echo htmlspecialchars($subject); ?>">
                        </div>
                        <div class="form-group mb-4">
                            <label for="message">Sua Mensagem</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required><?php echo htmlspecialchars($message); ?></textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">Enviar Mensagem</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

<?php include 'footer.php'; ?>
<?php
include_once 'config.php'; 

$pageTitle = "Cadastro";

if (is_logged_in()) {
    header("location: " . BASE_URL . "dashboard.php");
    exit;
}

$username = $email = ""; 
$password = $confirm_password = ""; 

$username_err = $email_err = $password_err = $confirm_password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $password = trim($_POST["password"] ?? '');
    $confirm_password = trim($_POST["confirm_password"] ?? '');

    if (empty($username)) {
        $username_err = "Por favor, insira um nome de usuário.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        $username_err = "O nome de usuário pode conter apenas letras, números e underscores.";
    } else {
        $sql = "SELECT id FROM users WHERE username = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $param_username);
            $param_username = $username;
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows == 1) {
                    $username_err = "Este nome de usuário já está em uso.";
                }
            } else {
                echo "Ops! Algo deu errado na verificação do nome de usuário. Por favor, tente novamente mais tarde.";
            }
            $stmt->close();
        }
    }
//email
    if (empty($email)) {
        $email_err = "Por favor, insira um email.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_err = "Formato de email inválido.";
    } else {
        $sql = "SELECT id FROM users WHERE email = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $param_email);
            $param_email = $email;
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows == 1) {
                    $email_err = "Este email já está cadastrado.";
                }
            } else {
                echo "Ops! Algo deu errado na verificação do email. Por favor, tente novamente mais tarde.";
            }
            $stmt->close();
        }
    }
//senha
    if (empty($password)) {
        $password_err = "Por favor, insira uma senha.";
    } elseif (strlen($password) < 6) {
        $password_err = "A senha deve ter pelo menos 6 caracteres.";
    }

    if (empty($confirm_password)) {
        $confirm_password_err = "Por favor, confirme a senha.";
    } else {
        if (empty($password_err) && ($password !== $confirm_password)) {
            $confirm_password_err = "As senhas não coincidem.";
        }
    }

//Sem erros, tenta inserir o usuário
    if (empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
        
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sss", $param_username, $param_email, $param_password);
            
            $param_username = $username;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); //criptografa a senha

            if ($stmt->execute()) {
                //sucesso
                header("location: " . BASE_URL . "login.php?registered=true");
                exit();
            } else {
                echo "Ops! Algo deu errado ao registrar o usuário. Por favor, tente novamente mais tarde.";
            }
            $stmt->close();
        }
    }
}

include 'header.php'; 
?>

        <section class="page-section">
            <div class="container">
                <h2 class="section-heading text-center">Cadastro de Usuário</h2>
                <hr style="width: 100px; border-top: 3px solid #F26B1D; margin: 1rem auto 3rem auto;">

                <div class="form-section" style="max-width: 500px;">
                    <?php 
                    if (isset($_GET['registered']) && $_GET['registered'] == 'true') {
                        echo '<div class="alert alert-success text-center">Cadastro realizado com sucesso! Faça login agora.</div>';
                    }
                    ?>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group mb-3">
                            <label>Nome de Usuário</label>
                            <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($username); ?>" required>
                            <span class="invalid-feedback"><?php echo $username_err; ?></span>
                        </div>
                        <div class="form-group mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($email); ?>" required>
                            <span class="invalid-feedback"><?php echo $email_err; ?></span>
                        </div>
                        <div class="form-group mb-3">
                            <label>Senha</label>
                            <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" required>
                            <span class="invalid-feedback"><?php echo $password_err; ?></span>
                        </div>
                        <div class="form-group mb-4">
                            <label>Confirmar Senha</label>
                            <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" required>
                            <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                        </div>
                        <div class="form-group text-center mt-4">
                            <input type="submit" class="btn btn-primary" value="Cadastrar">
                        </div>
                        <p class="text-center mt-3">Já tem uma conta? <a href="<?php echo BASE_URL; ?>login.php">Faça login aqui</a>.</p>
                    </form>
                </div>
            </div>
        </section>

<?php
$conn->close();
include '../footer.php';
?>
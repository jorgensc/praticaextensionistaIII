<?php
include_once 'config.php'; 

$pageTitle = "Login";

if (is_logged_in()) {
    header("location: " . BASE_URL . "dashboard.php");
    exit;
}

$username = $password = "";
$username_err = $password_err = $login_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"] ?? ''); 

    //Validação do nome
    if (empty($username)) {
        $username_err = "Por favor, insira o nome de usuário.";
    }

    //Validação da senha
    if (empty(trim($_POST["password"]))) {
        $password_err = "Por favor, insira sua senha.";
    } else {
        $password = trim($_POST["password"]);
    }

    //Autentica
    if (empty($username_err) && empty($password_err)) {
        $sql = "SELECT id, username, password, role FROM users WHERE username = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $param_username);
            $param_username = $username;

            if ($stmt->execute()) {
                $stmt->store_result();

                //Verifica se existe
                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($id, $username_db, $hashed_password, $role);
                    if ($stmt->fetch()) {
                        //Verifica a senha
                        if (password_verify($password, $hashed_password)) {
                            // Inicia
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username_db;
                            $_SESSION["role"] = $role;

                            header("location: " . BASE_URL . "dashboard.php");
                            exit();
                        } else {
                            //Senha incorreta
                            $login_err = "Nome de usuário ou senha inválidos.";
                        }
                    }
                } else {
                    //Usuário não encontrado
                    $login_err = "Nome de usuário ou senha inválidos.";
                }
            } else {
                echo "Ops! Algo deu errado ao tentar fazer login. Por favor, tente novamente mais tarde.";
            }
            $stmt->close();
        }
    }
}

include 'header.php';
?>

        <section class="page-section">
            <div class="container">
                <h2 class="section-heading text-center">Acesso Restrito</h2>
                <hr style="width: 100px; border-top: 3px solid #F26B1D; margin: 1rem auto 3rem auto;">

                <div class="form-section" style="max-width: 500px;">
                    <?php
                    //erro
                    if(!empty($login_err)){
                        echo '<div class="alert alert-danger text-center">' . $login_err . '</div>';
                    }
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
                        <div class="form-group mb-4">
                            <label>Senha</label>
                            <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" required>
                            <span class="invalid-feedback"><?php echo $password_err; ?></span>
                        </div>
                        <div class="form-group text-center mt-4">
                            <input type="submit" class="btn btn-primary" value="Entrar">
                        </div>
                        <p class="text-center mt-3">Não tem uma conta? <a href="<?php echo BASE_URL; ?>register.php">Cadastre-se agora</a>.</p>
                    </form>
                </div>
            </div>
        </section>

<?php
$conn->close(); 
include '../footer.php'; 
?>
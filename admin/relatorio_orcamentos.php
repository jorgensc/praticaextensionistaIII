<?php
include_once '../config.php';
redirect_if_not_admin(); //admins

$pageTitle = "Relatório de Orçamentos";
include '../header.php';

$status_message = '';
if (isset($_SESSION['status_message'])) {
    $status_message = $_SESSION['status_message'];
    unset($_SESSION['status_message']);
}

$filter_status = $_GET['status'] ?? '';
$search_term = $_GET['search'] ?? '';

$sql = "SELECT id, full_name, email, phone, service_type, message, status, requested_at FROM budgets";
$where_clauses = [];
$params = [];
$param_types = '';

if (!empty($filter_status) && $filter_status != 'all') {
    $where_clauses[] = "status = ?";
    $params[] = $filter_status;
    $param_types .= 's';
}

if (!empty($search_term)) {
    $where_clauses[] = "(full_name LIKE ? OR email LIKE ? OR service_type LIKE ? OR message LIKE ?)";
    $search_param = '%' . $search_term . '%';
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $param_types .= 'ssss';
}

if (!empty($where_clauses)) {
    $sql .= " WHERE " . implode(" AND ", $where_clauses);
}

$sql .= " ORDER BY requested_at DESC";

$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($param_types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

?>

        <section class="page-section">
            <div class="container">
                <h2 class="section-heading text-center">Relatório de Solicitações de Orçamento</h2>
                <hr style="width: 100px; border-top: 3px solid #F26B1D; margin: 1rem auto 3rem auto;">

                <?php if ($status_message): ?>
                    <div class="alert alert-info text-center"><?php echo $status_message; ?></div>
                <?php endif; ?>

                <div class="text-center mb-4">
                    <a href="<?php echo BASE_URL; ?>admin/index.php" class="btn btn-secondary ms-2">Voltar ao Painel</a>
                </div>

                <div class="form-section mb-4 p-3 rounded" style="max-width: none;">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET" class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label for="search" class="form-label">Pesquisar por Nome/Email/Serviço:</label>
                            <input type="text" class="form-control" id="search" name="search" value="<?php echo htmlspecialchars($search_term); ?>" placeholder="Termo de pesquisa">
                        </div>
                        <div class="col-md-4">
                            <label for="status" class="form-label">Filtrar por Status:</label>
                            <select class="form-select" id="status" name="status">
                                <option value="all" <?php echo ($filter_status == 'all' ? 'selected' : ''); ?>>Todos</option>
                                <option value="pending" <?php echo ($filter_status == 'pending' ? 'selected' : ''); ?>>Pendente</option>
                                <option value="contacted" <?php echo ($filter_status == 'contacted' ? 'selected' : ''); ?>>Contactado</option>
                                <option value="approved" <?php echo ($filter_status == 'approved' ? 'selected' : ''); ?>>Aprovado</option>
                                <option value="rejected" <?php echo ($filter_status == 'rejected' ? 'selected' : ''); ?>>Rejeitado</option>
                            </select>
                        </div>
                        <div class="col-md-auto">
                            <button type="submit" class="btn btn-primary">Aplicar Filtro</button>
                            <a href="<?php echo BASE_URL; ?>admin/relatorio_orcamentos.php" class="btn btn-secondary ms-2">Limpar Filtros</a>
                        </div>
                    </form>
                </div>


                <div class="table-responsive">
                    <table class="table table-bordered table-hover bg-faded">
                        <thead class="table-dark" style="background-color: #1D1D1D !important; color: #F3F1EC;">
                            <tr>
                                <th>ID</th>
                                <th>Nome Completo</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>Tipo de Serviço</th>
                                <th>Mensagem</th>
                                <th>Status</th>
                                <th>Data/Hora Solicitação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row["id"] . "</td>";
                                    echo "<td>" . htmlspecialchars($row["full_name"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["phone"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["service_type"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["message"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["status"]) . "</td>";
                                    echo "<td>" . date("d/m/Y H:i", strtotime($row["requested_at"])) . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='8' class='text-center'>Nenhuma solicitação de orçamento encontrada.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

<?php
$stmt->close();
$conn->close();
include '../footer.php';
?>
<?php
session_start();
require_once "config/database.php";

$id_usuario = $_SESSION['cod_usuario'];
if (!isset($id_usuario)) {
    echo "<script>window.location.href = 'login.php'</script>";
    die();
} else if ($_SESSION['perfil'] != 'gestor') {
    echo "<script>window.location.href = 'dashboard.php'</script>";
    die();
}

function deletarAtividade($conn, $atividadeId) {
    $sql = "DELETE FROM atividades_extras WHERE cod_atividade = $atividadeId";
    return $conn->query($sql) === TRUE;
}

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $atividadeId = $_GET['delete'];
    $exclusaoSucesso = deletarAtividade($conn, $atividadeId);
    // Redirecionar após exclusão para evitar reenvio do formulário
    header("Location: ./listar_atividades.php");
    exit;
}

$registros_por_pagina = 5;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $registros_por_pagina;

if ($_SESSION['perfil'] == 'gestor') {
    $sql = "SELECT * FROM atividades_extras ORDER BY cod_atividade DESC LIMIT $offset, $registros_por_pagina";
    $total_sql = "SELECT COUNT(*) AS total FROM atividades_extras";
} else {
    $sql = "SELECT * FROM atividades_extras WHERE cod_usuario = '$id_usuario' ORDER BY cod_atividade DESC LIMIT $offset, $registros_por_pagina";
    $total_sql = "SELECT COUNT(*) AS total FROM atividades_extras WHERE cod_usuario = '$id_usuario'";
}

$result = $conn->query($sql);
$total_result = $conn->query($total_sql);
$total_rows = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $registros_por_pagina);

// Notificação de exclusão bem-sucedida
$toastMessage = isset($exclusaoSucesso) && $exclusaoSucesso ? 'Atividade excluída com sucesso.' : '';
?>

<?php include './header.php'; ?>

<?php if ($toastMessage) : ?>
    <div class="container mt-4">
        <div class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true" style="position: absolute; top: 60px; right: 20px;">
            <div class="d-flex">
                <div class="toast-body">
                    <?php echo $toastMessage; ?>
                </div>
                <button type="button" class="btn-close me-2 m-auto p-2" data-bs-dismiss="toast" aria-label="Fechar"></button>
            </div>
        </div>
    </div>
<?php endif; ?>

<style>
    td:nth-child(1), td:nth-child(6) {
        white-space: nowrap;
    }
    .toast-container {
        position: fixed;
        margin-top: 50px;
        top: 20px;
        right: 20px;
        z-index: 1050;
    }
</style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Cursos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <style>
        .fade-out {
            opacity: 1;
            transition: opacity 0.5s ease-out;
        }
        .fade-out.hide {
            opacity: 0;
        }
    </style>
</head>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card-header col d-flex justify-content-between pb-3 pt-4">
                <h4>Listagem de Atividades Extras</h4>
                <a href="./form_atividade.php" class="btn btn-success">Cadastrar Atividade</a>
            </div>

            <?php if ($result->num_rows > 0) : ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Início</th>
                                <th>Término</th>
                                <th>Horas</th>
                                <th>Atividade</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()) : ?>
                                <tr>
                                    <td><?php echo date('d/m/Y', strtotime($row['data'])); ?></td>
                                    <td><?php echo $row['carga_inicial']; ?></td>
                                    <td><?php echo $row['carga_final']; ?></td>
                                    <td><?php echo $row['horas']; ?></td>
                                    <td><?php echo $row['atividade']; ?></td>
                                    <td>
                                        <a href="./atualizar_atividade.php?id=<?php echo $row['cod_atividade']; ?>" class="btn"><i class="bi bi-pencil-square"></i></a>

                                        <!-- Modal de exclusão -->
                                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $row['cod_atividade']; ?>">
                                        <i class="bi bi-trash3-fill"></i>
                                        </button>

                                        <!-- Modal de confirmação de exclusão -->
                                        <div class="modal fade" id="deleteModal<?php echo $row['cod_atividade']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?php echo $row['cod_atividade']; ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel<?php echo $row['cod_atividade']; ?>">Excluir Atividade Extra</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Tem certeza que deseja excluir a atividade extra do dia <?php echo date('d/m/Y', strtotime($row['data'])); ?>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                        <a href="./list_atividades.php?delete=<?php echo $row['cod_atividade']; ?>" class="btn btn-danger">Excluir</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Paginação -->
                <nav aria-label="Paginação">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                            <a class="page-link" href="<?php echo $page <= 1 ? '#' : './list_atividades.php?page=' . ($page - 1); ?>" tabindex="-1" aria-disabled="true">Anterior</a>
                        </li>
                        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                            <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                                <a class="page-link" href="./list_atividades.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : ''; ?>">
                            <a class="page-link" href="<?php echo $page >= $total_pages ? '#' : './list_atividades.php?page=' . ($page + 1); ?>">Próximo</a>
                        </li>
                    </ul>
                </nav>

            <?php else : ?>
                <div class="alert alert-warning text-center" role="alert">
                    Nenhuma atividade encontrada.
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

</div>
<?php include './footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php if (!empty($toastMessage)) : ?>
            var toastElement = document.querySelector('.toast');
            if (toastElement) {
                var toast = new bootstrap.Toast(toastElement);
                toast.show();
            }
        <?php endif; ?>
    });
</script>
<script>
    window.onload = () => {
        const container = document.querySelector('.container');
        container.style.height === '' ? container.style.height = `${height+51}px` : null;
    };
</script>

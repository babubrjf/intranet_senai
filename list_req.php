<!-- /pages/list_activities.php -->
<?php
session_start();
require_once "config/database.php";

$id_usuario = $_SESSION['cod_usuario'];
if (!isset($id_usuario)) {
    echo "<script>window.location.href = 'login.php'</script>";
    die();
}

$registros_por_pagina = 5;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $registros_por_pagina;

$sql = "SELECT * FROM solicitacao WHERE colaborador_cod_usuario = '$id_usuario' ORDER BY cod_sol DESC LIMIT $offset, $registros_por_pagina";
$result = $conn->query($sql);

$total_sql = "SELECT COUNT(*) AS total FROM solicitacao WHERE colaborador_cod_usuario = '$id_usuario'";
$total_result = $conn->query($total_sql);
$total_rows = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $registros_por_pagina);
?>

<?php include './header.php'; ?>

<head>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<style>
    td:nth-child(1){
        white-space: nowrap;
    }
    td:nth-child(6){
        white-space: nowrap;
    }
</style>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card-header col d-flex justify-content-between pb-3 pt-4">
                <h4>Listagem de Solicitações de Compensação de Horas</h4>
                <a href="./create_comp.php" class="btn btn-primary">Solicitar Nova Compensação</a>
            </div>
            
            <?php if ($result->num_rows > 0) : ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Código da Solicitação</th>
                                <th>Data da Solicitação</th>
                                <th>Inicio da Compensação</th>
                                <th>Final da Compensação</th>
                                <th>Turno</th>
                                <th>Horas</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()) : ?>
                                <tr>
                                    <td><center><?php echo $row['cod_sol']; ?></td>
                                    <td><center><?php echo date('d/m/Y', strtotime($row['date_sol'])); ?></center></td>
                                    <td><center><?php echo date('d/m/Y', strtotime($row['inicio_comp'])); ?></center></td>
                                    <td><center><?php echo date('d/m/Y', strtotime($row['final_comp'])); ?></center></td>
                                    <td><center><?php echo $row['turno']; ?></center></td>
                                    <td><center><?php echo $row['horas']; ?></center></td>

                                    <td>
                                        <center>
                                            <a href="edit_req.php?id=<?php echo $row['cod_sol']; ?>" class="btn"><i class='bx bxs-edit'></i></a>
                                            <button class="btn" data-toggle="modal" data-target="#deleteModal<?php echo $row['cod_sol'];?>"><i class='bx bx-trash'></i></button>
                                        </center>

                                        <div class="modal fade" id="deleteModal<?php echo $row['cod_sol']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel<?php echo $row['cod_sol']; ?>" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel<?php echo $row['cod_sol']; ?>">Excluir Solicitação de Compensação de Horas</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Tem certeza que deseja excluir a Solicitação de Compensação do dia <?php echo date('d/m/Y', strtotime($row['date_sol'])); ?>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                        <a href="./delete_sol.php?id=<?php echo $row['cod_sol']; ?>" class="btn btn-danger">Excluir</a>
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
                            <a class="page-link" href="<?php echo $page <= 1 ? '#' : './list_req.php?page=' . ($page - 1); ?>" tabindex="-1" aria-disabled="true">Anterior</a>
                        </li>
                        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                            <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                                <a class="page-link" href="./list_req.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : ''; ?>">
                            <a class="page-link" href="<?php echo $page >= $total_pages ? '#' : './list_req.php?page=' . ($page + 1); ?>">Próximo</a>
                        </li>
                    </ul>
                </nav>

            <?php else : ?>
                <div class="alert alert-warning text-center" role="alert">
                    Nenhuma solicitação de compensação de horas encontrada.
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

</div>
<?php include './footer.php'; ?>

<script>
    // Script para abrir o modal de exclusão
    function confirmDelete(activityId) {
        $('#deleteModal' + activityId).modal('show');
    }
</script>

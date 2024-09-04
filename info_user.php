<!-- /pages/list_users.php -->
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

@$cod_user = $_GET["cod_user"];

$sql = "SELECT * FROM usuarios WHERE cod_usuario = '$cod_user'";
$result = $conn->query($sql);

$registros_por_pagina = 5;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $registros_por_pagina;

?>

<?php include './header.php'; ?>

<style>
    td:nth-child(1) {
        white-space: nowrap;
    }

    td:nth-child(6) {
        white-space: nowrap;
    }
</style>

<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="card mt-5">
            <div class="card-header">
                <div class="container d-flex justify-content-between">
                    <h4>Dados do colaborador</h4>
                    <a href="JavaScript: window.history.back();" class='btn btn-secondary btn-sm'>Voltar</a>
                </div>
            </div>
            <div class="card-body d-flex justify-content-between m-1">
                <div class="container">
                    <?php $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $gest = $row['gestor_cod_usuario'] ?>
                            <div class="d-flex justify-content-between p-3">
                                <div class="col">
                                    <h6>NOME</h6>
                                    <span class="border-top p-1">
                                        <?php echo $row['nome']; ?>
                                    </span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between p-3">
                                <div class="col">
                                    <h6>CPF</h6>
                                    <span class="border-top p-1">
                                        <?php echo $row['cpf']; ?>
                                    </span>
                                </div>
                                <div class="col">
                                    <h6>MATRÍCULA</h6>
                                    <span class="border-top p-1">
                                        <?php echo $row['matricula']; ?>
                                    </span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between p-3">
                                <div class="col">
                                    <h6>DATA DE ADMISSÃO</h6>
                                    <span class="border-top p-1">
                                        <?php echo $row['data_admissao']; ?>
                                    </span>
                                </div>
                                <div class="col">
                                    <h6>GESTOR(A) RESPONSÁVEL</h6>
                                    <span class="border-top p-1">
                                        <?php
                                        $sql_gest = "SELECT nome FROM usuarios WHERE cod_usuario = $gest";
                                        $result_gest = $conn->query($sql_gest);
                                        if ($result_gest->num_rows > 0) {
                                            while ($row_gest = $result_gest->fetch_assoc()) {
                                                echo $row_gest['nome'];
                                            }
                                        } ?>
                                    </span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between p-3">
                                <div class="col">
                                    <h6>CELULAR</h6>
                                    <span class="border-top p-1">
                                        <?php echo $row['celular']; ?>
                                    </span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between p-3">
                                <div class="col">
                                    <h6>EMAIL</h6>
                                    <span class="border-top p-1">
                                        <?php echo $row['email']; ?>
                                    </span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between p-3">
                                <a href="edit_user.php?cod_user=<?php echo $row['cod_usuario']; ?>" class="btn btn-warning">Editar</a>
                                <a href="delete_user.php?cod_user=<?php echo $row['cod_usuario']; ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir <?php echo $row['nome']; ?>?')">Excluir</a>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>

            </div>
            <div class="accordion p-5" id="accordionExample">
                <div class="card-header border rounded-top border-bottom-0">
                    <h5>Solicitações de compensação de horas do colaborador</h5>
                </div>
                <?php $sql_sol = "SELECT * FROM solicitacao WHERE colaborador_cod_usuario = '$cod_user' LIMIT $offset, $registros_por_pagina";
                $result_sol = $conn->query($sql_sol);

                $total_sql = "SELECT COUNT(*) AS total FROM solicitacao WHERE colaborador_cod_usuario = '$cod_user'";
                $total_result = $conn->query($total_sql);
                $total_rows = $total_result->fetch_assoc()['total'];
                $total_pages = ceil($total_rows / $registros_por_pagina);

                if ($result_sol->num_rows > 0) :
                    while ($row_sol = $result_sol->fetch_assoc()) :
                        $cod = $row_sol['cod_sol'] ?>
                        <div class="card">
                            <div class="card-header" id="heading<?php echo $cod ?>">
                                <h5 class="mb-0">
                                    <button style="text-decoration: none" class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse<?php echo $cod ?>" aria-expanded="false" aria-controls="collapse<?php echo $cod ?>">
                                        <h6>Código da solicitação: <?php echo $cod ?> | Data da solicitação: <?php echo (new DateTime($row_sol['date_sol']))->format('d/m/Y'); ?></h6>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse<?php echo $cod ?>" class="collapse" aria-labelledby="heading<?php echo $cod ?>" data-parent="#accordionExample">
                                <div class="card-body d-flex justify-content-around" style="width: 100%">
                                    <div style="width: 100">
                                        <div class="row" style="width: 100%">
                                            <div class="col p-3">
                                                <h6>Data de início</h6>
                                                <span class="border-top p-1">
                                                    <?php echo (new DateTime($row_sol['inicio_comp']))->format('d/m/Y'); ?>
                                                </span>
                                            </div>
                                            <div class="col p-3">
                                                <h6>Data de término</h6>
                                                <span class="border-top p-1">
                                                    <?php echo (new DateTime($row_sol['final_comp']))->format('d/m/Y'); ?>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row" style="width: 100%">
                                            <div class="col p-3">
                                                <h6>Turno(s)</h6>
                                                <span class="border-top p-1">
                                                    <?php echo $row_sol['turno']; ?>
                                                </span>
                                            </div>
                                            <div class="col p-3">
                                                <h6>Horas:</h6>
                                                <span class="border-top p-1">
                                                    <?php echo $row_sol['horas']; ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                    endwhile;
                        ?>
                        <nav aria-label="Paginação">
                            <ul class="pagination justify-content-center p-3">
                                <?php $url = "./info_user.php?cod_user=$cod_user" ?>
                                <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="<?php echo $page <= 1 ? '#' : $url ?>&page=<?php ($page - 1); ?>" tabindex="-1" aria-disabled="true">Anterior</a>
                                </li>
                                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                                    <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                                        <a class="page-link" href="<?php echo $url ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>
                                <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="<?php echo $page >= $total_pages ? '#' : $url ?>&page=<?php ($page + 1); ?>">Próximo</a>
                                </li>
                            </ul>
                        </nav><?php else:
                                echo " <span class='p-5 '>Esse colaborador não possui solicitações de compensação de horas registradas!</span>";
                            endif;
                                ?>
                        </div>


            </div>

        </div>


    </div>

</div>
</div>

</div>
</div>
</div>

</div>
<?php include './footer.php'; ?>
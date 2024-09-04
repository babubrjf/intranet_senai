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

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $gest_cod = $_POST["gest_cod"];
    if ($gest_cod !== "0") {
        header("Location: ./list_comp.php?gest_id=$gest_cod&page=1");
        exit();
    } else {
    }
}


$registros_por_pagina = 5;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $registros_por_pagina;
?>



<?php include './header.php'; ?>

<head>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

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
                <h4 class="card-title">Listagem de Solicitações de Compensação de Horas</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="list_comp_all.php">
                    <label class="form-label">Filtrar por gestor:</label>
                    <select class="form-select form-select-sm" style="width: 35vw;" aria-label="Small select example" name="gest_cod">
                        <option value="0">Todos os colaboradores</option>
                        <?php
                        $sql_gest = "SELECT * FROM usuarios WHERE perfil = 'gestor'";
                        $result_gest = $conn->query($sql_gest);
                        while ($row_gest = $result_gest->fetch_assoc()) {
                            $gest = $row_gest['cod_usuario'];
                            echo '<option value="' . $gest . '">Colaboradores de '  . $row_gest['nome'] . ' </option>';
                        } ?>
                    </select>
                    <?php echo "<td><button class='btn btn-info btn-sm' type='submit'>Filtrar</button> "; ?>
            </div>
            <div class="accordion p-5" id="accordionExample">
                <div class="card-header border rounded-top border-bottom-0">
                    <h5>Solicitações de compensação de horas</h5>
                </div>
                <?php
                $sql_sol = "SELECT * FROM solicitacao ORDER BY cod_sol DESC LIMIT $offset, $registros_por_pagina";
                $result_sol = $conn->query($sql_sol);

                $total_sql = "SELECT COUNT(*) AS total FROM solicitacao";
                $total_result = $conn->query($total_sql);
                $total_rows = $total_result->fetch_assoc()['total'];
                $total_pages = ceil($total_rows / $registros_por_pagina);
                if ($result_sol->num_rows > 0):
                    while ($row_sol = $result_sol->fetch_assoc()) :
                        $cod = $row_sol['cod_sol'];
                        $colab = $row_sol['colaborador_cod_usuario'];
                ?>
                        <div class="card">
                            <div class="card-header" id="heading<?php echo $cod ?>">
                                <h5 class="mb-0 d-flex justify-content-around align-items-center">
                                    <button style="text-decoration: none; text-align:left" class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse<?php echo $cod ?>" aria-expanded="false" aria-controls="collapse<?php echo $cod ?>">
                                        <?php $sql_col = "SELECT * FROM usuarios WHERE perfil = 'colaborador' AND cod_usuario = '$colab'";
                                        $result_col = $conn->query($sql_col);
                                        if ($result_col->num_rows > 0) {
                                            while ($row_col = $result_col->fetch_assoc()) {
                                                $nome = $row_col['nome'];
                                                @$cod_link = $cod;
                                                @$link = '<a href="info_user.php?cod_user=' . $colab . ' ">' . $nome . '</a>';
                                            }
                                        }
                                        ?>
                                        <h6>Solicitante:
                                            <?php echo $link;
                                            ?></h6>
                                        <h6 style="font-weight: normal">Código da solicitação: <?php echo $cod ?> | Data da solicitação: <?php echo (new DateTime($row_sol['date_sol']))->format('d/m/Y'); ?></h6>
                                    </button>
                                    <a href="delete_comp.php?cod_comp=<?php echo $cod; ?>" class="btn" onclick="return confirm('Tem certeza que deseja excluir a solicitação de <?php echo $nome; ?> aberta no dia <?php echo (new DateTime($row_sol['date_sol']))->format('d/m/Y'); ?>?')"><i class='bx bx-trash'></i></a>
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
                        </div>
                    <?php
                    endwhile;
                     ?>
            </div>
        </div>

        <nav aria-label="Paginação">
            <ul class="pagination justify-content-center p-3">
                <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                    <a class="page-link" href="<?php echo $page <= 1 ? '#' : 'list_comp_all.php?page=' . ($page - 1); ?>" tabindex="-1" aria-disabled="true">Anterior</a>
                </li>
                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                    <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                        <a class="page-link" href="list_comp_all.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : ''; ?>">
                    <a class="page-link" href="<?php echo $page >= $total_pages ? '#' : 'list_comp_all.php?page=' . ($page + 1); ?>">Próximo</a>
                </li>
            </ul>
        </nav> <?php else:
                    echo " <span class='p-5 '>Esse colaborador não possui solicitações de compensação de horas registradas!</span>"; 
            endif;
                ?>
                
    </div>
</div>
</div>
</div>

</div>

<?php include './footer.php'; ?>
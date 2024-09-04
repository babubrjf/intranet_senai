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
        header("Location: ./list_users.php?gest_id=$gest_cod");
        exit();
    } else {
    }
}

$registros_por_pagina = 5;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $registros_por_pagina;

$sql_col = "SELECT * FROM usuarios WHERE perfil = 'colaborador' ORDER BY nome LIMIT $offset, $registros_por_pagina";
$result_col = $conn->query($sql_col);

$total_sql = "SELECT COUNT(*) AS total FROM usuarios WHERE perfil = 'colaborador'";
$total_result = $conn->query($total_sql);
$total_rows = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $registros_por_pagina);



?>

<?php include './header.php'; ?>

<head>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="card mt-5">
            <div class="card-header">
                <h4 class="card-title">Listagem de Usuários</h2>
            </div>
            <div class="card-body">
                <form method="POST" action="list_users_all.php">
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
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_col->num_rows > 0) {
                        while ($row_col = $result_col->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo '<a href="info_user.php?cod_user=' . $row_col['cod_usuario'] . ' ">' . $row_col['nome'] . '</a>' ?></td>
                                <td>
                                    <center>
                                        <a href="edit_user.php?cod_user=<?php echo $row_col['cod_usuario']; ?>" class="btn"><i class='bx bxs-edit'></i></a>
                                        <a href="delete_user.php?cod_user=<?php echo $row_col['cod_usuario']; ?>" class="btn" onclick="return confirm('Tem certeza que deseja excluir <?php echo $row_col['nome']; ?>?')"><i class='bx bx-trash'></i></a>
                                    </center>
                                </td>
                            </tr>
                            <?php }
                            ?><?php
                            } ?>
                </tbody>
            </table>
            <nav aria-label="Paginação">
                <ul class="pagination justify-content-center p-3">
                    <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                        <a class="page-link" href="<?php echo $page <= 1 ? '#' : './list_users_all.php?page=' . ($page - 1); ?>" tabindex="-1" aria-disabled="true">Anterior</a>
                    </li>
                    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                        <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                            <a class="page-link" href="./list_users_all.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : ''; ?>">
                        <a class="page-link" href="<?php echo $page >= $total_pages ? '#' : './list_users_all.php?page=' . ($page + 1); ?>">Próximo</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
</div>

</div>

<?php include './footer.php'; ?>
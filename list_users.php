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

$registros_por_pagina = 5;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $registros_por_pagina;

@$gest = $_GET["gest_id"];

$id = $_SESSION['cod_usuario'];

$sql_gest = "SELECT * FROM usuarios WHERE cod_usuario = '$gest'";
$result_gest = $conn->query($sql_gest);

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
                <label for="gest">Filtrar por gestor:</label>
                <select disabled selected value class="form-select form-select-sm" style="width: 35vw;" aria-label="Small select example" name="gest">
                    <?php
                    while ($row_gest = $result_gest->fetch_assoc()) {
                        echo '<option value="' . $row_gest['cod_usuario'] . '" type="submit" disable>Colaboradores de '  . $row_gest['nome'] . ' </option>';
                        $gest = $row_gest['cod_usuario'];
                    } ?>
                </select>
                <a href='list_users_all.php' class='btn btn-secondary btn-sm'>Limpar seleção</a>
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
                    $sql_col = "SELECT * FROM usuarios WHERE gestor_cod_usuario = '$gest' AND perfil = 'colaborador' ORDER BY nome LIMIT $offset, $registros_por_pagina";
                    $total_sql = "SELECT COUNT(*) AS total FROM usuarios WHERE gestor_cod_usuario = '$gest' AND perfil = 'colaborador'";
                    $total_result = $conn->query($total_sql);
                    $total_rows = $total_result->fetch_assoc()['total'];
                    $total_pages = ceil($total_rows / $registros_por_pagina);
                    $result_col = $conn->query($sql_col);
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
                    } ?>
                </tbody>
            </table>
            <nav aria-label="Paginação">
                <ul class="pagination justify-content-center p-3">
                    <?php $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>
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
            </nav>
        </div>
    </div>
</div>
</div>

</div>

<?php include './footer.php'; ?>
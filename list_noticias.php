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
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $registros_por_pagina;

$search = isset($_GET['search']) ? trim($_GET['search']) : '';

$sql_noticias = "SELECT * FROM noticias";
$total_sql = "SELECT COUNT(*) AS total FROM noticias";

if ($_SESSION['perfil'] === 'colaborador') {
    $sql_noticias .= " WHERE id_usuario = $id_usuario";
    $total_sql .= " WHERE id_usuario = $id_usuario";
}

if (!empty($search)) {
    $search_query = " (titulo LIKE '%$search%' OR data LIKE '%$search%')";
    if ($_SESSION['perfil'] === 'colaborador') {
        $sql_noticias .= " AND $search_query";
        $total_sql .= " AND $search_query";
    } else {
        $sql_noticias .= " WHERE $search_query";
        $total_sql .= " WHERE $search_query";
    }
}

$sql_noticias .= " ORDER BY cod_noticia DESC LIMIT $offset, $registros_por_pagina";

$result_noticias = $conn->query($sql_noticias);
$total_result = $conn->query($total_sql);
$total_rows = $total_result ? $total_result->fetch_assoc()["total"] : 0;
$total_pages = ceil($total_rows / $registros_por_pagina);
?>
<?php

$status = 'publicar';

$status_label = ($status === 'publicar') ? 'Publicado' : 'Não publicado';
?>

<?php include './header.php'; ?>
<html lang="pt-br">
<head>
    <style>
        #searchInfo {
            color: #1f84d6;
            margin-left: 1%;
        }
        #searchInfo_content {
            color: black;
            display: none;
            background-color: #f9f9f9;
            position: absolute;
            width: 225px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            padding: 12px 16px;
            font-size: medium;
        }

        #searchInfo:hover #searchInfo_content {
            display: block;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <center>
            <?php if ($result_noticias->num_rows > 0) { ?>
                <h4>Notícias</h4>
                <a style="margin-bottom: 10px;" href="form_noticia.php" class="btn btn-primary btn-sm float-right" role="button" aria-disabled="true">Nova Notícia</a>
                <form method="GET" action="./list_noticias.php">
                        <div class="flex" style="display: flex;">
                            <label for="input-busca" style="font-size: 26px;">O que você procura?</label>
                            <div class="dropdown" id="searchInfo">
                                <i class="bi bi-info-circle" style="font-size: 26px;"></i>
                                <div class="dropdown-content" id="searchInfo_content">
                                    <p>Opções de Procura:</p><b>Título;</b> <br><b>Data;</b>
                                </div>
                            </div>
                        </div>
                        <input id="input-busca" type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" class="form-control mt-3 mb-3" placeholder="Digite o que procura :">
                    </form>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>
                                <center>Título</center>
                            </th>
                            <th>
                                <center>Data</center>
                            </th>
                            <th>
                                <center>Status</center>
                            </th>
                            <th>
                                <center>Ações</center>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $result_noticias->fetch_assoc()) { ?>
                        <tr>
                            <td>
                                <center><?php echo $row['titulo']; ?></center>
                            </td>
                            <td>
                                <center><?php echo $row['data']; ?></center>
                            </td>
                            <td>
                                <center><?php echo $row['status']; ?>
                                <br>
                                <form action="post"><a style="text-decoration: none;" href="update_not.php?id=<?php echo $row['cod_noticia']; ?>"><i class="bi bi-eye-fill"></i></a></form>
                            </td>
                            <td>
                                <center>
                                    <a href="./edit_not.php?id=<?php echo $row['cod_noticia']; ?>" class="btn" alt="Editar"><i class="bi bi-pencil-square"></i></a>
                                    <button class="btn" data-toggle="modal" data-target="#deleteModal<?php echo $row['cod_noticia']; ?>" alt="Excluir"><i class="bi bi-trash3-fill"></i></button>
                                </center>

                                <!-- Modal de Exclusão -->
                                <div class="modal fade" id="deleteModal<?php echo $row['cod_noticia']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel<?php echo $row['cod_noticia']; ?>" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"
                                                    id="deleteModalLabel<?php echo $row['cod_noticia']; ?>">Excluir Notícia</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">Tem certeza que deseja excluir a notícia "<?php echo $row['titulo']; ?>"?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                <a href="del_not.php?id=<?php echo $row['cod_noticia']; ?>" class="btn btn-danger">Excluir</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    <?php } else { ?>
                <?php 
                echo "<h4 style='text-align:center'>Nenhuma Notícia Encontrada!<br></h4>
                <a style='margin-bottom: 10px;' href='form_noticia.php' class='btn btn-primary btn-sm float-right' role='button' aria-disabled='true'>Nova Notícia</a>";
            } 
                ?>
                    </tbody>
                </table>
        </div>
        </center>
    </div>
    <div>
    <nav aria-label="Paginação">
        <ul class="pagination justify-content-center">
            <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?php echo $page <= 1 ? '#' : './list_noticias.php?page=' . ($page - 1) . '&search=' . urlencode($search); ?>" tabindex="-1" aria-disabled="true">Anterior</a>
            </li>
            <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                    <a class="page-link" href="./list_noticias.php?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?php echo $page >= $total_pages ? '#' : './list_noticias.php?page=' . ($page + 1) . '&search=' . urlencode($search); ?>">Próximo</a>
            </li>
        </ul>
    </nav>
</div>
</div>
</div>
<?php include './footer.php'; ?>
<script>
    window.onload = () => {document.querySelector('.container').style.height = `${height+117}px`};
</script>

<?php
session_start();
require_once "config/database.php";

$id_usuario = $_SESSION['cod_usuario'];
if (!isset($id_usuario)) {
    echo "<script>window.location.href = 'login.php'</script>";
    die();
}

$registros_por_pagina = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $registros_por_pagina;

if (!isset($id_usuario)) {
    header("Location: ./login.php");
    die();
}

$search = isset($_GET['search']) ? trim($_GET['search']) : '';

$sql = "SELECT * FROM ordem_servico";
$total_sql = "SELECT COUNT(*) AS total FROM ordem_servico";

if ($_SESSION['perfil'] === 'colaborador') {
    $sql .= " WHERE id_usuario = $id_usuario";
    $total_sql .= " WHERE id_usuario = $id_usuario";
}

if(!empty($search)){
    $search_query = " (id_os LIKE '%$search%' OR area LIKE '%$search%')";

    if($_SESSION['perfil'] === 'colaborador'){
        $sql .= " AND $search_query";
        $total_sql .= " AND $search_query";
    }else{
        $sql .= " WHERE $search_query";
        $total_sql .= " WHERE $search_query";
    }
}

$sql .= " ORDER BY id_os DESC LIMIT $offset, $registros_por_pagina";

$result = $conn->query($sql);
$total_result = $conn->query($total_sql);
$total_rows = $total_result->fetch_assoc()["total"];
$total_pages = ceil($total_rows / $registros_por_pagina);

?>

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal do Colaborador</title>
    <lang="pt-br">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="imgs/favicon.png" type="image/x-icon">
    <script src='http://code.jquery.com/jquery-2.1.3.min.js'></script>
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
<?php require_once './header.php'; ?>
<div class="container mt-5">
<div class="row justify-content-center">
    <div class="col-md-10">
                <?php if ($result->num_rows > 0) { 
                ?>
                    <h4>Listagem das Ordens de Serviço</h4>
                    <form method="GET" action="./listing.php">
                        <div class="flex" style="display: flex;">
                            <label for="input-busca" style="font-size: 26px;">O que você procura?</label>
                            <div class="dropdown" id="searchInfo">
                                <i class="bi bi-info-circle" style="font-size: 26px;"></i>
                                <div class="dropdown-content" id="searchInfo_content">
                                    <p>Opções de Procura:</p><b>Ordem;</b> <br><b>Área;</b>
                                </div>
                            </div>
                        </div>
                        <input id="input-busca" type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" class="form-control mt-3 mb-3" placeholder="Digite o que procura :">
                    </form>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="width: 5%;">Ordem</th>
                                <th style="width: 60%;">Área</th>
                                <th style="width: 10%;">Ações</th>
                            </tr>
                        </thead>
                    <tbody>
                    <?php
                        while($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['id_os']; ?></td>
                            <td><?php echo $row['area']; ?></td>
                            <td>
                                <div class="btns" style="display: flex; flex-direction: row">
                                    <button class="btn" data-toggle="modal" data-target="#viewModal<?php echo $row['id_os']; ?>" alt="Ver Mais"><i class="bi bi-plus-circle-fill"></i></button>
                                    <?php
                                        echo $row['upload'] !== null ? "<a href='".$row['upload']."' download class='btn'><i class='bi bi-file-earmark-arrow-down-fill'></i></a>" : null;
                                    ?>
                                    <a href="./edit_os.php?id=<?php echo $row['id_os']; ?>" class="btn" alt="Editar"><i class="bi bi-pencil-square"></i></a>
                                    <button class="btn" data-toggle="modal" data-target="#deleteModal<?php echo $row['id_os']; ?>" alt="Excluir"><i class="bi bi-trash3-fill"></i></button>
                                </div>
                                <!-- Modal de Visualização -->
                                <div class="modal fade" id="viewModal<?php echo $row['id_os']; ?>" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel<?php echo $row['id_os']; ?>" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="viewModalLabel<?php echo $row['id_os']; ?>">Visualizar Ordem de Serviço</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <label class="form-label" for="solicitante">Solicitante</label>
                                                <input class="form-control" type="text" id="solicitante" value="<?php echo $row['solicitante']; ?>" readonly>
                                                <label class="form-label" for="ambiente">Ambiente</label>
                                                <input class="form-control" type="text" id="ambiente" value="<?php echo $row['ambiente']; ?>" readonly>
                                                <label class="form-label" for="inconformidade">Inconformidade</label>
                                                <input class="form-control" type="text" id="inconformidade" value="<?php echo $row['inconformidade']; ?>" readonly>
                                                <label class="form-label" for="data_solicitacao">Data da Solicitação</label>
                                                <input class="form-control" type="text" id="data_solicitacao" value="<?php echo date("d/m/Y", strtotime($row['data_solicitacao'])); ?>" readonly>
                                                <label class="form-label" for="observacao">Observação</label>
                                                <input class="form-control" type="text" id="observacao" value="<?php echo $row['observacao']; ?>" readonly>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Sair</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal de Exclusão -->
                                <div class="modal fade" id="deleteModal<?php echo $row['id_os']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel<?php echo $row['id_os']; ?>" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel<?php echo $row['id_os']; ?>">Excluir Ordem de Serviço</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Tem certeza que deseja excluir a ordem de serviço com ID <?php echo $row['id_os']; ?>?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                <a href="./delete_os.php?id=<?php echo $row['id_os']; ?>" class="btn btn-danger">Excluir</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php } else { ?>
                <?php 
                echo "<h4 style='text-align:center'>Nenhuma Ordem de Serviço Encontrada!</h4>";
            } 
                ?>
            </tbody>
        </table>
    </div>
</div>
            </div>
<div>
    <nav aria-label="Paginação">
        <ul class="pagination justify-content-center">
            <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?php echo $page <= 1 ? '#' : './listing.php?page=' . ($page - 1) . '&search=' . urlencode($search); ?>" tabindex="-1" aria-disabled="true">Anterior</a>
            </li>
            <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                    <a class="page-link" href="./listing.php?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?php echo $page >= $total_pages ? '#' : './listing.php?page=' . ($page + 1) . '&search=' . urlencode($search); ?>">Próximo</a>
            </li>
        </ul>
    </nav>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</div>
<?php require_once './footer.php'; ?>
<script>
    window.onload = () => {
        const container = document.querySelector('.container');
        container.style.height === '' ? container.style.height = `${height-95}px` : null;
    };
</script>

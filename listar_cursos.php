<?php
session_start();
require_once "config/database.php";

$id_usuario = $_SESSION['cod_usuario'];
if (!isset($id_usuario)) {
    echo "<script>window.location.href = 'login.php'</script>";
    die();
}
    
// Verifica se uma matrícula deve ser excluída
if (isset($_GET['delete']) && isset($_GET['curso'])) {
    $matricula_id = $_GET['delete'];
    $curso_id = $_GET['curso'];

    // Prepara e executa a exclusão da matrícula
    $stmt = $conn->prepare("DELETE FROM matricula WHERE matricula = ?");
    $stmt->bind_param("i", $matricula_id);

    if ($stmt->execute()) {
        // Armazena uma mensagem de sucesso na sessão
        $_SESSION['success_message'] = "Matrícula excluída com sucesso!";
        // Redireciona para a mesma página após a exclusão
        header("Location: listar_cursos.php?page=" . (isset($_GET['page']) ? $_GET['page'] : 1));
        exit;
    } else {
        $_SESSION['error_message'] = "Erro ao excluir a matrícula.";
    }
}

// Configurações de paginação
$registros_por_pagina = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $registros_por_pagina;

if ($_SESSION['perfil'] == 'gestor') {
    $sql = "SELECT * FROM cursos ORDER BY id_curso DESC LIMIT $offset, $registros_por_pagina";
    $total_sql = "SELECT COUNT(*) AS total FROM cursos";
} else {
    $sql = "SELECT * FROM cursos WHERE id_instrutor = " . $_SESSION['cod_usuario'] . " ORDER BY id_curso DESC LIMIT $offset, $registros_por_pagina";
    $total_sql = "SELECT COUNT(*) AS total FROM cursos WHERE id_instrutor = " . $_SESSION['cod_usuario'];
}

$result = $conn->query($sql);
$total_result = $conn->query($total_sql);
$total_rows = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $registros_por_pagina);
?>

<?php include './header.php'; ?>

<!DOCTYPE html>
<html lang="pt-BR">
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
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="d-flex justify-content-between pb-3 pt-4">
                    <h4>Listagem de Cursos</h4>
                    <a href="./form_add_cursos.php" class="btn btn-success">Cadastrar Curso</a>
                </div>

                <?php
                // Exibir mensagens de sucesso ou erro
                if (isset($_SESSION['success_message'])) {
                    echo "<div id='message' class='alert alert-success text-center fade-out'>{$_SESSION['success_message']}</div>";
                    unset($_SESSION['success_message']);
                }

                if (isset($_SESSION['error_message'])) {
                    echo "<div id='message' class='alert alert-danger text-center fade-out'>{$_SESSION['error_message']}</div>";
                    unset($_SESSION['error_message']);
                }
                ?>

                <?php if ($result->num_rows > 0) : ?>
                    <div class="accordion" id="accordionCursos">
                        <?php while ($row = $result->fetch_assoc()) : ?>
                            <div class="accordion-item">
                                <h2 class="accordion-header d-flex align-items-center" id="heading<?php echo $row['id_curso']; ?>">
                                    <button class="accordion-button collapsed flex-grow-1" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $row['id_curso']; ?>" aria-expanded="false" aria-controls="collapse<?php echo $row['id_curso']; ?>">
                                        <?php echo htmlspecialchars($row['nome'], ENT_QUOTES, 'UTF-8'); ?>
                                        <a class="btn btn-secondary btn-sm ms-2 kt_clipboard_4" 
                                            data-clipboard-text="https://www.senaijf.com.br/portal/form_matricula.php?id=<?php echo $row['id_curso']; ?>">
                                            <i class="bi bi-clipboard"></i> Compartilhar
                                        </a>
                                    </button>
                                </h2>
                                <div id="collapse<?php echo $row['id_curso']; ?>" class="accordion-collapse collapse" aria-labelledby="heading<?php echo $row['id_curso']; ?>" data-bs-parent="#accordionCursos">
                                    <div class="accordion-body">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Matrícula</th>
                                                    <th>Nome do Aluno</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $curso_id = $row['id_curso'];
                                                $sql_matricula = "SELECT matricula, nome_aluno FROM matricula WHERE curso = $curso_id ORDER BY data_cadastro DESC";
                                                $result_matricula = $conn->query($sql_matricula);
                                                if ($result_matricula->num_rows > 0) {
                                                    while ($matricula_row = $result_matricula->fetch_assoc()) {
                                                        echo "<tr>";
                                                        echo "<td>" . htmlspecialchars($matricula_row['matricula'], ENT_QUOTES, 'UTF-8') . "</td>";
                                                        echo "<td>" . htmlspecialchars($matricula_row['nome_aluno'], ENT_QUOTES, 'UTF-8') . "</td>";
                                                        echo "<td>
                                                                <button type='button' class='btn btn-secondary' data-bs-toggle='modal' data-bs-target='#deleteModal{$matricula_row['matricula']}'><i class='bi bi-trash3-fill'></i></button>

                                                                <div class='modal fade' id='deleteModal{$matricula_row['matricula']}' tabindex='-1' aria-labelledby='deleteModalLabel{$matricula_row['matricula']}' aria-hidden='true'>
                                                                    <div class='modal-dialog'>
                                                                        <div class='modal-content'>
                                                                            <div class='modal-header'>
                                                                                <h5 class='modal-title' id='deleteModalLabel{$matricula_row['matricula']}'>Confirmar Exclusão</h5>
                                                                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                                                            </div>
                                                                            <div class='modal-body'>
                                                                                Tem certeza que deseja excluir a matrícula <strong>{$matricula_row['matricula']}</strong> do aluno <strong>{$matricula_row['nome_aluno']}</strong>?
                                                                            </div>
                                                                            <div class='modal-footer'>
                                                                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                                                                                <a href='./listar_cursos.php?delete={$matricula_row['matricula']}&curso={$curso_id}&page={$page}' class='btn btn-danger'>Excluir</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>";
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='3'>Nenhum aluno matriculado.</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>

                    <!-- Paginação -->
                    <nav aria-label="Paginação" class="mt-4">
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                                <a class="page-link" href="<?php echo $page <= 1 ? '#' : './listar_cursos.php?page=' . ($page - 1); ?>" tabindex="-1" aria-disabled="true">Anterior</a>
                            </li>
                            <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                                <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                                    <a class="page-link" href="./listar_cursos.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : ''; ?>">
                                <a class="page-link" href="<?php echo $page >= $total_pages ? '#' : './listar_cursos.php?page=' . ($page + 1); ?>">Próximo</a>
                            </li>
                        </ul>
                    </nav>

                <?php else : ?>
                    <div class="alert alert-warning text-center" role="alert">
                        Nenhum curso encontrado.
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.8/dist/clipboard.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Inicializa ClipboardJS
            var clipboard = new ClipboardJS('.kt_clipboard_4', {
                text: function (trigger) {
                    return trigger.getAttribute('data-clipboard-text');
                }
            });

            // Manipulador de sucesso
            clipboard.on('success', function (e) {
                var button = e.trigger;
                var icon = button.querySelector('.bi');

                icon.classList.remove('bi-clipboard');
                icon.classList.add('bi-check-circle');
                button.classList.remove('btn-secondary');
                button.classList.add('btn-success');
                button.innerHTML = '<i class="bi bi-check-circle"></i> Copiado';

                setTimeout(function () {
                    icon.classList.remove('bi-check-circle');
                    icon.classList.add('bi-clipboard');
                    button.classList.remove('btn-success');
                    button.classList.add('btn-secondary');
                    button.innerHTML = '<i class="bi bi-clipboard"></i> Compartilhar';
                }, 3000);
            });

            // Remove a mensagem após 3 segundos
            var messageElement = document.getElementById('message');
            if (messageElement) {
                setTimeout(function () {
                    messageElement.classList.add('hide');
                    setTimeout(function () {
                        messageElement.remove(); // Remove o elemento do DOM
                    }, 500); // Tempo para a transição de opacidade
                }, 3000);
            }
        });
    </script>
</div>
</div>
<?php include './footer.php'; ?>

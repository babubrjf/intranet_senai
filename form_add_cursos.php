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


function gerarCodigoUnico($conn) {
    do {
        // Gera um código aleatório de 5 dígitos
        $codigo = sprintf('%05d', mt_rand(0, 99999));
        // Verifica se o código já existe na base de dados
        $sql = "SELECT 1 FROM cursos WHERE id_curso = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $codigo);
        $stmt->execute();
        $result = $stmt->get_result();
    } while ($result->num_rows > 0); // Continua gerando até encontrar um código único

    return $codigo;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_curso = $_POST["nome_curso"];
    $carga_horaria = $_POST["carga_horaria"];
    $data_inicio = $_POST["data_inicio"];
    $empresa = $_POST["empresa"];
    $id_instrutor = $_POST["id_instrutor"];

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Gera um código único para o curso
    $codigo_curso = gerarCodigoUnico($conn);

    $sql = "INSERT INTO cursos (id_curso, nome, id_instrutor, carga_horaria, empresa, data_inicio) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisss", $codigo_curso, $nome_curso, $id_instrutor, $carga_horaria, $empresa, $data_inicio);

    if ($stmt->execute()) {
        echo "<script type='text/javascript'>alert('Curso Cadastrado com sucesso!'); window.location.href='listar_cursos.php';</script>";
    } else {
        echo "<script type='text/javascript'>alert('Erro Ao Cadastrar Curso.'); window.location.href='cadastrar_curso.php';</script>" . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Curso</title>
    <!-- Importando o CSS do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media (max-width: 576px) {
            #id_instrutor {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>

<?php include './header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card mt-5">
            <div class="card-header">
                <h4 class="card-title">Cadastro de Curso</h4>
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="form-group mb-3">
                        <label for="nome_curso">Nome do Curso:</label>
                        <input type="text" class="form-control" id="nome_curso" name="nome_curso" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="carga_horaria">Carga Horária:</label>
                        <input type="text" class="form-control" id="carga_horaria" name="carga_horaria" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="data_inicio">Data de Início:</label>
                        <input type="date" class="form-control" id="data_inicio" name="data_inicio" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="empresa">Empresa:</label>
                        <input type="text" class="form-control" id="empresa" name="empresa" required>
                    </div>
                    <div class="form-group mb-3">
                        <div class="row align-items-center">
                            <label for="id_instrutor">Instrutor:</label>
                            <div class="col-sm-5">
                                <select class="form-select" id="id_instrutor" name="id_instrutor" required>
                                    <?php
                                    $conn = new mysqli($servername, $username, $password, $dbname);
                                    if ($conn->connect_error) {
                                        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
                                    }
                                    if ($_SESSION['perfil'] == 'gestor') {
                                        $sql = "SELECT cod_usuario, nome FROM usuarios WHERE perfil = 'colaborador'";
                                        $result = $conn->query($sql);
                                    } else {
                                        $sql = "SELECT cod_usuario, nome FROM usuarios WHERE cod_usuario = '" . $_SESSION['cod_usuario'] . "'";
                                        $result = $conn->query($sql);
                                    }


                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value=\"" . htmlspecialchars($row["cod_usuario"], ENT_QUOTES, 'UTF-8') . "\">" . htmlspecialchars($row["nome"], ENT_QUOTES, 'UTF-8') . "</option>";
                                        }
                                    } else {
                                        echo "<option value=\"\">Nenhum colaborador disponível</option>";
                                    }

                                    $conn->close();
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                    <a href="listar_cursos.php" class="btn btn-secondary" role="button">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>

</div>
<?php include './footer.php'; ?>

<!-- Importando o JavaScript do Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- /pages/edit_aviso.php -->
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

include './header.php';

$id = $_GET['id']; // ID do aviso a ser editada

$sql = "SELECT * FROM avisos WHERE cod_aviso='$id'";
$result = $conn->query($sql);
$aviso = $result->fetch_assoc();

$mensagem = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $cod_usuario = $_SESSION['cod_usuario'];
        $titulo_aviso = $_POST["titulo_aviso"];
        $detalhes_aviso = $_POST["detalhes_aviso"];
        $data_aviso = new DateTime($_POST["data_aviso"]);
        $data_aviso_formatada = $data_aviso->format('d/m/Y');

            $sql = "UPDATE avisos SET 
                        cod_usuario = ?, 
                        titulo_aviso = ?, 
                        detalhes_aviso = ?, 
                        data_aviso = ?
                    WHERE cod_aviso = ?";

            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("ssssi", $cod_usuario, $titulo_aviso, $detalhes_aviso, $data_aviso_formatada, $id);
                if ($stmt->execute()) {
                    $mensagem = "Aviso atualizado com sucesso!";
                    echo("<meta http-equiv='refresh' content='1'>");
                } else {
                    $mensagem = "Erro ao atualizar dados no banco de dados: " . $stmt->error;
                }
            } else {
                $mensagem = "Erro ao preparar a declaração SQL: " . $conn->error;
            }
    }

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Incluir o CkEditor -->
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

    <title>Editar Aviso</title>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5">
                    <div class="card-header">
                        <h4 class="card-title">Editar Avisos</h4>
                    </div>
                    <div class="card-body">
                        <?php if ($mensagem): ?>
                        <div class="alert alert-info">
                            <?php echo htmlspecialchars($mensagem); ?>
                        </div>
                        <?php endif; ?>
                        <form method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="titulo_aviso">Título:</label>
                                <input type="text" class="form-control" name="titulo_aviso" value="<?php echo htmlspecialchars($aviso['titulo_aviso']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="detalhes_aviso">Detalhes:</label>
                                <input type="text" class="form-control" name="detalhes_aviso" value="<?php echo htmlspecialchars($aviso['detalhes_aviso']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="data_aviso">data_aviso:</label>
                                <input type="date" class="form-control" id="data_aviso" name="data_aviso" value="<?php echo date('Y-m-d', strtotime($aviso['data_aviso'])); ?>" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                        </form>
                        <script>
                            CKEDITOR.replace('materia');
                            CKEDITOR.replace('resumo_noticia');
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include './footer.php'; ?>

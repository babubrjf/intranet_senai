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
    $cod_usuario = $_SESSION["cod_usuario"];
    $titulo_aviso = $_POST["titulo_aviso"];
    $detalhes_aviso = $_POST["detalhes_aviso"];
    $data_aviso = new DateTime($_POST["data_aviso"]);
    $data_aviso_formatada = $data_aviso->format('d/m/Y');
    $status = $_POST['status'];

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    $sql = "INSERT INTO avisos (cod_usuario, titulo_aviso, detalhes_aviso, data_aviso, status) VALUES ('$cod_usuario', '$titulo_aviso', '$detalhes_aviso', '$data_aviso_formatada', '$status')";

    if ($conn->query($sql) === TRUE) {
        echo "<script type='text/javascript'>alert('Aviso Cadastrado com sucesso!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script type='text/javascript'>alert('Erro Ao Cadastrar Aviso.'); window.location.href='form_aviso.php';</script>" . $stmt->error;
    }
}

?>

<?php include './header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card mt-5">
            <div class="card-header">
                <h4 class="card-title">Cadastro de Aviso</h2>
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="form-group">
                        <label for="titulo_aviso">Título:</label>
                        <input type="text" maxlength="35" placeholder="Max.: 35 car." class="form-control" id="titulo_aviso" name="titulo_aviso" required>
                    </div>
                    <div class="form-group">
                        <label for="detalhes_aviso">Detalhes:</label>
                        <textarea class="form-control" placeholder="Max.: 225 car." maxlength="225" id="detalhes_aviso" name="detalhes_aviso" rows="3"
                            required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="data_aviso">Data:</label>
                        <input type="date" class="form-control" id="data_aviso" name="data_aviso" required>
                    </div>

                    <div class="form-group">
                        <label for="data">Status:</label>
                        <select name="status" id="status" required>
                            <option value="">Selecione uma opção</option>
                            <option value="Publicado">Publicar</option>
                            <option value="Não Publicado">Não publicar</option>
                        </select>
                    </div>

                    <a href="dashboard.php" class="btn btn-secondary" role="button">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                </form>
            </div>
        </div>
    </div>
</div>

</div>
<?php include './footer.php'; ?>

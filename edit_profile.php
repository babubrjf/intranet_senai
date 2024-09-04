<!-- /pages/edit_profile.php -->
<?php
session_start();
require_once "config/database.php";

$id_usuario = $_SESSION['cod_usuario'];
if (!isset($id_usuario)) {
    echo "<script>window.location.href = 'login.php'</script>";
    die();
}

$id = $_SESSION['cod_usuario'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];
    $celular = $_POST['celular'];
    
    $sql = "UPDATE usuarios SET nome='$nome', senha='$senha', celular='$celular' WHERE cod_usuario='$id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: ./dashboard.php");
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

$sql = "SELECT * FROM usuarios WHERE cod_usuario='$id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
?>

<?php include './header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <h2>Editar Perfil</h2>
        <form method="post">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $user['nome']; ?>" required>
            </div>
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" class="form-control" id="senha" name="senha" value="<?php echo $user['senha']; ?>" required>
            </div>
            <div class="form-group">
                <label for="celular">Celular:</label>
                <input type="text" class="form-control" id="celular" name="celular" value="<?php echo $user['celular']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </form>
    </div>
</div>

</div>
<?php include './footer.php'; ?>

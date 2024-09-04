<?php
session_start();
include './config/database.php';

// Verificar se o usuário está logado e se é um gestor
if (!isset($_SESSION['cod_usuario']) || $_SESSION['perfil'] != 'gestor') {
    header("Location: ./login.php");
    exit();
}

if (!isset($_GET['cod_user'])) {
    header("Location: ./list_users_all.php");
    exit();
}

$cod_usuario = $_GET['cod_user'];
$error = '';

// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $conn->real_escape_string($_POST['nome']);
    $matricula = $conn->real_escape_string($_POST['matricula']);
    $cpf = $conn->real_escape_string($_POST['cpf']);
    $celular = $conn->real_escape_string($_POST['celular']);
    $perfil = $conn->real_escape_string($_POST['perfil']);
    $data_admissao = $conn->real_escape_string($_POST['data_admissao']);
    $gestor_cod_usuario = $conn->real_escape_string($_POST['gestor_cod_usuario']);
    $email = $conn->real_escape_string($_POST['email']);

    $sql = "UPDATE usuarios SET 
            nome='$nome', 
            matricula='$matricula', 
            cpf='$cpf', 
            celular='$celular', 
            perfil='$perfil', 
            data_admissao='$data_admissao', 
            gestor_cod_usuario=IF('$gestor_cod_usuario' = '', NULL, '$gestor_cod_usuario'), 
            email='$email' 
            WHERE cod_usuario='$cod_usuario'";

    if ($conn->query($sql) === TRUE) {
        header("Location: ./list_users_all.php?message=success");
        exit();
    } else {
        $error = "Erro ao atualizar os dados: " . $conn->error;
    }
}

// Obter dados do usuário para exibir no formulário
$sql = "SELECT * FROM usuarios WHERE cod_usuario='$cod_usuario'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

if (!$user) {
    header("Location: ./edit_user.php");
    exit();
}

include './header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                Editar Usuário
            </div>
            <div class="card-body">
                <?php if ($error) { ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php } ?>
                <form method="post">
                    <div class="form-group">
                        <label for="nome">Nome:</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $user['nome']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="matricula">Matrícula:</label>
                        <input type="text" class="form-control" id="matricula" name="matricula" value="<?php echo $user['matricula']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="cpf">CPF:</label>
                        <input type="text" class="form-control" id="cpf" name="cpf" value="<?php echo $user['cpf']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="celular">Celular:</label>
                        <input type="text" class="form-control" id="celular" name="celular" value="<?php echo $user['celular']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="perfil">Perfil:</label>
                        <select class="form-control" id="perfil" name="perfil" required>
                            <option value="gestor" <?php if ($user['perfil'] == 'gestor') echo 'selected'; ?>>Gestor</option>
                            <option value="colaborador" <?php if ($user['perfil'] == 'colaborador') echo 'selected'; ?>>Colaborador</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="data_admissao">Data de Admissão:</label>
                        <input type="date" class="form-control" id="data_admissao" name="data_admissao" value="<?php echo $user['data_admissao']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="gestor_cod_usuario">Gestor (cod_usuario):</label>
                        <input type="number" class="form-control" id="gestor_cod_usuario" name="gestor_cod_usuario" value="<?php echo $user['gestor_cod_usuario']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Atualizar</button>
                    <a href="list_users_all.php" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include './footer.php'; ?>

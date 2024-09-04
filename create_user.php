<!-- /pages/create_user.php -->
<?php
    session_start();
    require_once "config/database.php";

    $id_usuario = $_SESSION['cod_usuario'];
    if (!isset($id_usuario)) {
        echo "<script>window.location.href = 'login.php'</script>";
        die();
    } else if ($_SESSION['perfil'] !== 'gestor'){
        echo "<script>window.location.href = 'dashboard.php'</script>";
        die();
    }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $matricula = $_POST['matricula'];
    $cpf = $_POST['cpf'];
    $celular = $_POST['celular'];
    $perfil = $_POST['perfil'];
    $data_admissao = $_POST['data_admissao'];
    $gestor_cod_usuario = $_POST['gestor_cod_usuario'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    
    $sql = "INSERT INTO Usuarios (nome, matricula, cpf, celular, perfil, data_admissao, gestor_cod_usuario, email, senha) 
            VALUES ('$nome', '$matricula', '$cpf', '$celular', '$perfil', '$data_admissao', '$gestor_cod_usuario', '$email', '$senha')";

    if ($conn->query($sql) === TRUE) {
        header("Location: ./list_users_all.php");
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}
?>

<?php include './header.php'; ?>

<div class="row justify-content-center" style='padding-bottom: 20px'>
    <div class="col-md-6">
        <div class="card mt-5">
            <div class="card-header">
                <h4 class="card-title">Cadastrar Usuario</h4>
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="form-group">
                        <label for="nome">Nome:</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                    <div class="form-group">
                        <label for="matricula">Matrícula:</label>
                        <input type="text" class="form-control" id="matricula" name="matricula" required>
                    </div>
                    <div class="form-group">
                        <label for="cpf">CPF:</label>
                        <input type="text" class="form-control" id="cpf" name="cpf" required>
                    </div>
                    <div class="form-group">
                        <label for="celular">Celular:</label>
                        <input type="text" class="form-control" id="celular" name="celular" required>
                    </div>
                    <div class="form-group">
                        <label for="perfil">Perfil:</label>
                        <select class="form-control" id="perfil" name="perfil" required>
                            <option value="colaborador">Colaborador</option>
                            <option value="gestor">Gestor</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="data_admissao">Data de Admissão:</label>
                        <input type="date" class="form-control" id="data_admissao" name="data_admissao" required>
                    </div>
                    <div class="form-group">
                        <!-- <label for="gestor_cod_usuario">Gestor:</label> -->
                        <input type="hidden" class="form-control" id="gestor_cod_usuario" name="gestor_cod_usuario" value="<?php  echo $_SESSION['cod_usuario']; ?>" required>

                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha:</label>
                        <input type="password" class="form-control" id="senha" name="senha" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                </form>
        </div>
    </div>
</div>

</div>
</div>
<?php include './footer.php'; ?>

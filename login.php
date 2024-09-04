<!-- /pages/login.php -->
<?php
session_start();
require_once "config/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    
    $sql = "SELECT * FROM Usuarios WHERE email = '$email' AND senha = '$senha'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['cod_usuario'] = $row['cod_usuario'];        
        $_SESSION['nome'] = $row['nome'];        
        $_SESSION['perfil'] = $row['perfil'];
        
        header("Location: index.php");
    } else {
        $error = "Email ou senha incorretos.";
    }
}
?>

<!-- /includes/header.php -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal do Colaborador</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<header>
    <!-- Barra de navegação dinâmica -->
    
</header>
<nav class="navbar bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="img/logo_senai.png" alt="Logo" height="30"  class="d-inline-block align-text-top">
      Portal do Colaborador
    </a>
  </div>
</nav>
<h3></h3>
<p></p>
<div class="container">
<div class="row justify-content-center" style="height: 100%; align-items: center;">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                Login
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha:</label>
                        <input type="password" class="form-control" id="senha" name="senha" required>
                    </div>
                    <div style="display: flex; flex-direction: column">
                        <button type="submit" class="btn btn-primary">Entrar</button>
                        <a href="./recover_password.php" class="btn btn-link">Esqueci minha senha</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</div>
<?php include './footer.php'; ?>
<script>
    window.onload = () => {document.querySelector('.container').style.height = `${height+216}px`};
</script>

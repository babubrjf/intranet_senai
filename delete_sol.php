<!-- /pages/delete_user.php -->
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
} else if (!isset($_GET['id'])) {
    echo "<script>window.location.href = 'list_req.php'</script>";
    exit();
}

$cod_sol = $_GET['id'];

$sql = "DELETE FROM solicitacao WHERE cod_sol = '$cod_sol'";

if ($conn->query($sql) == TRUE) {
    // header("Refresh:0; url=./list_req.php");
    header("Location: ./list_req.php");
    exit();
} else {
    echo "Erro ao excluir solicitação: " . $conn->error;
}
?>
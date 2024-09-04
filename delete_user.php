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
}

$id = $_GET['cod_user'];

$sql = "DELETE FROM usuarios WHERE cod_usuario = '$id'";

if ($conn->query($sql) === TRUE) {
    header("Location: ./list_users_all.php");
} else {
    echo "<script type='text/javascript'>alert('Não foi possível excluir o usuário pois há solicitações de compensação em seu registro.'); window.location.href='list_users_all.php';</script>";
}
?>
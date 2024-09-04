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

$id = $_GET['id'];

$sql = "DELETE FROM ordem_servico WHERE id_os = '$id'";

if ($conn->query($sql) === TRUE) {
    header("Location: ./listing.php");
} else {
    echo "Erro ao excluir Ordem de Serviço: " . $conn->error;
}
?>
<!-- /pages/update_not.php -->
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

@$sql_query = "SELECT * FROM avisos WHERE cod_aviso = $id";
    if ($result = $conn ->query($sql_query)) {
        while ($row = $result -> fetch_assoc()) { 
            $status = $row['status'];

if ($status === 'Publicado') {
$sql = "UPDATE avisos SET status = 'Não Publicado' WHERE cod_aviso = '$id'";
} elseif ($status === 'Não Publicado') {
$sql = "UPDATE avisos SET status = 'Publicado' WHERE cod_aviso = '$id'";
}

if ($conn->query($sql) === TRUE) {
    echo "<script type='text/javascript'>alert('Visibilidade do aviso atualizado com sucesso!'); window.location.href='list_avisos.php';</script>"; 

} else {
    echo "Erro ao atualizar visibilidade do aviso: " . $conn->error;
}
?>
<?php 
    }
}
$conn->close();
?>
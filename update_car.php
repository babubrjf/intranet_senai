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

@$sql_query = "SELECT * FROM carrossel WHERE cod_car = $id";
    if ($result = $conn ->query($sql_query)) {
        while ($row = $result -> fetch_assoc()) { 
            $status = $row['status'];

if ($status === 'Publicada') {
$sql = "UPDATE carrossel SET status = 'Não Publicada' WHERE cod_car = '$id'";
} elseif ($status === 'Não Publicada') {
$sql = "UPDATE carrossel SET status = 'Publicada' WHERE cod_car = '$id'";
}

if ($conn->query($sql) === TRUE) {
    echo "<script type='text/javascript'>alert('Visibilidade do carrossel atualizada com sucesso!'); window.location.href='list_carrossel.php';</script>"; 

} else {
    echo "Erro ao atualizar visibilidade do carrossel: " . $conn->error;
}
?>
<?php 
    }
}
$conn->close();
?>
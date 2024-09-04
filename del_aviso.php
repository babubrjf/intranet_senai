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

    $sql = "DELETE FROM avisos WHERE cod_aviso = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script type='text/javascript'>alert('Aviso excluído com sucesso!'); window.location.href='list_avisos.php';</script>";
    } else {
        echo "Erro ao excluir aviso: " . $conn->error;
    }
?>
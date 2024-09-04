<!-- /pages/del_not.php -->
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

    $sql = "DELETE FROM carrossel WHERE cod_car = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script type='text/javascript'>alert('Imagem excluída com sucesso!'); window.location.href='list_carrossel.php';</script>"; 

    } else {
        echo "Erro ao excluir imagem: " . $conn->error;
    }
?>
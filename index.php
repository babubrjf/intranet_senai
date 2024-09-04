<!-- /index.php -->
<?php
session_start();
require_once "config/database.php";

@$id_usuario = $_SESSION['cod_usuario'];
@$perfil = $_SESSION['perfil'];
if (!isset($id_usuario)) {
    echo "<script>window.location.href = 'login.php'</script>";
    die();
}

?>

<?php include './dashboard.php'; ?>



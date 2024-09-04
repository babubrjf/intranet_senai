<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notícia</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'> <!-- Importa o icon-box -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .fonte {
            font-family: "Noto Sans";
            font-size: 12px;
        }
    </style>
</head>

</html>
<!-- /pages/dashboard.php -->
<?php include './header.php'; ?>

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

$sql_avisos = "SELECT * FROM avisos WHERE status='Publicado' ORDER BY cod_aviso DESC";
$result_avisos = $conn->query($sql_avisos);

@$cod_noticia = $_GET['cod_noticia'];
    if(isset($cod_noticia)){
        $sql_noticias = "SELECT * FROM noticias WHERE cod_noticia = '$cod_noticia'";
     } else {
        $sql_noticias = "SELECT * FROM noticias";
    }
    if ($result_noticias = $conn -> query($sql_noticias)) {
        while ($row = $result_noticias -> fetch_assoc()) { 
            $titulo = $row['titulo'];
            $sub_titulo = $row['sub_titulo'];
            $materia = $row['materia'];
            $data = $row['data'];
            $img_noticia = $row['img_noticia'];
?>
<!-- Notícias -->
<div class="row mt-4">
    <div class="col-lg-8">
        <a href="index.php" class="btn btn-primary">Voltar</a>
        <br><br>
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="card-title"><?php echo $row['titulo']; ?></h2>
                <p style="margin-bottom: 5px; font-style: italic; font-size:large" class="card-subtitle"><?php echo $row['sub_titulo']; ?></p>
                <div class="float-right">
                    <small><i class='bx bx-user-circle' class="card-text"><i class="fonte"> <?php echo $row['nome'];?></i></i>
                        ㅤ<i class='bi bi-calendar2-week' class="card-text"> <i class="fonte"><?php echo $row['data']; ?></i></i>
                    </small>
                </div>
            </div>
            <img src="<?php echo $row['img_noticia'];?>" class="card-img-top" alt="imagem-notícia" >
            <div class="card-body">
                <p style="text-align:justify;"><?php echo $row['materia']; ?></p>
            </div>
        </div>
    </div>
    <!-- Avisos -->
    <div class="col-lg-4">
        <br>
        <h4>Avisos</h4>
        <?php if ($result_avisos->num_rows > 0) {
                while($row = $result_avisos->fetch_assoc()) { ?>
        <div class="card mb-2">
            <div class="card-body">
                <h6 class="card-title"><?php echo $row['titulo_aviso']; ?></h6>
                <p style="font-size: small;" class="card-text"><?php echo $row['detalhes_aviso']; ?></p>
                <small>
                    <i class='bi bi-calendar2-week' class="card-text"> <i class="fonte"><?php echo $row['data_aviso']; ?></i></i>
                </small>
            </div>
        </div>
        <?php
                    }
                }
            }
        }
        ?>
    </div>
</div>
</div>
</div>
</div>
</div>
</div>

</div>
<?php include './footer.php'; ?>
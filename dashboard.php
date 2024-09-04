<?php
    session_start();
    require_once "config/database.php";

    $id_usuario = $_SESSION['cod_usuario'];
    if (!isset($id_usuario)) {
        echo "<script>window.location.href = 'login.php'</script>";
        die();
    }

    include './header.php';

    $sql_avisos = "SELECT * FROM avisos WHERE status='Publicado' ORDER BY cod_aviso DESC";
    $result_avisos = $conn->query($sql_avisos);

    $sql_carrossel = "SELECT * FROM carrossel WHERE status='Publicada'";
    $result_carrossel = $conn->query($sql_carrossel);

    $noticias_por_pagina = 3;
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($page - 1) * $noticias_por_pagina;

    $sql_noticias = "SELECT * FROM noticias WHERE status='Publicada' ORDER BY cod_noticia DESC LIMIT $offset, $noticias_por_pagina";
    $result_noticias = $conn->query($sql_noticias);

    $total_noticias_sql = "SELECT COUNT(*) AS total FROM noticias";

    $total_noticias_result = $conn->query($total_noticias_sql);
    $total_noticias_rows = $total_noticias_result->fetch_assoc()['total'];
    $total_noticias_pages = ceil($total_noticias_rows / $noticias_por_pagina);

?>

<style>
    .fonte {
        font-family: "Noto Sans";
        font-size: 12px;
    }
</style>
<script>
    window.onload = () => {document.querySelector('.container').style.height = `${height + 180}px`};
</script>
<div class="container mt-3">
    <!-- <h5>Bem-vindo ao Portal do Colaborador, <?php echo $_SESSION['nome']; ?>!</h5> -->
    <!-- <p>Selecione uma das opções no menu acima para começar.</p> -->

    <?php if ($_SESSION['perfil'] == 'Gestor'): ?>
    <!-- <p>Aqui estão suas funcionalidades específicas de Gestor.</p> -->
    <!-- Adicione formulários e links específicos para gestores -->
    <?php endif; ?>

    <!-- Carrossel de Imagens -->
    <div id="imageCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
        </ol>
        <div class="carousel-inner">
            <?php
                $result_carrossel_all = $result_carrossel->fetch_all();
                for($i=0; $i<count($result_carrossel_all); $i++){
                    $img_src = $result_carrossel_all[$i][2];
                    $img_tit = $result_carrossel_all[$i][3];
                    $img_desc = $result_carrossel_all[$i][4];
                    if($i === 0){
                        echo "<div class='carousel-item active'>";
                        echo "<script>document.querySelector('.carousel-indicators').innerHTML += `<li data-target='#imageCarousel' data-slide-to='$i' class='active'></li>`</script>";
                    } else {
                        echo "<div class='carousel-item'>";
                        echo "<script>document.querySelector('.carousel-indicators').innerHTML += `<li data-target='#imageCarousel' data-slide-to='$i'></li>`</script>";
                    }
                    echo "
                        <img src='$img_src' class='d-block w-100'>
                        <div class='carousel-caption d-none d-md-block'>
                            <h5>$img_tit</h5>
                            <p>$img_desc</p>
                        </div>
                    </div>";
                }
            ?>
        </div>
        <a class="carousel-control-prev" href="#imageCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Seguinte</span>
        </a>
        <a class="carousel-control-next" href="#imageCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Anterior</span>
        </a>
    </div>
    <!-- Fim do carrossel -->

    <!-- Notícias -->
    <div class="row mt-5">
        <div class="col-lg-8">
            <h4>Notícias</h4>
            <?php if ($result_noticias->num_rows > 0) {
                while($row = $result_noticias->fetch_assoc()) { ?>
            <div class="card mb-4">
                <img src="<?php echo $row['img_banner'];?>" class="card-img-top" alt="<?php echo $row['titulo']; ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $row['titulo']; ?></h5>
                    <p class="card-text"><?php echo $row['resumo_noticia']; ?></p>
                    <a href="ler_noticia.php?cod_noticia=<?php echo $row['cod_noticia']; ?>" class="btn btn-primary">Leia mais</a>                 
                </div>
            </div>
                    <?php
                    }
                } else 
                    echo"<div class='alert alert-secondary text-center' role='alert'>
                    Nenhuma notícia encontrada.
                </div>"
                
            ?>

            <!-- Paginação -->
            <nav aria-label="Paginação">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                        <a class="page-link" href="<?php echo $page <= 1 ? '#' : './dashboard.php?page=' . ($page - 1); ?>" tabindex="-1" aria-disabled="true">Anterior</a>
                    </li>
                    <?php for ($i = 1; $i <= $total_noticias_pages; $i++) : ?>
                        <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                            <a class="page-link" href="./dashboard.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?php echo $page >= $total_noticias_pages ? 'disabled' : ''; ?>"><a class="page-link" href="<?php echo $page >= $total_noticias_pages ? '#' : './dashboard.php?page=' . ($page + 1); ?>">Próximo</a>
                    </li>
                </ul>
            </nav>
        </div>
        
    <!-- Avisos -->
    <div class="col-lg-4">
            <h4>Avisos</h4>
            <?php if ($result_avisos->num_rows > 0) {
                while($row = $result_avisos->fetch_assoc()) { ?>
            <div class="card mb-1">
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
                } else 
                    echo"<div class='alert alert-secondary text-center' role='alert'>
                    Nenhum aviso encontrado.
                </div>"
            ?>
        </div>
    </div>
</div>
</div>
</div>


</div>
<?php include './footer.php'; ?>
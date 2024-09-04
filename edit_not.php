<!-- /pages/edit_not.php -->
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
include './header.php';

function redimensionarImagem($filename, $larguraDesejada, $alturaDesejada) {
    $info = getimagesize($filename);
    $tipoImagem = $info[2];

    switch ($tipoImagem) {
        case IMAGETYPE_JPEG:
            $imagemOriginal = imagecreatefromjpeg($filename);
            break;
        case IMAGETYPE_PNG:
            $imagemOriginal = imagecreatefrompng($filename);
            break;
        case IMAGETYPE_GIF:
            $imagemOriginal = imagecreatefromgif($filename);
            break;
        case IMAGETYPE_WEBP:
            $imagemOriginal = imagecreatefromwebp($filename);
            break;
        default:
            return false;
    }

    if (!$imagemOriginal) {
        return false;
    }

    $larguraOriginal = imagesx($imagemOriginal);
    $alturaOriginal = imagesy($imagemOriginal);

    $imagemRedimensionada = imagecreatetruecolor($larguraDesejada, $alturaDesejada);
    imagecopyresampled(
        $imagemRedimensionada,
        $imagemOriginal,
        0,
        0,
        0,
        0,
        $larguraDesejada,
        $alturaDesejada,
        $larguraOriginal,
        $alturaOriginal
    );

    imagedestroy($imagemOriginal);
    return $imagemRedimensionada;
}

$id = $_GET['id']; // ID da notícia a ser editada

$sql = "SELECT * FROM noticias WHERE cod_noticia='$id'";
$result = $conn->query($sql);
$nots = $result->fetch_assoc();

$mensagem = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["img_banner"]) && isset($_FILES["img_noticia"])) {
        $img_banner = $_FILES["img_banner"];
        $img_principal = $_FILES["img_noticia"];

        $nome = $_SESSION['nome'];
        $cod_usuario = $_SESSION['cod_usuario'];
        $titulo = $_POST["titulo"];
        $sub_titulo = $_POST["sub_titulo"];
        $resumo_noticia = $_POST["resumo_noticia"];
        $materia = $_POST["materia"];
        $data = new DateTime($_POST["data"]);
        $data_formatada = $data->format('d/m/Y');

        $diretorio_imagens = "imagens_noticia/$titulo";
        if (!is_dir($diretorio_imagens)) {
            mkdir($diretorio_imagens, 0777, true);
        }

        $caminho_arquivo_banner = "$diretorio_imagens/banner_$id.jpeg";
        $caminho_arquivo_principal = "$diretorio_imagens/principal_$id.jpeg";

        // Redimensionar imagens
        $bannerRedimensionado = redimensionarImagem($img_banner["tmp_name"], 940, 240);
        $principalRedimensionado = redimensionarImagem($img_principal["tmp_name"], 1920, 960);

        if ($bannerRedimensionado === false || $principalRedimensionado === false) {
            $mensagem = "Erro ao redimensionar a imagem.";
        } else {
            // Salvar imagens redimensionadas
            switch ($img_banner["type"]) {
                case "image/jpeg":
                    imagejpeg($bannerRedimensionado, $caminho_arquivo_banner);
                    break;
                case "image/png":
                    imagepng($bannerRedimensionado, $caminho_arquivo_banner);
                    break;
                case "image/gif":
                    imagegif($bannerRedimensionado, $caminho_arquivo_banner);
                    break;
                case "image/webp":
                    imagewebp($bannerRedimensionado, $caminho_arquivo_banner);
                    break;
            }

            switch ($img_principal["type"]) {
                case "image/jpeg":
                    imagejpeg($principalRedimensionado, $caminho_arquivo_principal);
                    break;
                case "image/png":
                    imagepng($principalRedimensionado, $caminho_arquivo_principal);
                    break;
                case "image/gif":
                    imagegif($principalRedimensionado, $caminho_arquivo_principal);
                    break;
                case "image/webp":
                    imagewebp($principalRedimensionado, $caminho_arquivo_principal);
                    break;
            }

            imagedestroy($bannerRedimensionado);
            imagedestroy($principalRedimensionado);

            $sql = "UPDATE noticias SET 
                        cod_usuario = ?, 
                        nome = ?, 
                        img_banner = ?, 
                        img_noticia = ?, 
                        titulo = ?, 
                        sub_titulo = ?, 
                        resumo_noticia = ?, 
                        materia = ?, 
                        data = ? 
                    WHERE cod_noticia = ?";

            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("sssssssssi", $cod_usuario, $nome, $caminho_arquivo_banner, $caminho_arquivo_principal, $titulo, $sub_titulo, $resumo_noticia, $materia, $data_formatada, $id);
                if ($stmt->execute()) {
                    $mensagem = "Notícia atualizada com sucesso!";
                    echo("<meta http-equiv='refresh' content='1'>");
                } else {
                    $mensagem = "Erro ao atualizar dados no banco de dados: " . $stmt->error;
                }
            } else {
                $mensagem = "Erro ao preparar a declaração SQL: " . $conn->error;
            }
        }
    } else {
        $mensagem = "Erro no upload do(s) arquivo(s).";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Incluir o CkEditor -->
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

    <title>Editar Notícia</title>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5">
                    <div class="card-header">
                        <h4 class="card-title">Editar Notícia</h4>
                    </div>
                    <div class="card-body">
                        <?php if ($mensagem): ?>
                        <div class="alert alert-info">
                            <?php echo htmlspecialchars($mensagem); ?>
                        </div>
                        <?php endif; ?>
                        <form method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="titulo">Título:</label>
                                <input type="text" class="form-control" name="titulo" value="<?php echo htmlspecialchars($nots['titulo']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="sub_titulo">Subtítulo:</label>
                                <input type="text" class="form-control" name="sub_titulo" value="<?php echo htmlspecialchars($nots['sub_titulo']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="resumo_noticia">Resumo da notícia:</label>
                                <textarea name="resumo_noticia" rows="10" class="form-control" id="resumo_noticia" required><?php echo htmlspecialchars($nots['resumo_noticia']); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="materia" class="form-label">Matéria:</label>
                                <textarea name="materia" rows="20" class="form-control" id="materia" required><?php echo htmlspecialchars($nots['materia']); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="img_banner">Imagem Banner:</label>
                                <input type="file" name="img_banner" required>
                            </div>
                            <div class="form-group">
                                <label for="img_noticia">Imagem Principal:</label>
                                <input type="file" name="img_noticia" required>
                            </div>
                            <div class="form-group">
                                <label for="data">Data:</label>
                                <input type="date" class="form-control" id="data" name="data" value="<?php echo date('Y-m-d', strtotime($nots['data'])); ?>" required>
                            </div>

                            <div class="form-group">
                            <label for="data">Status:</label>
                            <select name="status" id="status" required>
                                <option value="">Selecione uma ação</option>
                                <option value="Publicada">Publicar</option>
                                <option value="Não Publicada">Não publicar</option>
                            </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                        </form>
                        <script>
                            CKEDITOR.replace('materia');
                            CKEDITOR.replace('resumo_noticia');
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
<?php include './footer.php'; ?>

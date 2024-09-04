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

function redimensionarImagem($arquivo, $largura_nova, $altura_nova, $caminho_destino) {
    // Obtém as dimensões e o tipo da imagem original
    list($largura_original, $altura_original, $tipo) = getimagesize($arquivo);

    // Cria uma nova imagem em branco com as novas dimensões
    $imagem_redimensionada = imagecreatetruecolor($largura_nova, $altura_nova);

    // Cria a imagem original a partir do tipo de arquivo
    switch ($tipo) {
        case IMAGETYPE_JPEG:
            $imagem_original = imagecreatefromjpeg($arquivo);
            break;
        case IMAGETYPE_PNG:
            $imagem_original = imagecreatefrompng($arquivo);
            imagealphablending($imagem_redimensionada, false);
            imagesavealpha($imagem_redimensionada, true);
            $transparente = imagecolorallocatealpha($imagem_redimensionada, 0, 0, 0, 127);
            imagefill($imagem_redimensionada, 0, 0, $transparente);
            break;
        case IMAGETYPE_GIF:
            $imagem_original = imagecreatefromgif($arquivo);
            $transparente = imagecolorallocatealpha($imagem_redimensionada, 0, 0, 0, 127);
            imagefill($imagem_redimensionada, 0, 0, $transparente);
            imagecolortransparent($imagem_redimensionada, $transparente);
            break;
        case IMAGETYPE_WEBP:
            $imagem_original = imagecreatefromwebp($arquivo);
            break;
        default:
            throw new Exception('Tipo de imagem não suportado.');
    }

    // Redimensiona a imagem
    imagecopyresampled($imagem_redimensionada, $imagem_original, 0, 0, 0, 0, $largura_nova, $altura_nova, $largura_original, $altura_original);

    // Salva a imagem redimensionada no formato original
    switch ($tipo) {
        case IMAGETYPE_JPEG:
            imagejpeg($imagem_redimensionada, $caminho_destino, 90);
            break;
        case IMAGETYPE_PNG:
            imagepng($imagem_redimensionada, $caminho_destino);
            break;
        case IMAGETYPE_GIF:
            imagegif($imagem_redimensionada, $caminho_destino);
            break;
        case IMAGETYPE_WEBP:
            imagewebp($imagem_redimensionada, $caminho_destino);
            break;
    }

    imagedestroy($imagem_original);
    imagedestroy($imagem_redimensionada);
}
?>

<?php
include './config/database.php';
session_start();
include './header.php';

$mensagem = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["img_banner"]) && isset($_FILES["img_noticia"])) {
        $img_banner = $_FILES["img_banner"];
        $img_principal = $_FILES["img_noticia"];

        if ($img_banner["error"] == UPLOAD_ERR_OK && $img_principal["error"] == UPLOAD_ERR_OK) {
            $nome = $_SESSION['nome'];
            $cod_usuario = $_SESSION['cod_usuario'];
            $titulo = $_POST["titulo"];
            $sub_titulo = $_POST["sub_titulo"];
            $resumo_noticia = $_POST["resumo_noticia"];
            $materia = $_POST["materia"];
            $data = new DateTime($_POST["data"]);
            $data_formatada = $data->format('d/m/Y');
            $status = $_POST['status'];

            if (empty($mensagem)) {
                $resultado = mysqli_query($conn, "SELECT max(cod_noticia) AS max_cod FROM noticias");
                if (!$resultado) {
                    $mensagem = "Erro ao executar a consulta: " . mysqli_error($conn);
                } else {
                    $cod_noticia = mysqli_fetch_array($resultado)['max_cod'] + 1;

            $diretorio_imagens = "imagens_noticia/noticia_$cod_noticia";
            if (!is_dir($diretorio_imagens)) {
                if (!mkdir($diretorio_imagens, 0777, true)) {
                    $mensagem = "Erro ao criar o diretório: $diretorio_imagens";
                }
            }


                    $extensao_banner = pathinfo($img_banner["name"], PATHINFO_EXTENSION);
                    $extensao_principal = pathinfo($img_principal["name"], PATHINFO_EXTENSION);

                    $caminho_arquivo_banner = "$diretorio_imagens/banner_$cod_noticia.$extensao_banner";
                    $caminho_arquivo_principal = "$diretorio_imagens/principal_$cod_noticia.$extensao_principal";

                    if (move_uploaded_file($img_banner["tmp_name"], $caminho_arquivo_banner) &&
                        move_uploaded_file($img_principal["tmp_name"], $caminho_arquivo_principal)) {
                        
                        // Redimensionar o banner
                        redimensionarImagem($caminho_arquivo_banner, 940, 240, $caminho_arquivo_banner);
                        
                        // Redimensionar a imagem principal
                        redimensionarImagem($caminho_arquivo_principal, 1920, 960,  $caminho_arquivo_principal);

                        $sql = "INSERT INTO noticias (cod_usuario, nome, img_banner, img_noticia, titulo, sub_titulo, resumo_noticia, materia, data, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                        $stmt = $conn->prepare($sql);
                        if ($stmt) {
                            $stmt->bind_param("ssssssssss", $cod_usuario, $nome, $caminho_arquivo_banner, $caminho_arquivo_principal, $titulo, $sub_titulo, $resumo_noticia, $materia, $data_formatada, $status);
                            if ($stmt->execute()) {
                                $mensagem = "Notícia postada com sucesso!";
                                echo("<meta http-equiv='refresh' content='1'>");
                            } else {
                                $mensagem = "Erro ao inserir dados no banco de dados: " . $stmt->error;
                            }
                        } else {
                            $mensagem = "Erro ao preparar a declaração SQL: " . $conn->error;
                        }
                    } else {
                        $mensagem = "Erro ao mover o(s) arquivo(s) para o diretório.";
                    }
                }
            }
        } else {
            $mensagem = "Erro no upload do(s) arquivo(s).";
        }
    } else {
        $mensagem = "Erro no upload do(s) arquivo(s).";
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <title>Envio de Notícias</title>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5">
                    <div class="card-header">
                        <h4 class="card-title">Envio de Notícia</h4>
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
                                <input type="text" class="form-control" name="titulo" required>
                            </div>
                            <div class="form-group">
                                <label for="sub_titulo">Subtítulo:</label>
                                <input type="text" class="form-control" name="sub_titulo" required>
                            </div>
                            <div class="form-group">
                                <label for="resumo_noticia">Resumo da notícia:</label>
                                <textarea name="resumo_noticia" rows="10" class="form-control" id="resumo_noticia" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="materia" class="form-label">Matéria:</label>
                                <textarea name="materia" rows="20" class="form-control" id="materia" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="img_banner">Imagem Banner (Resolução Recomendada: 940x240):</label>
                                <input class="form-control-file" type="file" name="img_banner" required>
                            </div>
                            <div class="form-group">
                                <label for="img_noticia">Imagem Principal (Resolução Recomendada: 1920x1080):</label>
                                <input class="form-control-file" type="file" name="img_noticia" required>
                            </div>
                            <div class="form-group">
                                <label for="data">Data:</label>
                                <input type="date" class="form-control" id="data" name="data" required>
                            </div>
                            <div class="form-group">
                                <label for="status">Status:</label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="">Selecione uma opção</option>
                                    <option value="Publicada">Publicar</option>
                                    <option value="Não Publicada">Não publicar</option>
                                </select>
                            </div>
                            <a href="dashboard.php" class="btn btn-secondary" role="button">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Cadastrar</button>
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
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

$mensagem = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["img_car"])) {
        $img_car = $_FILES["img_car"];

        if ($img_car["error"] == UPLOAD_ERR_OK ) {
            $cod_usuario = $_SESSION['cod_usuario'];
            $titulo_car = $_POST["titulo_car"];
            $desc_car = $_POST["desc_car"];
            $status = $_POST["status"];

            $diretorio_imagens = "imagens_carrossel";
            if (!is_dir($diretorio_imagens)) {
                mkdir($diretorio_imagens, 0777, true);
            }

            $resultado = mysqli_query($conn, "SELECT max(cod_car) AS max_cod FROM carrossel");
            if (!$resultado) {
                $mensagem = "Erro ao executar a consulta: " . mysqli_error($conn);
            } else {
                $cod_car = mysqli_fetch_array($resultado)['max_cod'] + 1;

            $caminho_arquivo_car = "$diretorio_imagens/carrossel_$cod_car.jpeg";

            // Redimensionar imagens
            $principalRedimensionado = redimensionarImagem($img_car["tmp_name"], 1920, 960);

            if ($principalRedimensionado === false) {
                $mensagem = "Erro ao redimensionar a imagem.";
            } else {

            // Salvar imagens redimensionadas
            switch ($img_car["type"]) {
                case "image/jpeg":
                    imagejpeg($principalRedimensionado, $caminho_arquivo_car);
                    break;
                case "image/png":
                    imagepng($principalRedimensionado, $caminho_arquivo_car);
                    break;
                case "image/gif":
                    imagegif($principalRedimensionado, $caminho_arquivo_car);
                    break;
                case "image/webp":
                    imagewebp($principalRedimensionado, $caminho_arquivo_car);
                    break;
            }

            imagedestroy($principalRedimensionado);

            $sql = "INSERT INTO carrossel (cod_usuario, img_car, titulo_car, desc_car, status) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("sssss", $cod_usuario, $caminho_arquivo_car, $titulo_car, $desc_car, $status);
                if ($stmt->execute()) {
                    $mensagem = "Carrossel postado com sucesso!";
                    echo("<meta http-equiv='refresh' content='1'>");
                } else {
                    $mensagem = "Erro ao inserir dados no banco de dados: " . $stmt->error;
                }
            } else {
                $mensagem = "Erro ao preparar a declaração SQL: " . $conn->error;
            }
        }
            }
        } else {
            $mensagem = "Erro ao mover o(s) arquivo(s) para o diretório.";
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

    <title>Envio de Imagens Carrossel</title>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5">
                    <div class="card-header">
                        <h4 class="card-title">Envio de Imagens Carrossel</h4>
                    </div>
                    <div class="card-body">
                        <?php if ($mensagem): ?>
                        <div class="alert alert-info">
                            <?php echo htmlspecialchars($mensagem); ?>
                        </div>
                        <?php endif; ?>
                        <form method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="titulo_car">Título:</label>
                                <input type="text" class="form-control" name="titulo_car" maxlength="50" >
                            </div>
                            <div class="form-group">
                                <label for="desc_car">Descrição:</label>
                                <input type="text" class="form-control" name="desc_car" maxlength="80" >
                            </div>
                            <div class="form-group">
                                <label for="img_car">Imagem Carrossel (Resolução Recomendada: 1920x1080):</label>
                                <input type="file" name="img_car" required>
                            </div>
                            
                            <div class="form-group">
                            <label for="status">Status:</label>
                            <select name="status" id="status" required>
                                <option value="">Selecione uma opção</option>
                                <option value="Publicada">Publicar</option>
                                <option value="Não Publicada">Não publicar</option>
                            </select>
                            </div>

                            <a href="dashboard.php" class="btn btn-secondary" role="button">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Cadastrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
<?php include './footer.php'; ?>
</body>

</html>
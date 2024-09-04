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
$error = '';
// Verificar se o usuário está logado e se é um gestor
if (!isset($_SESSION['cod_usuario'])) {
    header("Location: ./login.php");
    exit();
}

if (!$id) {
    header("Location: ./listing.php");
    exit();
} else {
    $sql = "SELECT * FROM ordem_servico WHERE id_os='$id'";
    $result = $conn->query($sql);
    $ordem_servico = $result->fetch_assoc();

    if (!$ordem_servico) {
        header("Location: ./listing.php");
        exit();
    }
}

// Obter dados do usuário para exibir no formulário
?>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edição de Ordens de Serviço</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="imgs/favicon.png" type="image/x-icon">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Roboto', sans-serif;
        }
        .card {
            position:relative;
            display:flex;
            flex-direction: column;
            word-wrap: break-word;
            min-width: 0;
            border: 1px solid rgba(0, 0, 0, .125);
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: .25rem;
            padding: 0px;   
        }
        .card-title {
            color: #000;
            margin-bottom: .75rem;
            font-weight: 500;
        }

        .mt-5, .my-5 {
            margin-top: 3rem !important;
        }

        .card-header{
            padding: .75rem 1.25rem;
            margin-bottom: 0;
            background-color: rgba(0, 0, 0, .03);
            border-bottom: 1px solid rgba(0, 0, 0, .125);
        }

        .card-header:first-child {
            border-radius: calc(.25rem - 1px) calc(.25rem - 1px) 0 0;
        }

        .h4{
            font-size: 1.5rem;
        }

        .form-select, .form-control {
            border-radius: 8px;
        }
        .btn-primary, .btn-outline-primary, .btn-success {
            border-radius: 8px;
        }
        .btn-primary, .btn-success {
            background-color: #007bff;
            border: none;
        }
        .btn-outline-primary {
            color: #007bff;
            border-color: #007bff;
        }
        .btn-outline-primary:hover {
            background-color: #007bff;
            color: #fff;
        }
        .hideBtn {
            display: none;
        }
        .divider {
            border-bottom: 1px solid #dee2e6;
            margin: 1.5rem 0;
        }
    </style>
</head>
<body>
    <?php
        require_once './header.php';
    ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="card" style="width: 48rem;">
                <div class="card-header">
                    <h4 class="card-title">Edição de Ordens de Serviço</h4>
                </div>
    <?php
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
    ?>
                <div class="card-body">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=$id")?>" method="post" class="form" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="area" class="form-label">Área (Clique para Alterar)</label>
                            <select name="area" id="area" class="form-select">
                                <?php
                                    $area_o = $ordem_servico['area'];
                                    echo "<option value='$area_o' selected>$area_o</option>";                                       
                                    $sql = "SELECT * FROM areas WHERE nome_area != '$area_o'";
                                    $result = mysqli_query($conn, $sql);
                                    if($result && mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $nome = $row['nome_area'];
                                            echo "<option value='$nome'>$nome</option>";
                                        }
                                    }
                                ?>
                            </select>
                        </div>    
                        <div class="mb-3">
                            <label for="ambiente" class="form-label">Ambiente (Clique para Alterar)</label>
                            <select name="ambiente" id="ambiente" class="form-select">
                                <?php
                                    $ambiente_o = $ordem_servico['ambiente'];
                                    echo "<option value='$ambiente_o' selected>$ambiente_o</option>";                                       
                                    $sql = "SELECT * FROM ambiente WHERE nome_ambiente != '$ambiente_o'";
                                    $result = mysqli_query($conn, $sql);
                                    if($result && mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $nome = $row['nome_ambiente'];
                                            echo "<option value='$nome'>$nome</option>";
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="inconformidade" class="form-label">Inconformidade (Clique para Alterar)</label>
                            <select name="inconformidade" id="inconformidade" class="form-select">
                                    <?php
                                        $inconformidade_o = $ordem_servico['inconformidade'];
                                        echo "<option value='$inconformidade_o' selected>$inconformidade_o</option>";                                       
                                        $sql = "SELECT * FROM inconformidades WHERE nome_inconformidade != '$inconformidade_o'";
                                        $result = mysqli_query($conn, $sql);
                                        if($result && mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $nome = $row['nome_inconformidade'];
                                                echo "<option value='$nome'>$nome</option>";
                                            }
                                        }
                                    ?>
                                </select>
                        </div>
                        <div class="mb-3">
                            <label for="prova_inconformidade" class="form-label">Nova Foto ou Vídeo (Sua imagem/vídeo antiga será substituída)</label>
                            <input type="file" class="form-control" name="prova_inconformidade" id="prova_inconformidade">
                        </div>
                        <div class="mb-3">
                            <label for="observacao" class="form-label">Observação</label>
                            <textarea name="observacao" id="observacao" class="form-control"><?php echo $ordem_servico['observacao'] ?></textarea>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary hideBtn" id="submitBtn">Finalizar Edição</button>
                        </div> 
                    </form>
                </div>
    <?php
        } else if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $area = $conn->real_escape_string($_POST['area']);
            $ambiente = $conn->real_escape_string($_POST['ambiente']);
            $inconformidade = $conn->real_escape_string($_POST['inconformidade']);
            $observacao = $conn->real_escape_string($_POST['observacao']);

            $sql = "UPDATE ordem_servico SET 
            area='$area', 
            ambiente='$ambiente', 
            inconformidade='$inconformidade',
            observacao='$observacao'";

            if($_FILES['prova_inconformidade']['error'] === 0){
                $solicitante = $_SESSION['nome'];
                $prova_inconformidade = $_FILES['prova_inconformidade'];
                $arquivo = explode('.',$prova_inconformidade['name']);
                $extensao = $arquivo[1];

                $dir = ('./Envios/'.$solicitante);
                if(!is_dir($dir)) {
                    mkdir($dir, 0777, true);
                }

                $dir_2 = "./Envios/$solicitante/inconformidade_$id.$extensao";

                if(move_uploaded_file($prova_inconformidade["tmp_name"], $dir_2)){
                    $sql .= ", upload = '$dir_2'";
                }
            }

            $sql .= " WHERE id_os = '$id'";

            if ($conn->query($sql) === TRUE) {
                echo"<div class=\"alert alert-success\" role=\"alert\">Ordem de Serviço Atualizada com Sucesso!</div>";
                echo "<script>setTimeout(()=>{window.location.href = 'listing.php'}, 2000)</script>";
                die();
            } else {
                $error = "Erro ao atualizar os dados: " . $conn->error;
                echo $error;
            }
        }
    ?>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <?php require_once './footer.php'; ?>
    </div>
</body>
</html>
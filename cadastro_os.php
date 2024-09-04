<?php
    session_start();
    require_once "config/database.php";

    $id_usuario = $_SESSION['cod_usuario'];
    if (!isset($id_usuario)) {
        echo "<script>window.location.href = 'login.php'</script>";
        die();
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitação de Ordens de Serviço</title>
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
<?php require_once './header.php'; ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="card" style="width: 48rem;">
                <div class="card-header">
                    <h4 class="card-title">Cadastro de Ordens de Serviço</h4>
                </div>
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
        ?>
                    <div class="card-body">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" class="form" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="area" class="form-label">Área</label>
                                <select name="area" id="area" class="form-select">
                                    <option value="" selected disabled hidden>Selecione uma Área</option>
                                        <?php   
                                            $sql = "SELECT * FROM areas";
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
                                <label for="ambiente" class="form-label">Ambiente</label>
                                <select name="ambiente" id="ambiente" class="form-select">
                                    <option value="" selected disabled hidden>Selecione um Ambiente</option>
                                        <?php   
                                            $sql = "SELECT * FROM ambiente";
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
                                <label for="inconformidade" class="form-label">Inconformidade</label>
                                <select name="inconformidade" id="inconformidade" class="form-select">
                                    <option value="" selected disabled hidden>Selecione uma Inconformidade</option>
                                        <?php   
                                            $sql = "SELECT * FROM inconformidades";
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
                                <label for="prova_inconformidade" class="form-label">Foto ou Vídeo (Opcional)</label>
                                <input type="file" name="prova_inconformidade" id="prova_inconformidade" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="observacao" class="form-label">Observação</label>
                                <textarea name="observacao" id="observacao"class="form-control" required></textarea>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary hideBtn" id="submitBtn">Finalizar Cadastro</button>
                            </div> 
                        </form>
                    </div>
        <?php
            }
            require_once "config/database.php";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {    
                date_default_timezone_set('America/Sao_Paulo');

                $solicitante = $_SESSION['nome'];
                $area = $_POST['area'];
                $ambiente = $_POST['ambiente'];
                $inconformidade = $_POST['inconformidade'];
                $data_solicitacao = date('Y-m-d H:i:s');
                $observacao = $_POST['observacao'];

                $sql = "";

                if($_FILES['prova_inconformidade']['error'] === 0){
                    $prova_inconformidade = $_FILES['prova_inconformidade'];
                    $arquivo = explode('.',$prova_inconformidade['name']);
                    $extensao = $arquivo[1];

                    $res = $conn->query("SELECT AUTO_INCREMENT as id_os FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'intranet_jfn' AND TABLE_NAME = 'ordem_servico';");
                    $id_os = $res->fetch_array()[0];

                    $dir = ('./Envios/'.$solicitante);
                    if(!is_dir($dir)) {
                        mkdir($dir, 0777, true);
                    }
                    $dir_2 = "./Envios/$solicitante/inconformidade_$id_os.$extensao";

                    if(move_uploaded_file($prova_inconformidade["tmp_name"], $dir_2)){
                        $sql = "INSERT INTO ordem_servico (solicitante, area, ambiente, inconformidade, data_solicitacao, observacao, upload, id_usuario) VALUES (\"$solicitante\", \"$area\", \"$ambiente\", \"$inconformidade\", \"$data_solicitacao\", \"$observacao\", \"$dir_2\", \"$id_usuario\")";
                    }
                } else {
                    $sql = "INSERT INTO ordem_servico (solicitante, area, ambiente, inconformidade, data_solicitacao, observacao, id_usuario) VALUES (\"$solicitante\", \"$area\", \"$ambiente\", \"$inconformidade\", \"$data_solicitacao\", \"$observacao\", \"$id_usuario\")";
                }
                
                if ($conn->query($sql) == TRUE){
                    echo"<div class=\"alert alert-success\" role=\"alert\">Ordem de Serviço Enviada com Sucesso!</div>";
                    echo "<script>setTimeout(()=>{window.location.href = 'listing.php'}, 2000)</script>";
                    die();
                }
                echo"<div class=\"alert alert-danger\" role=\"alert\">Não foi Possível Enviar a Ordem de Serviço!</div>";
            }
?>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </div>
</div>
    <?php require_once './footer.php'; ?>
</body>
</html>
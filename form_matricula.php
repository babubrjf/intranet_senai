<?php
date_default_timezone_set('America/Sao_Paulo');
include './nav_matricula.php';
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura dos dados do formulário
    $nome_aluno = $_POST["nome_aluno"];
    $data_nascimento = $_POST["data_nascimento"];
    $cidade_nascimento = $_POST["cidade_nascimento"];
    $mae = $_POST["mae"];
    $pai = $_POST["pai"];
    $cor = $_POST["cor"];
    $sexo = $_POST["sexo"];
    $estado_civil = $_POST["estado_civil"];
    $rg = $_POST["rg"];
    $orgao_emissor = $_POST["orgao_emissor"];
    $cpf = $_POST["cpf"];
    $endereco = $_POST["endereco"];
    $numero_endereco = $_POST["numero_endereco"];
    $complemento = $_POST["complemento"];
    $bairro = $_POST["bairro"];
    $cidade = $_POST["cidade"];
    $cep = $_POST["cep"];
    $email = $_POST["email"];
    $telefone = $_POST["telefone"];
    $escolaridade = $_POST["escolaridade"];
    $escola_origem = $_POST["escola_origem"];
    $deficiencia = $_POST["deficiencia"];
    $empresa = $_POST["empresa"];
    if (isset($_SESSION['perfil']) && $_SESSION['perfil'] == 'gestor') {
        $curso = $_POST["curso"];
    } else {
        $curso = $_GET["id"];
    }
    $data_cadastro = date("Y-m-d H:i:s");

    $sql = "INSERT INTO matricula (nome_aluno, data_nascimento, cidade_nascimento, mae, pai, cor, sexo, estado_civil, 
                                    rg, orgao_emissor, cpf, endereco, numero_endereco, complemento, bairro, cidade, 
                                    cep, email, telefone, escolaridade, escola_origem, deficiencia, empresa, data_cadastro, curso) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("ssssssssssssssssssssssssi", 
        $nome_aluno, $data_nascimento, $cidade_nascimento, $mae, $pai, $cor, $sexo, $estado_civil, 
        $rg, $orgao_emissor, $cpf, $endereco, $numero_endereco, $complemento, $bairro, $cidade, 
        $cep, $email, $telefone, $escolaridade, $escola_origem, $deficiencia, $empresa, $data_cadastro, $curso
    );

    if ($stmt->execute()) {
        echo "<script type='text/javascript'>
                alert('Matrícula Cadastrada com sucesso!');
                setTimeout(function(){
                    window.close();
                }, 3000);
              </script>";
    } else {
        echo "<script type='text/javascript'>
                alert('Erro ao cadastrar matrícula.');
                window.location.href='form_matricula.php';
              </script>" . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-group-small {
            display: flex;
            gap: 1rem;
        }
        .form-group-small .form-control {
            flex: 1;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-5">
                <div class="card-header">
                    <h4 class="card-title">Cadastro de Matrícula</h4>
                </div>
                <div class="card-body">
                    <form method="post">
                        <!-- Formulário com campos -->
                        <div class="form-group mb-3">
                            <label for="nome_aluno">Nome do Aluno:</label>
                            <input type="text" class="form-control" id="nome_aluno" name="nome_aluno" required>
                        </div>
                        <div class="form-group-small mb-3">
                            <div class="form-group flex-grow-1">
                                <label for="rg">RG:</label>
                                <input type="text" class="form-control" id="rg" name="rg" required>
                            </div>
                            <div class="form-group flex-grow-1">
                                <label for="orgao_emissor">Órgão Emissor:</label>
                                <input type="text" class="form-control" id="orgao_emissor" name="orgao_emissor">
                            </div>
                        </div>
                        <div class="form-group-small mb-3">
                            <div class="form-group flex-grow-1">
                                <label for="cpf">CPF:</label>
                                <input type="text" class="form-control" id="cpf" name="cpf" required>
                            </div>
                            <div class="form-group flex-grow-1">
                                <label for="cidade_nascimento">Cidade de Nascimento:</label>
                                <input type="text" class="form-control" id="cidade_nascimento" name="cidade_nascimento">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="data_nascimento">Data de Nascimento:</label>
                            <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required>
                        </div>
                        <div class="form-group-small mb-3">
                            <div class="form-group flex-grow-1">
                                <label for="mae">Nome da Mãe:</label>
                                <input type="text" class="form-control" id="mae" name="mae" required>
                            </div>
                            <div class="form-group flex-grow-1">
                                <label for="pai">Nome do Pai:</label>
                                <input type="text" class="form-control" id="pai" name="pai">
                            </div>
                        </div>
                        <div class="form-group-small mb-3">
                            <div class="form-group flex-grow-1">
                                <label for="cor">Cor:</label>
                                <select class="form-select" name="cor" id="cor">
                                    <option value="branca">Branco</option>
                                    <option value="preta">Preto</option>
                                    <option value="amarela">Amarelo</option>
                                    <option value="parda">Pardo</option>
                                    <option value="indigena">Indígena</option>
                                </select>
                            </div>
                            <div class="form-group flex-grow-1">
                                <label for="sexo">Sexo:</label>
                                <select class="form-select" name="sexo" id="sexo">
                                    <option value="masculino">Masculino</option>
                                    <option value="feminino">Feminino</option>
                                </select>
                            </div>
                            <div class="form-group flex-grow-1">
                                <label for="estado_civil">Estado Civil:</label>
                                <select class="form-select" name="estado_civil" id="estado_civil">
                                    <option value="Solteiro">Solteiro</option>
                                    <option value="Casado">Casado</option>
                                    <option value="Divorciado">Divorciado</option>
                                    <option value="Viuvo">Viuvo</option>
                                    <option value="Desquitado">Desquitado</option>
                                    <option value="Outro">Outro</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="endereco">Endereço:</label>
                            <input type="text" class="form-control" id="endereco" name="endereco" required>
                        </div>
                        <div class="form-group-small mb-3">
                            <div class="form-group flex-grow-1">
                                <label for="numero_endereco">Número:</label>
                                <input type="text" class="form-control" id="numero_endereco" name="numero_endereco" required>
                            </div>
                            <div class="form-group flex-grow-1">
                                <label for="complemento">Complemento:</label>
                                <input type="text" class="form-control" id="complemento" name="complemento">
                            </div>
                        </div>
                        <div class="form-group-small mb-3">
                            <div class="form-group flex-grow-1">
                                <label for="bairro">Bairro:</label>
                                <input type="text" class="form-control" id="bairro" name="bairro" required>
                            </div>
                            <div class="form-group flex-grow-1">
                                <label for="cidade">Cidade:</label>
                                <input type="text" class="form-control" id="cidade" name="cidade">
                            </div>
                        </div>
                        <div class="form-group-small mb-3">
                            <div class="form-group flex-grow-1">
                                <label for="cep">CEP:</label>
                                <input type="text" class="form-control" id="cep" name="cep" required>
                            </div>
                            <div class="form-group flex-grow-1">
                                <label for="telefone">Telefone:</label>
                                <input type="text" class="form-control" id="telefone" name="telefone">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="escolaridade">Escolaridade:</label>
                            <input type="text" class="form-control" id="escolaridade" name="escolaridade" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="escola_origem">Escola de Origem:</label>
                            <input type="text" class="form-control" id="escola_origem" name="escola_origem" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="deficiencia">Possui Alguma Deficiência?</label>
                            <input type="text" class="form-control" id="deficiencia" name="deficiencia">
                        </div>
                        <div class="form-group mb-3">
                            <label for="empresa">Nome da Empresa (Caso Trabalhe):</label>
                            <input type="text" class="form-control" id="empresa" name="empresa">
                        </div>
                        <?php if (isset($_SESSION['perfil']) && $_SESSION['perfil'] == 'gestor') { ?>
                        <div class="form-group mb-3">
                            <label for="curso">Curso:</label>
                            <input type="text" class="form-control" id="curso" name="curso" required>
                        </div>
                        <?php } ?>
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Importando o JavaScript do Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

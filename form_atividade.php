<?php
session_start();
require_once "config/database.php";

$id_usuario = $_SESSION['cod_usuario'];
if (!isset($id_usuario)) {
    echo "<script>window.location.href = 'login.php'</script>";
    die();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cod_usuario = $_SESSION["cod_usuario"];
    $data = $_POST["data"];
    $carga_inicial = $_POST["carga_inicial"];
    $carga_final = $_POST["carga_final"];
    $atividade = $_POST["atividade"];
    $cod_atividade_predef = $_POST["cod_atividade_predef"];

    $inicio = new DateTime($carga_inicial);
    $fim = new DateTime($carga_final);

    $diferenca = $inicio->diff($fim);
    $horas = $diferenca->h;
    $minutos = $diferenca->i;

    $total_horas = $diferenca->days * 24 + $horas;

    $tempo_total = str_pad($total_horas, 2, '0', STR_PAD_LEFT) . ':' . str_pad($minutos, 2, '0', STR_PAD_LEFT);

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) { 
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    $sql = "INSERT INTO atividades_extras (cod_usuario, data, carga_inicial, carga_final, horas, atividade, cod_atividade_predef) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssi", $cod_usuario, $data, $carga_inicial, $carga_final, $tempo_total, $atividade, $cod_atividade_predef);

    if ($stmt->execute()) {
        echo "<script type='text/javascript'>alert('Atividade Cadastrada com sucesso!'); window.location.href='list_atividades.php';</script>";
    } else {
        echo "<script type='text/javascript'>alert('Erro Ao Cadastrar Atividade.'); window.location.href='form_atividade.php';</script>" . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<?php include './header.php'; ?>

<style>
    @media (max-width: 576px) {
        #cod_atividade_predef {
            max-width: 100%;
        }
    }
</style>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card mt-5">
            <div class="card-header">
                <h4 class="card-title">Cadastro de Atividades Extras</h4>
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="form-group">
                        <label for="data">Data:</label>
                        <input type="date" class="form-control" id="data" name="data" required>
                    </div>
                    <div class="form-group">
                        <label for="carga_inicial">Início:</label>
                        <input type="time" class="form-control" id="carga_inicial" name="carga_inicial" required>
                    </div>
                    <div class="form-group">
                        <label for="carga_final">Término:</label>
                        <input type="time" class="form-control" id="carga_final" name="carga_final" required>
                    </div>
                    <div class="form-group">
                        <label for="atividade">Descrição da Atividade:</label>
                        <textarea class="form-control" id="atividade" name="atividade" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="cod_atividade_predef" class="form-label">Atividade Predefinida:</label>
                        <select class="form-select form-select-sm" id="cod_atividade_predef" name="cod_atividade_predef" required>
                            <?php
                            $conn = new mysqli($servername, $username, $password, $dbname);
                            if ($conn->connect_error) {
                                die("Erro na conexão com o banco de dados: " . $conn->connect_error);
                            }

                            $sql = "SELECT cod_ativ, atividade FROM atividades_predefinidas";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value=\"" . $row["cod_ativ"] . "\">" . $row["atividade"] . "</option>";
                                }
                            }

                            $conn->close();
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                    <a href="list_atividades.php" class="btn btn-secondary" role="button">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>

</div>
<?php include './footer.php'; ?>

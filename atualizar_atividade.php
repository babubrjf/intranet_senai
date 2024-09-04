<?php
    session_start();
    require_once "config/database.php";

    $id_usuario = $_SESSION['cod_usuario'];
    if (!isset($id_usuario)) {
        echo "<script>window.location.href = 'login.php'</script>";
        die();
    }

$toastMessage = "";

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

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    $sql = "UPDATE atividades_extras SET data=?, carga_inicial=?, carga_final=?, horas=?, atividade=?, cod_atividade_predef=? WHERE cod_atividade=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssisii", $data, $carga_inicial, $carga_final, $horas, $atividade, $cod_atividade_predef, $cod_atividade);

    if ($stmt->execute()) {
        $toastMessage = "Atividade atualizada com sucesso!";
    } else {
        $toastMessage = "Erro ao atualizar atividade.";
        echo "<script type='text/javascript'>alert('Erro Ao Atualizar Atividade.'); window.location.href='atualizar_atividade.php';</script>" . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    $sql = "SELECT data, carga_inicial, carga_final, atividade, cod_atividade_predef FROM atividades_extras WHERE cod_atividade=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cod_atividade);
    $stmt->execute();
    $stmt->bind_result($data, $carga_inicial, $carga_final, $atividade, $cod_atividade_predef);
    $stmt->fetch();
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
    <div class="col-md-6">
        <div class="card mt-5">
            <div class="card-header">
                <h4 class="card-title" style="text-align: center">Atualização de Atividades Extras</h4>
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="form-group">
                        <label for="data">Data:</label>
                        <input type="date" class="form-control" id="data" name="data" value="<?php echo $data; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="carga_inicial">Início:</label>
                        <input type="time" class="form-control" id="carga_inicial" name="carga_inicial" value="<?php echo $carga_inicial; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="carga_final">Término:</label>
                        <input type="time" class="form-control" id="carga_final" name="carga_final" value="<?php echo $carga_final; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="atividade">Descrição da Atividade:</label>
                        <textarea class="form-control" id="atividade" name="atividade" rows="3" required><?php echo $atividade; ?></textarea>
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
                                    $selected = ($row["cod_ativ"] == $cod_atividade_predef) ? "selected" : "";
                                    echo "<option value=\"" . $row["cod_ativ"] . "\" $selected>" . $row["atividade"] . "</option>";
                                }
                            }

                            $conn->close();
                            ?>
                        </select>
                    </div>
    
                    <button type="submit" class="btn btn-primary">ATUALIZAR</button>
                    <a href="list_atividades.php" class="btn btn-secondary" role="button">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>

</div>
<?php include './footer.php'; ?>

<script>
    $(document).ready(function() {
        // Fechar o toast ao clicar no botão 'X'
        $('.toast .close').on('click', function() {
            $(this).closest('.toast').toast('hide');
        });

        <?php if (!empty($toastMessage)) : ?>
            // Exibir o toast de sucesso ao atualizar
            $('.toast-body').text('<?php echo $toastMessage; ?>');
            $('.toast').toast('show');
        <?php endif; ?>
    });
</script>

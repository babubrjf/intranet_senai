<?php
    session_start();
    require_once "config/database.php";

    $id_usuario = $_SESSION['cod_usuario'];
    if (!isset($id_usuario)) {
        echo "<script>window.location.href = 'login.php'</script>";
        die();
    }

$id = $_SESSION["cod_usuario"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $inicio_comp = $_POST["inicio_comp"];
    $final_comp = $_POST["final_comp"];
    $manha = $_POST["manha"];
    $tarde = $_POST["tarde"];
    $noite = $_POST["noite"];
    $turno = $_POST["turno"];

    $horas = $_POST["horas"];

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    $sql = "INSERT INTO solicitacao (inicio_comp, final_comp, turno, horas, colaborador_cod_usuario) VALUES (?, ?, ?, ?, $id)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $inicio_comp, $final_comp, $turno, $horas);

    if ($stmt->execute()) {
        echo "<script type='text/javascript'>alert('Solicitação cadastrada com sucesso!'); window.location.href='list_req.php';</script>";
        require 'email.php';
    } else {
        echo "<script type='text/javascript'>alert('Erro Ao Cadastrar Atividade.'); window.location.href='list_req.php';</script>" . $stmt->error;
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
                <h4 class="card-title">Registro de Compensação de Horas</h4>
            </div>
            <div class="card-body">
                <form method="post" id="compForm">
                    <div class="form-group">
                        <label for="inicio_comp">Início:</label>
                        <input type="date" class="form-control" id="inicio_comp" name="inicio_comp" required>
                    </div>
                    <div class="form-group">
                        <label for="final_comp">Término:</label>
                        <input type="date" class="form-control" id="final_comp" name="final_comp" required>
                    </div>
                    <div class="form-group">
                        <label for="turno">Turno (Selecione uma opção):</label><br>
                        <select class="form-select form-select-lg" aria-label="Large select example" id="turno" name="turno" required>
                            <option selected></option>
                            <option value="MANHÃ">MANHÃ</option>
                            <option value="MANHÃ E TARDE">MANHÃ E TARDE</option>
                            <option value="TARDE">TARDE</option>
                            <option value="TARDE E NOITE">TARDE E NOITE</option>
                            <option value="NOITE">NOITE</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="horas">Quantidade de horas a compensar:</label>
                        <input type="number" min="1" class="form-control" id="horas" name="horas" required>
                    </div>
                    <button type="submit" id="submitBtn" class="btn btn-primary" disabled>Cadastrar</button>
                    <a href="list_req.php" class="btn btn-secondary" role="button">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    window.onload = function() {

var blockUI = document.createElement("div");
blockUI.setAttribute("id", "blocker");
document.body.appendChild(blockUI);


var cover = document.getElementById("blocker").style.display = "none";

var btn = document.getElementById("submitBtn");

btn.onclick = block;

}

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('compForm');
        const submitBtn = document.getElementById('submitBtn');
        
        form.addEventListener('input', function() {
            let allFilled = true;
            form.querySelectorAll('[required]').forEach(function(input) {
                if (!input.value) {
                    allFilled = false;
                }
            });
            submitBtn.disabled = !allFilled;
        });
    });
</script>

<?php include './footer.php'; ?>

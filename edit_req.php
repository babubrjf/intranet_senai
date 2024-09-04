<?php
session_start();
require_once "config/database.php";

$id_usuario = $_SESSION['cod_usuario'];
if (!isset($id_usuario)) {
    echo "<script>window.location.href = 'login.php'</script>";
    die();
} else if (!isset($_GET['id'])) {
    echo "<script>window.location.href = 'list_req.php'</script>";
    die();
}

$cod_sol = $_GET['id'];
$error = "Erro ao atualizar os dados: " . $conn->error;


// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inicio_comp = $conn->real_escape_string($_POST['inicio_comp']);
    $final_comp = $conn->real_escape_string($_POST['final_comp']);
    $horas = $conn->real_escape_string($_POST['horas']);    
    $turno = $conn->real_escape_string($_POST['turno']);  
      

    $horas = $conn->real_escape_string($_POST['horas']);

    $sql = "UPDATE solicitacao SET 
            inicio_comp='$inicio_comp', 
            final_comp='$final_comp',             
            horas='$horas',
            turno='$turno'
            WHERE cod_sol='$cod_sol'";

    if ($conn->query($sql) === TRUE) {
        header("Location: ./list_req.php?message=success");
        exit();
    } else {
        echo $error;
    }
}



// Obter dados do usuário para exibir no formulário
$sql = "SELECT * FROM solicitacao WHERE cod_sol='$cod_sol'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

if (!$user) {
    header("Location: ./edit_req.php");
    exit();
}

include './header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                Editar Solicitação
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="form-group">
                        <label for="inicio_comp">Início:</label>
                        <input type="date" class="form-control" id="inicio_comp" name="inicio_comp" value="<?php echo $user['inicio_comp']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="final_comp">Término:</label>
                        <input type="date" class="form-control" id="final_comp" name="final_comp" value="<?php echo $user['final_comp']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="turno">Turno (Selecione uma opção):</label><br>
                        <select class="form-select form-select-lg" aria-label="Large select example" id="turno" name="turno" required>
                        <option selected><?php echo $user['turno']; ?></option>
                        <option value="MANHÃ">MANHÃ</option>
                        <option value="TARDE">TARDE</option>
                        <option value="MANHÃ E TARDE">MANHÃ E TARDE</option>
                        <option value="TARDE">TARDE</option>
                        <option value="NOITE">NOITE</option>
                        <option value="TARDE E NOITE">TARDE E NOITE</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="horas">Quantidade de horas a compensar:</label>
                        <input type="number" min="1" class="form-control" id="horas" name="horas" value="<?php echo $user['horas']; ?>"required>
                    </div>
                    <button type="submit" class="btn btn-primary">Atualizar</button>
                    <a href="./list_req.php" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include './footer.php'; ?>
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
require './mailer/vendor/autoload.php'; // Autoload PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include './config/database.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    
    $sql = "SELECT nome, gestor_cod_usuario FROM Usuarios WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $gestor_cod_usuario = $user['gestor_cod_usuario'];
        $colaborador = $user['nome'];

        $sql = "SELECT nome, email FROM Usuarios WHERE cod_usuario='$gestor_cod_usuario'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $gestor = $result->fetch_assoc();
            $gestor_email = $gestor['email'];
            
            
            // Configurar e enviar o e-mail
            $mail = new PHPMailer(true);

            try {
                // Configurações do servidor
                $mail->isSMTP();
                $mail->Host = 'mail.senaijf.com.br'; // Defina seu servidor SMTP
                $mail->SMTPAuth = true;
                $mail->Username = 'portaljfn@senaijf.com.br'; // Seu endereço de e-mail SMTP
                $mail->Password = '#jfn13150'; // Sua senha SMTP
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Remetente e destinatário
                $mail->setFrom('portaljfn@senaijf.com.br', 'Portal do Colaborador');
                $mail->addAddress($gestor_email);

                // Conteúdo do e-mail
                $mail->isHTML(true);
                $mail->Subject = 'Recuperar Senha de Colaborador';
                $mail->Body = 'O colaborador' . $colaborador . ' solicitou a recuperação de senha.';

                $mail->send();
                $success = 'Um e-mail foi enviado ao seu gestor.';
            } catch (Exception $e) {
                $error = "Erro ao enviar o e-mail: {$mail->ErrorInfo}";
            }
        } else {
            $error = 'Não foi possível encontrar o gestor do usuário.';
        }
    } else {
        $error = 'Email não encontrado.';
    }
}
?>

<?php include './header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                Recuperar Senha
            </div>
            <div class="card-body">
                <?php if ($error) { ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php } ?>
                <?php if ($success) { ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php } ?>
                <form method="post">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Recuperar Senha</button>
                </form>
            </div>
        </div>
    </div>
</div>

</div>
<?php include './footer.php'; ?>
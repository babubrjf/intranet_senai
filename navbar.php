<!-- /includes/navbar.php -->
<?php
@session_start();
$perfil = $_SESSION['perfil'] ?? 'colaborador';
$nome = $_SESSION['nome'] ?? 'nome';
?>

<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #1a61b6;">
    <a class="navbar-brand" href="./dashboard.php">
    <img src="./img/logo_senai.png" alt="Logo" height="30"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <?php if ($perfil == 'gestor') { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="acoesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Minhas Ações</a>
                    <div class="dropdown-menu" aria-labelledby="acoesDropdown">
                        <a class="dropdown-item" href="./cadastro_os.php">Criar Ordem de Serviço</a>
                        <a class="dropdown-item" href="./listing.php">Listar Ordens de Serviços</a>
                        <!-- <a class="dropdown-item" href="#">Demais ações</a> -->
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="gestaoDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Gestão</a>
                    <div class="dropdown-menu" aria-labelledby="gestaoDropdown">
                        <a class="dropdown-item" href="./listar_cursos.php">Listar Cursos</a>
                        <a class="dropdown-item" href="./list_comp_all.php">Ver Compensações</a>
                        <a class="dropdown-item" href="list_atividades.php">Ver Atividades Extras</a>
                        <!-- <a class="dropdown-item" href="#">Demais Ações</a> -->
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="usuariosDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Usuários</a>
                    <div class="dropdown-menu" aria-labelledby="usuariosDropdown">
                        <a class="dropdown-item" href="./create_user.php">Cadastrar Usuário</a>
                        <a class="dropdown-item" href="./list_users_all.php">Listar usuários</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="gestaoDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Notícias e Avisos</a>
                    <div class="dropdown-menu" aria-labelledby="gestaoDropdown">
                        <a class="dropdown-item" href="list_carrossel.php">Gerenciar Carrossel</a>
                        <a class="dropdown-item" href="list_noticias.php">Listar Notícias</a>
                        <a class="dropdown-item" href="list_avisos.php">Listar Avisos</a> 
                    </div>
                </li>
            <?php } else { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="acoesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Minhas Ações</a>
                    <div class="dropdown-menu" aria-labelledby="acoesDropdown">
                        <a class="dropdown-item" href="cadastro_os.php">Criar Ordem de Serviço</a>
                        <a class="dropdown-item" href="form_add_cursos.php">Cadastrar Curso</a>
                        <a class="dropdown-item" href="listar_cursos.php">Cursos Incompany</a>
                        <a class="dropdown-item" href="listing.php">Listar Ordens de Serviços</a>
                        <a class="dropdown-item" href="list_req.php">Solicitar Compensação de Horas</a>
                        <a class="dropdown-item" href="form_atividade.php">Informar Atividades Extras</a>
                        <a class="dropdown-item" href="list_atividades.php">Ver Atividades Extras</a>
                    </div>
                </li>
            <?php } ?>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="gestaoDropdown" role="button" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false"><img src="./img/gear-fill.svg" alt="Logo" height="30" width="30"></a>
                    <div class="dropdown-menu" aria-labelledby="gestaoDropdown">
                        <a class="dropdown-item" href="./edit_profile.php">Editar Perfil</a>
                        <a class="dropdown-item" href="./logout.php">Sair</a>                        
                    </div>
            </li>
            <li class="nav-item">
                <span class="navbar-text">
                    Bem-vindo(a), <?php echo @$_SESSION['nome']; ?>!
                </span>
            </li>          

            <!-- Links de logout e perfil -->
            <!-- <li class="nav-item">
                <a class="nav-link" href="./edit_profile.php"><i class="fas fa-user-edit"></i> Editar Perfil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </li> -->
        </ul>
    </div>
</nav>

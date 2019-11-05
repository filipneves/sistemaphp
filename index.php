<?php
    include "scripts/bdconn.php";
    include "scripts/login.php";
    include "scripts/verifLogin.php";
    verificaLogAluno();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Login - Aluno</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="libs/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon" />
    </head>
    <body>
        <div class="vh100 d-flex justify-content-center align-items-center">
            <div class="box-home container d-flex flex-column justify-content-center align-items-center pb-3">
                <div class="logo-sobre-div d-flex flex-column align-items-end">
                    <img src="img/logo.png" class="img-fluid imagem-index">
                    <a href="sobre.php" class="mb-1">Sobre</a>
                </div>
                <div class="py-4 px-5 rounded">
                    <form method="post">
                        <div class="form-label-group mb-3 justify-content-center align-items-start d-flex flex-column">
                            <label for="loginMatricula"><h5>Matrícula/CPF do aluno</h5></label>
                            <input type="text" size="40" id="loginMatriculaCpf" name="loginMatriculaCpf" class="form-control" placeholder="Matrícula/CPF" maxlength="11" required autofocus>
                        </div>
                        <div class="form-label-group mb-3 justify-content-center align-items-start d-flex flex-column">
                            <label for="loginSenha"><h5>Senha</h5></label>
                            <input type="password" id="loginSenha" name="loginSenha" class="form-control" placeholder="Senha" maxlength="15" required>
                            <a href="#" class="clean-link" onclick="alert('Entre em contato com a direção/coordenação da escola para recuperá-la, AINDA não é possível fazer isso por email. :)');"><small>Esqueceu a senha?</small></a>
                        </div>
                        <div class="form-label-group mb-3 justify-content-center align-items-end d-flex flex-column">
                            <button class="btn btn-lg btn-outline-secondary btn-block mb-2" type="submit">Entrar</button>
                            <small>É funcionário? Clique <a href="loginFunc.php">AQUI</a>!</small>
                        </div>
                    </form>
                    <?php
                        if(isset($_POST['loginMatriculaCpf']) && isset($_POST['loginSenha'])){
                            loginAluno();
                        }
                    ?>
                </div>
            </div>
        </div>
        <script src="libs/jquery/jquery.min.js"></script>
        <script src="libs/bootstrap/js/bootstrap.min.js"></script>  
    </body>
</html>
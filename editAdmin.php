<?php
    include "scripts/bdconn.php";
    $conn = getConnection();
    include "scripts/verifLogin.php";
    verificaLogAdmin2();
    $id = $_SESSION['adminLog'];
?>
<script>
    function verificaSenha() {
        var senha = document.getElementById('senha');
        var confSenha = document.getElementById('confirmaSenha');
        if(senha.value != confSenha.value){
            alert("A confirmação de senha deve coincidir com a senha");
            return false;
        } else {
            if(senha.value.length < 5 || senha.value.length > 10){
                alert("Senha Inválida(Mínimo: 5 / Máximo: 10)");
                return false;
            }
        }
    }
</script>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Configurações</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="libs/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon" />
    </head>
    <body>
        <div class="box-home container-fluid d-flex flex-column justify-content-center align-items-center">
            <div class="box-logged btn-block">
                <div>
                    <nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-between">
                        <a class="navbar-brand" href="#"><img src="img/logo.png" class="img-fluid" width="100"></a>
                        <div>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                                <ul class="navbar-nav">
                                    <li class="nav-item">
                                        <a class="nav-link" href="adminLogged.php"><h5>Home</h5></a>
                                    </li>
                                    <li class="nav-item active">
                                        <a class="nav-link active" href="editAdmin.php"><h5>Configurações</h5></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="scripts/logout.php"><h5>Sair</h5></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>     
                <div class="justify-content-center align-items-center d-flex mt-5 pb-5">
                    <div class="d-flex flex-wrap px-5">
                        <div class="bg-light p-4 rounded">
                            <h5 class="my-0">Configurações</h5>
                            <small>Somente é possível alterar a senha.</small>
                            <form method="post" class="mt-2 mb-0" onsubmit="return verificaSenha();">
                                <input name="senha" id="senha" type="password" class="form-control mb-3" maxlenght="10" placeholder="Senha (máx. 10)" required>
                                <input name="confirmaSenha" id="confirmaSenha" type="password" class="form-control mb-4" maxlenght="10" placeholder="Confirme a Senha" required>
                                <div class="d-flex justify-content-end">
                                    <input type="submit" class="btn btn-success" value="Salvar">
                                </div>
                            </form>
                            <?php
                                if(isset($_POST['senha']) && isset($_POST['confirmaSenha'])){
                                    $stmt = $conn->prepare('UPDATE admins SET senha = :senha WHERE cpf = :cpf');
                                    $stmt->execute(array(
                                        ':cpf'   => $id,
                                        ':senha' => $_POST['senha']
                                    ));
                                    echo "<script>alert('Alteração concluída!');window.location.replace('adminLogged.php');</script>";
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="libs/jquery/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="libs/bootstrap/js/bootstrap.min.js"></script>  
    </body>
</html>
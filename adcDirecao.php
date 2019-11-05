<?php
    include "scripts/bdconn.php";
    $conn = getConnection();
    include "scripts/verifLogin.php";
    verificaLogAdmin2();
    $idAdmin = $_SESSION['adminLog'];
    include "scripts/adcDirecao.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Adicionar Direção</title>
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
                                    <li class="nav-item">
                                        <a class="nav-link" href="direcao.php"><h5>Voltar</h5></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="editAdmin.php"><h5>Configurações</h5></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="scripts/logout.php"><h5>Sair</h5></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
                <div class="p-4 d-flex justify-content-center flex-column align-items-center">
                    <form method="post" class="p-3 bg-light form-signin d-flex flex-column align-items-center rounded" onsubmit="return validacaoProf();">
                        <h3>Insira os dados abaixo:</h3>
                        <small class="mb-2">Obs: Todos os campos são obrigatórios.</small>
                        <div class="d-flex flex-wrap justify-content-center align-items-center mb-3">
                            <div class="">
                                <div class="form-label-group mb-2 justify-content-center align-items-center d-flex flex-column">
                                    <label for="inputName">Nome e Sobrenome</label>
                                    <input type="text" id="name" name="name" class="form-control" maxlenght="100" placeholder="Nome e Sobrenome" required autofocus>
                                </div>
                                <div class="form-label-group mb-2 justify-content-center align-items-center d-flex flex-column">
                                    <label for="inputCpf">CPF</label>
                                    <input type="text" id="cpf" name="cpf" class="form-control" placeholder="CPF (somente números)" maxlength="11" required autofocus>
                                </div>
                                <div class="form-label-group mb-2 justify-content-center align-items-center d-flex flex-column">
                                    <label for="inputPassword">Senha</label>
                                    <input type="text" id="senha" name="senha" class="form-control" maxlength="10" placeholder="Senha (máx. 10)" required>                 
                                </div>  
                            </div>
                        </div>
                        <input type="submit" class="btn btn-secondary" value="Salvar"/>  
                    </form>
                    <?php
                        if(isset($_POST['name']) && isset($_POST['cpf']) && isset($_POST['senha'])){
                            cadastraDirecao();
                        }
                    ?>
                </div>  
            </div>  
        </div>
        <script src="libs/jquery/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="libs/bootstrap/js/bootstrap.min.js"></script>  
    </body>
</html>
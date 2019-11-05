<?php
    include "scripts/bdconn.php";
    $conn = getConnection();
    include "scripts/verifLogin.php";
    verificaLogAdmin2();
    $idAdmin = $_SESSION['adminLog'];
    include "scripts/adcAluno.php";
    $id = $_GET['id'];
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Adicionar Aluno - <?= $id ?></title>
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
                    <nav class="navbar navbar-expand-lg navbar-light bg-light d-flex justify-content-between">
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
                                        <a class="nav-link" href="alunos.php?id=<?= $id ?>"><h5>Voltar</h5></a>
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
                    <form name="formu" class="bg-light form-signin d-flex flex-column align-items-center p-4 rounded" method="post" onsubmit="return validacaoAluno();">
                        <h3>Insira os dados abaixo:</h3>
                        <small>Obs: Campos com "*" são obrigatórios.</small>
                        <small>Obs2: A matrícula é gerada automaticamente.</small>
                        <small class="mb-2">Obs3: A matrícula aparece ao confirmar o cadastro.</small>
                        <div class="d-flex flex-wrap justify-content-center align-items-center">
                            <div class="mr-2">
                                <div class="form-label-group mb-2 justify-content-center align-items-center d-flex flex-column">
                                    <label for="inputEmail">Nome e Sobrenome*</label>
                                    <input type="text" id="name" name="name" class="form-control" maxlenght="100" placeholder="Nome do Aluno" required autofocus>
                                </div>
                                <div class="form-label-group mb-2 justify-content-center align-items-center d-flex flex-column">
                                    <label for="inputCpf">CPF*</label>
                                    <input type="text" id="cpf" name="cpf" class="form-control" placeholder="CPF (somente números)" maxlength="11" required autofocus>
                                </div>
                                <div class="form-label-group mb-2 justify-content-center align-items-center d-flex flex-column">
                                    <label for="inputPassword">Senha*</label>
                                    <input type="text" id="senha" name="senha" class="form-control" maxlength="10" placeholder="Senha (máx. 10)" required>                 
                                </div>  
                            </div>
                            <div class="mr-2">
                                <div class="form-label-group mb-2 justify-content-center align-items-center d-flex flex-column">
                                    <label for="inputEmail">Nome dos Responsáveis</label>
                                    <input type="text" id="nameResp1" name="nameResp1" class="form-control mb-1" maxlenght="100" placeholder="Responsável 1*" required autofocus>
                                    <input type="text" id="nameResp2" name="nameResp2" class="form-control" maxlenght="100" placeholder="Responsável 2" autofocus>
                                </div>
                                <div class="form-label-group mb-2 justify-content-center align-items-center d-flex flex-column">
                                    <label for="inputCpf">Data de Nascimento*</label>
                                    <input type="date" id="dataNsc" name="dataNsc" class="form-control" placeholder="CPF (somente números)" maxlength="11" required autofocus>
                                </div>
                                <div class="form-label-group mb-2 justify-content-center align-items-center d-flex flex-column">
                                    <label for="inputPassword">Sexo*</label>
                                    <select class="form-control" name="genre" id="genre">
                                        <option value="M">Masculino</option>
                                        <option value="F">Feminino</option>
                                    </select>               
                                </div>  
                                
                            </div>
                        </div>
                        <button class="btn btn-secondary btn-block btn-lg mt-4" type="submit">Cadastrar aluno</button>
                    </form>
                    <?php
                        if(isset($_POST['name'])){
                            cadastraAluno($id,$conn);
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
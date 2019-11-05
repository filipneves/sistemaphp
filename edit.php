<?php
    include "scripts/bdconn.php";
    $conn = getConnection();
    include "scripts/verifLogin.php";
    include "scripts/alterFunc.php";
    verificaLogAdmin2();
    $idAdmin = $_SESSION['adminLog'];
    if(isset($_GET['c']) && isset($_GET['cpf'])){
        if($_GET['c'] != "1" && $_GET['c'] != "2" && $_GET['c'] != "3"){
            echo ("<script>window.location.replace('adminLogged.php');</script>");
        } else {
            if($_GET['c'] === "1"){
                $cargo = "Administrador";
                $table = "admins";
            } elseif($_GET['c'] === "2") {
                $cargo = "Direção";
                $table = "direcao";
            } elseif($_GET['c'] === "3") {
                $cargo = "Professor";
                $table = "professores";
            }
        }
    } else {
        echo ("<script>window.location.replace('adminLogged.php');</script>");
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Editar <?= $cargo ?></title>
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
                                        <a class="nav-link" href="javascript:window.history.go(-1)"><h5>Voltar</h5></a>
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
                    <div class="rounded bg-light p-4 form-signin d-flex flex-column align-items-center">
                        <h4 class="mb-4">Altere as informações abaixo</h4>
                        <div class="d-flex flex-wrap justify-content-center align-items-center flex-column"> 
                            <?php
                                $id = $_GET['cpf'];
                                $sql_show = "SELECT * FROM $table WHERE cpf = $id";
                                $stmt = $conn->prepare($sql_show);
                                $stmt->execute();
                                if($stmt->rowCount() === 0){
                                    echo ("<script>window.location.replace('adminLogged.php');</script>");
                                }
                                $x = $stmt->fetchAll(PDO::FETCH_OBJ);
                                foreach ($x as $y):
                            ?>    
                            <div class="mr-2">
                                <form method="post" class="d-flex flex-column justify-content-center align-items-center" onsubmit="return validacaoFunc();">
                                    <div class="form-label-group mb-2 justify-content-center align-items-center d-flex flex-column">
                                        <h5>Nome</h5>
                                        <input type="text" id="nome" class="form-control" name="nome" maxlength="100" value="<?= $y->nome ?>" required>
                                    </div>
                                    <div class="form-label-group mb-2 justify-content-center align-items-center d-flex flex-column">
                                        <h5>CPF</h5>
                                        <input type="text" id="cpf" class="form-control" name="cpf" maxlength="11" value="<?= $y->cpf ?>" required>
                                    </div>
                                    <div class="form-label-group mb-4 justify-content-center align-items-center d-flex flex-column">
                                        <h5>Senha</h5>
                                        <input type="text" id="senha" class="form-control" name="senha" maxlenght="10" value="<?= $y->senha ?>" required>
                                    </div>
                                    <input type="submit" value="Salvar" class="btn btn-secondary">
                                </form>  
                            </div>
                            <?php 
                                if(isset($_POST['nome']) && isset($_POST['cpf']) && isset($_POST['senha'])){
                                    alterFunc($y->nome,$y->cpf,$y->senha,$table,$conn);
                                }
                                endforeach;
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
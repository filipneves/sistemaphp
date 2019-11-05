<?php
    include "scripts/bdconn.php";
    $conn = getConnection();
    include "scripts/verifLogin.php";
    include "scripts/alterFunc.php";
    verificaLogAdmin2();
    $idAdmin = $_SESSION['adminLog'];
    if(isset($_GET['c']) && isset($_GET['cpf']) && isset($_GET['dado'])){
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

    if($_GET['dado'] != "nome" && $_GET['dado'] != "senha" && $_GET['dado'] != "cpf"){
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
                                        <a class="nav-link" href="editProf.php?id=<?= $_GET['id'] ?>"><h5>Voltar</h5></a>
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
                <?php
                    $id = $_GET['cpf'];
                    $dado = $_GET['dado'];
                ?>
                <div class="d-flex justify-content-center align-items-center flex-column pt-3">
                    <form method="post" class="d-flex justify-content-center flex-column align-items-center bg-light p-4 rounded">
                        <div class="form-signin d-flex flex-column align-items-center">
                            <h3 class="mb-2">Insira <?= strtoupper($dado) ?> abaixo:</h3>
                            <div class="d-flex flex-wrap justify-content-center align-items-center">
                                <div>
                                    <div class="form-label-group mb-2 justify-content-center align-items-center d-flex flex-column pt-3">
                                        <input type="text" class="form-control" name="dado" id="dado">
                                        <input type="submit" class="btn btn-secondary btn-block btn-lg mt-4" value="Salvar">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php
                        if(isset($_POST['dado'])){
                            if($dado == "nome"){
                                alterNome($_POST['dado'],$id,$conn,$table);
                            } elseif($dado == "senha"){
                                alterSenha($_POST['dado'],$id,$conn,$table);
                            } elseif($dado == "cpf"){
                                alterCpf($_POST['dado'],$id,$conn,$table);
                            } else{
                                echo "<script>alert('Dado Inválido. Algo deu errado.')</script>";
                            }

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
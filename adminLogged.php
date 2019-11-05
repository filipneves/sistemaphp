<?php
    include "scripts/bdconn.php";
    $conn = getConnection();
    include "scripts/verifLogin.php";
    verificaLogAdmin2();
    $idAdmin = $_SESSION['adminLog'];
    $consulta = $conn->query("SELECT * FROM admins WHERE cpf = '$idAdmin' AND chef = '1';");
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Home - Administrador</title>
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
                                    <li class="nav-item active">
                                        <a class="nav-link" href="adminLogged.php"><h5>Home <span class="sr-only">(current)</span></h5></a>
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
                    <div class="bg-light p-4 rounded box-logged2-admin d-flex flex-column justify-content-center align-items-center">
                        <a href="turmas.php"><button type="button" class="btn-admin btn btn-lg btn-secondary mb-2">Gerenciar Turmas</button></a>
                        <a href="professores.php"><button type="button" class="btn btn-lg btn-secondary mb-2">Gerenciar Professores</button></a>
                        <a href="direcao.php"><button type="button" class="btn btn-lg btn-secondary mb-2">Gerenciar Direção</button></a>
                        <?php 
                            if($consulta->rowCount() === 1){
                                echo "<a href='admins.php'><button type='button' class='btn btn-lg btn-secondary mb-2'>Gerenciar Administradores</button></a>";
                            }
                        ?>
                        <a href="disciplinas.php"><button type="button" class="btn btn-lg btn-secondary mb-2">Gerenciar Disciplinas</button></a>
                    <div>
                </div>  
            </div>  
        </div>
        <script src="libs/jquery/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="libs/bootstrap/js/bootstrap.min.js"></script>  
    </body>
</html>
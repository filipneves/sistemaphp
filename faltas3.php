<?php
    include "scripts/bdconn.php";
    $conn = getConnection();
    include "scripts/verifLogin.php";
    verificaLogAluno2();
    $id = $_SESSION['alunoLog'];
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Faltas</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="libs/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="libs/tablesaw/dist/tablesaw.css">
        <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon" />
    </head>
    <body>
        <div class="box-home container-fluid d-flex flex-column justify-content-center align-items-center">
            <div class="box-logged btn-block">
                <div>
                    <nav class="navbar navbar-expand-lg navbar-light bg-light d-flex justify-content-between">
                        <a class="navbar-brand" href="#"><img src="img/logo.png" class="img-fluid" width="100"></a>
                        <div class="d-flex flex-column justify-content-end align-items-end">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                                <ul class="navbar-nav">
                                    <li class="nav-item">
                                        <a class="nav-link" href="homeAluno.php"><h5>Home</h5></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="editAluno.php"><h5>Configurações</h5></a>
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
                    <?php 
                        // Consulta SQL que irá retornar valores do DB
                        $sql_show = "SELECT *, DATE_FORMAT(data,'%d/%m/%Y') AS dataCorreta FROM faltas WHERE aluno = $id";
                        $stmt = $conn->prepare($sql_show);
                        $stmt->execute();
                        
                        $alunoFaltas = $stmt->fetchAll(PDO::FETCH_OBJ);
                        $num_faltas = $stmt->rowCount();
                        
                    ?>
                    <!-------------------------------------------------TABELA ------------------------------------------------>
                    <div class="container">
                        <div class="card mt-3">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h2 class="mr-5">Faltas</h2>
                                <h5>Nº de faltas: <?= $num_faltas ?></h5>
                            </div>
                            <div class="card-body">
                                <table id="tableNotaSaw" class="table table-striped table-bordered tablesaw tablesaw-stack" data-tablesaw-mode="stack">
                                    <thead>
                                        <tr>
                                            <th class="cell-center">Data</th>
                                            <th class="cell-center">Justificada</th>
                                            <th class="cell-center">Descrição</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($alunoFaltas as $a): ?>
                                        <tr>
                                            <td class="cell-center cell-a justify-content-center align-items-center"><?= $a->dataCorreta; ?></td>
                                            <td class="cell-center cell-a justify-content-center align-items-center">
                                                <?php  
                                                    if($a->justificada === "0"){ 
                                                        echo "Não"; 
                                                    } 
                                                    else { 
                                                        echo "Sim"; 
                                                    } 

                                                ?>
                                            </td>
                                            <td class=" cell-a justify-content-center align-items-center"><?= $a->descricao; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>    
                            </div>  
                        </div>    
                    </div>
                </div>  
            </div>  
        </div>
        <script src="libs/jquery/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="libs/bootstrap/js/bootstrap.min.js"></script>
        <script src="libs/tablesaw/dist/tablesaw.js"></script>
        <script src="libs/tablesaw/dist/tablesaw-init.js"></script>
        <script>
            Tablesaw.init();
            Tablesaw.init(document.getElementById("tableNotaSaw"));
        </script>
    </body>
</html>
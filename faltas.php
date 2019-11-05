<?php
    include "scripts/bdconn.php";
    $conn = getConnection();
    include "scripts/verifLogin.php";
    verificaLogProf2();
    $idAdmin = $_SESSION['profLog'];
    $turma = $_SESSION['turma'];
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Gerenciar Faltas</title>
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
                        <div class="d-flex flex-column justify-content-end align-items-end">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                                <ul class="navbar-nav">
                                    <li class="nav-item">
                                        <a class="nav-link" href="profLogged.php"><h5>Home</h5></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="editProf.php"><h5>Configurações</h5></a>
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
                        $sql_show = "SELECT distinct cpf, nome,matricula FROM alunos WHERE turma = '$turma'";
                        $stmt = $conn->prepare($sql_show);
                        $stmt->execute();
                        $alunosFaltas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <div class="container">
                        <div class="card mt-3">
                            <div class="card-header d-flex justify-content-between">
                                <h2 class="mr-5">Gerenciar Faltas</h2>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Aluno</th>
                                        <th>Nº de faltas</th>
                                        <th></th>
                                    </tr>
                                        <?php foreach($alunosFaltas as $a): ?>
                                            <tr>
                                                <td><?= $a['nome'] ?>(<?= $a['matricula'] ?>)</td>
                                                <?php 
                                                    $cpf = $a['cpf'];
                                                    $sql_show = "SELECT count(data) FROM faltas WHERE aluno = $cpf;";
                                                    $stmt = $conn->prepare($sql_show);
                                                    $stmt->execute();
                                                    $quantidadeFaltas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($quantidadeFaltas as $q):
                                                        echo "<td>" . $q['count(data)'] . "</td>";
                                                    endforeach;
                                                ?>
                                                <td><a href="faltas2.php?m=<?= $a['matricula'] ?>" class="btn btn-success">Ver/Gerenciar Faltas</a></td>
                                            <tr>
                                        <?php endforeach; ?>
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
    </body>
</html>
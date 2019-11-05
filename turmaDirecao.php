<?php
    include "scripts/bdconn.php";
    $conn = getConnection();
    include "scripts/verifLogin.php";
    verificaLogDirecao2();
    $id = $_SESSION['direcaoLog'];
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Turmas</title>
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
                                        <a class="nav-link" href="direcaoLogged.php"><h5>Home</h5></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="editDirecao.php"><h5>Configurações</h5></a>
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
                        $sql_show = "SELECT * FROM turmas ORDER BY codigo";
                        $stmt = $conn->prepare($sql_show);
                        $stmt->execute();

                        #Aqui criamos uma variavel chamada "funcionarios" onde ele recebe o resultado do objeto "stmt". com a função fatchALL, retornamos a lista de nomes, um array, mas como objetos, onde chamaremos mais abaixo no foreach
                        $turmas = $stmt->fetchAll(PDO::FETCH_OBJ);
                    ?>
                    <!-------------------------------------------------TABELA ------------------------------------------------>
                    <div class="container">
                        <div class="card mt-3">
                            <div class="card-header d-flex justify-content-between">
                                <h2 class="mr-5">Gerenciar Turmas</h2>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Código</th>
                                        <th>Professor</th>
                                        <th>Turno</th>
                                        <th>Nº Alunos</th>
                                        <th>Alterações</th>
                                    </tr>
                                    <?php foreach($turmas as $func): ?>
                                        <tr>
                                            <td><?= $func->codigo; ?></td>
                                            <td>
                                                <?php
                                                    $numProf = $func->cpf_professor;
                                                    $sql_show2 = "SELECT nome FROM professores WHERE cpf = $numProf";
                                                    $stmt2 = $conn->prepare($sql_show2);
                                                    $stmt2->execute();
                                                    foreach($stmt2 as $row) {
                                                        echo $row['nome'];}
                                                ?>
                                            </td>
                                            <td><?= $func->turno; ?></td>
                                            <td>
                                                <?php
                                                    $codigoTurma = $func->codigo;
                                                    $verifica = $conn->prepare("SELECT * FROM alunos WHERE turma = :cod");
                                                    $verifica->execute(array(':cod' => $codigoTurma));
                                                    echo ($verifica->rowCount());
                                                ?>
                                            </td>
                                            <td>
                                                <a href="alunosDirecao.php?id=<?= $func->codigo ?>" class="btn btn-success">Alunos</a>
                                            </td>
                                        </tr>
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
<?php
    include "scripts/bdconn.php";
    $conn = getConnection();
    include "scripts/verifLogin.php";
    verificaLogProf2();
    $idAdmin = $_SESSION['profLog'];
    $turma = $_SESSION['turma'];
    $matricula = $_GET['m'];
    $consulta = $conn->query("SELECT nome,turma,cpf FROM alunos WHERE matricula = '$matricula';");
    if($consulta->rowCount() == 0){
        echo ("<script>window.location.replace('faltas.php');</script>");
    } 
    else{
        while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
            if($linha['turma'] != $turma){
                echo ("<script>window.location.replace('faltas.php');</script>");
            } else {
                $nome = $linha['nome'];
                $cpf = $linha['cpf'];
            }
        }
    }
    include "scripts/adcFalta.php";
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
                                        <a class="nav-link" href="faltas.php"><h5>Voltar</h5></a>
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
                        $sql_show = "SELECT *, DATE_FORMAT(data,'%d/%m/%Y') AS data2 FROM faltas WHERE aluno = $cpf";
                        $stmt = $conn->prepare($sql_show);
                        $stmt->execute();
                        $alunoFaltas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        $sql_show = "SELECT count(data) FROM faltas WHERE aluno = $cpf;";
                        $stmt = $conn->prepare($sql_show);
                        $stmt->execute();
                        $quantidadeFaltas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach($quantidadeFaltas as $q):
                            $qtdFaltas = $q['count(data)'];
                        endforeach;
                        
                    ?>
                    <!-------------------------------------------------TABELA ------------------------------------------------>
                    <div class="container">
                        <div class="card mt-3">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h2 class="mr-5">Gerenciar Faltas</h2>
                                <h5>Nº de faltas: <?= $qtdFaltas ?></h5>
                            </div>
                            <div class="card-body">
                                <h5 class="mb-1">Aluno: <?= $nome ?></h5>
                                <h5 class="mb-3">Matrícula: <?= $matricula ?></h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Data da falta</th>
                                        <th>Justificada</th>
                                        <th>Descrição</th>
                                        <th>Alterações</th>
                                    </tr>
                                        <?php foreach($alunoFaltas as $a): ?>
                                            <tr>
                                                <td><?= $a['data2'] ?></td>
                                                <td><?php if($a['justificada'] === "0"){ echo "Não"; } else{ echo"Sim"; } ?></td>
                                                <td><?= $a['descricao'] ?></td>
                                                <td><a onclick="return confirm('Tem certeza que deseja excluir essa falta?')" href="scripts/faltaDelete.php?m=<?= $matricula ?>&data=<?= $a['data'] ?>" class="btn btn-danger">Excluir</a></td>
                                            <tr/>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td colspan="4">
                                                <h4 class="mb-3">Adicionar Falta</h4>
                                                <form method="post" class="d-flex justify-content-center align-items-center">
                                                    <div class="col-3 d-flex justify-content-center align-items-center">
                                                        Data<input name="data" id="data" class="form-control mx-2" type="date" required>
                                                    </div>
                                                    <div class="col-5 d-flex justify-content-center align-items-center">
                                                        Descrição<input name="descricao" class="form-control mx-2" type="text" maxlength="150">
                                                    </div>
                                                    <div class="d-flex col-1 mx-3">
                                                        Justificada
                                                        <input name="justificada" class="form-check-input" type="checkbox"/>
                                                    </div>
                                                    <div class="col-1">
                                                        <input type="submit" value="Salvar" class="btn btn-success"/>
                                                    </div>
                                                </form>
                                                <?php
                                                    if(isset($_POST['data'])){
                                                        cadastraFalta($cpf,$matricula);
                                                    }
                                                ?>
                                            </td>
                                        </tr>
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
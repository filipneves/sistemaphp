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
        <title>Gerenciar Notas</title>
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
                        if($_GET['p'] > 4 || $_GET['p'] < 1){
                            echo ("<script>window.location.replace('profLogged.php');</script>");
                        }
                        $periodo = "p" . $_GET['p'];
                        $sql_show = "SELECT * FROM disciplinas";
                        $stmt = $conn->prepare($sql_show);
                        $stmt->execute();
                        $num_disciplinas = $stmt->rowCount();
                        $disciplinas = $stmt->fetchAll(PDO::FETCH_OBJ);
                        $num_disciplinas2 = $num_disciplinas + 1;
                        $porcentagem = 75/$num_disciplinas2 . "%";
                        $cont = 0;
                        $colunas_disciplinas = "";
                        for($j = 1 ;$j <= $num_disciplinas; $j++){
                            $colunas_disciplinas = $colunas_disciplinas . "nota_" . $j . "_" . $periodo; 
                            if($j != $num_disciplinas){
                                $colunas_disciplinas = $colunas_disciplinas . ",";
                            }
                        }
                        $sql_show = "SELECT nome, $colunas_disciplinas, cpf, matricula  FROM alunos, notas WHERE cpf = aluno AND turma = '$turma' ORDER BY nome asc";
                        $stmt = $conn->prepare($sql_show);
                        $stmt->execute();
                        $alunosNotas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <!-------------------------------------------------TABELA ------------------------------------------------>
                    <div class="container-fluid">
                        <div class="card mt-3">
                            <div class="card-header d-flex justify-content-between">
                                <h2 class="mr-5">Gerenciar Notas</h2>
                                <a href="notas.php?p=1"><button type="button" class="<?php if($_GET['p'] == 1){echo 'btn-info ';} ?>btn btn-lg btn-secondary mb-2">1º Período</button></a>
                                <a href="notas.php?p=2"><button type="button" class="<?php if($_GET['p'] == 2){echo 'btn-info ';} ?>btn btn-lg btn-secondary mb-2">2º Período</button></a>
                                <a href="notas.php?p=3"><button type="button" class="<?php if($_GET['p'] == 3){echo 'btn-info ';} ?>btn btn-lg btn-secondary mb-2">3º Período</button></a>
                                <a href="notas.php?p=4"><button type="button" class="<?php if($_GET['p'] == 4){echo 'btn-info ';} ?>btn btn-lg btn-secondary mb-2">4º Período</button></a>
                            </div>
                            <div class="card-body">
                            <div class="container-fluid d-flex justify-content-between">    
                                <h6 class="mb-0">N.P = Não Pontuado</h6>
                                <a href="scripts/imprimirNotas.php?p=<?= $_GET['p'] ?>&d=<?= $colunas_disciplinas ?>" class="mb-3"><button class="btn btn-secondary">Imprimir</button></a>
                            </div>
                                <table class="table table-bordered">
                                    <tr>
                                        <th class="table-secondary"></th>
                                        <th colspan="<?= $num_disciplinas ?>">Disciplinas</th>
                                        <th class="cell-center" >Alterações</th>
                                    </tr>
                                    <tr>
                                        <th class="cell-center" width="">Aluno</th>
                                        <?php foreach($disciplinas as $d ): ?>
                                            <th class="cell-center" width="<?= $porcentagem ?>"><?= $d->nome_disciplina ?></th>
                                        <?php endforeach; ?>
                                        <th></th>
                                    </tr>
                                        <?php foreach($alunosNotas as $a): ?>
                                            <tr>
                                                <td><?= $a['nome'] ?> (<?= $a['matricula'] ?>)</td>
                                                <?php 
                                                    for($i = 1; $i <= $num_disciplinas;$i++){
                                                        $x = "nota_" . $i . "_" . $periodo;                                                        
                                                        if(isset($a[$x])){
                                                            echo "<td class='cell-center'>$a[$x]</td>";
                                                        } else {
                                                            echo "<td class='cell-center'><b>N.P</b></td>";
                                                        }
                                                    }
                                                ?>
                                                <td><a href="alterNotas.php?m=<?= $a['matricula'] ?>&p=<?= $_GET['p']?>" class="btn btn-success">Alterar</a></td>
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
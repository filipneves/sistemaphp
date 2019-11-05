<?php
    include "scripts/bdconn.php";
    $conn = getConnection();
    include "scripts/verifLogin.php";
    verificaLogProf2();
    $idAdmin = $_SESSION['profLog'];
    $turma = $_SESSION['turma'];
    $matricula = $_GET['m'];
    $consulta = $conn->query("SELECT turma FROM alunos WHERE matricula = '$matricula';");
    if($consulta->rowCount() == 0){
        echo ("<script>window.location.replace('notas.php');</script>");
    } 
    else{
        while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
            if($linha['turma'] != $turma){
                echo ("<script>window.location.replace('notas.php');</script>");
            }
        }
    }
    include "scripts/alterNotas.php";
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
                                        <a class="nav-link" href="notas.php?p=<?= $_GET['p'] ?>"><h5>Voltar</h5></a>
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
                    <div class="container-fluid px-5">
                        <div class="card mt-3">
                            <div class="card-header d-flex justify-content-between">
                                <?php
                                    $consulta = $conn->query("SELECT * FROM alunos WHERE matricula = '$matricula';");
                                    while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
                                        $nome = $linha['nome'];
                                        $cpf = $linha['cpf'];
                                    }
                                    $sql_show = "SELECT * FROM disciplinas";
                                    $stmt = $conn->prepare($sql_show);
                                    $stmt->execute();
                                    $num_disciplinas = $stmt->rowCount();
                                    $disciplinas = $stmt->fetchAll(PDO::FETCH_OBJ);
                                    $porcentagem = 100/$num_disciplinas . "%";
                                    $colunas_disciplinas = "";
                                    $num_disciplinas2 = $num_disciplinas + 1;
                                    for($j = 1 ;$j <= $num_disciplinas; $j++){
                                        for($h = 1; $h < 5; $h++){
                                            $colunas_disciplinas = $colunas_disciplinas . "nota_$j" . "_p$h"; 
                                            if($j != $num_disciplinas2){
                                                $colunas_disciplinas = $colunas_disciplinas . ",";
                                            }
                                        }
                                    }
                                    $resultado = substr($colunas_disciplinas,0,-1);
                                    $sql_show = "SELECT $resultado FROM notas WHERE aluno = '$cpf'";
                                    $stmt = $conn->prepare($sql_show);
                                    $stmt->execute();
                                    $alunoNotas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                ?>
                                <h2 class="mr-5">Gerenciar Notas</h2>
                                <a href="alterNotas.php?m=<?= $matricula ?>&p=1"><button type="button" class="<?php if($_GET['p'] == 1){echo 'btn-info ';} ?>btn btn-lg btn-secondary mb-2">1º Período</button></a>
                                <a href="alterNotas.php?m=<?= $matricula ?>&p=2"><button type="button" class="<?php if($_GET['p'] == 2){echo 'btn-info ';} ?>btn btn-lg btn-secondary mb-2">2º Período</button></a>
                                <a href="alterNotas.php?m=<?= $matricula ?>&p=3"><button type="button" class="<?php if($_GET['p'] == 3){echo 'btn-info ';} ?>btn btn-lg btn-secondary mb-2">3º Período</button></a>
                                <a href="alterNotas.php?m=<?= $matricula ?>&p=4"><button type="button" class="<?php if($_GET['p'] == 4){echo 'btn-info ';} ?>btn btn-lg btn-secondary mb-2">4º Período</button></a>
                            </div>
                            <div class="card-body px-5">
                                <h5 class="mb-1">Aluno: <?= $nome ?></h5>
                                <h5 class="mb-1">Matrícula: <?= $matricula ?></h5>
                                <small>ATENÇÃO: Se o aluno ainda não foi pontuado NÃO coloque "0" (zero), deixe a nota em BRANCO.</small>
                                <form class="mt-3" method="post" onsubmit="return validacaoNota();">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th class="cell-center" colspan="<?= $num_disciplinas ?>">Disciplinas</th>
                                        <tr>
                                        <tr>
                                            <?php foreach($disciplinas as $d ): ?>
                                                <th class="cell-center" width="<?= $porcentagem ?>"><?= $d->nome_disciplina ?></th>
                                            <?php endforeach; ?>
                                        </tr>
                                        <tr id="linhaNotas">
                                        <?php 
                                            foreach($alunoNotas as $a):  
                                                for($i = 1; $i <= $num_disciplinas;$i++){
                                                    $x = "nota_$i" . "_p" . $_GET['p'];
                                                    echo "<td><input name='n$i' id='n$i' class='nota form-control' type='number' step='0.1' value='$a[$x]'/></td>";
                                                }     
                                            endforeach; ?>
                                        </tr>
                                    </table>
                                    <input name="num_disciplinas" id="num_disciplinas" type="hidden" value="<?= $num_disciplinas ?>">
                                    <div class="container-fluid justify-content-end d-flex">
                                        <a href="notas.php?p=<?= $_GET['p'] ?>" class="btn btn-info">Voltar</a>
                                        <input type="submit" class="btn btn-success ml-2" value="Salvar">
                                    </div>
                                </form>
                                <?php
                                    if(isset($_POST['num_disciplinas'])){
                                        alterNotas($conn, $_GET['p'], $cpf, $matricula);
                                    }
                                ?>
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
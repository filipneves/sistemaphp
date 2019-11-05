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
        <title>Home - Aluno</title>
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
                                    <li class="nav-item active">
                                        <a class="nav-link" href="homeAluno.php"><h5>Home <span class="sr-only">(current)</span></h5></a>
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
                
                <?php 
                    $sql_show = "SELECT *, DATE_FORMAT(data_nascimento,'%d/%m/%Y') AS dataCorreta FROM alunos WHERE cpf = '$id'";
                    $stmt = $conn->prepare($sql_show);
                    $stmt->execute();
                    $alunos = $stmt->fetchAll(PDO::FETCH_OBJ);
                ?>
                <div class="justify-content-center align-items-center d-flex mt-5 pb-5">
                    <div class="d-flex flex-wrap py-4 px-5">
                        <div class="mb-4">
                            <?php foreach($alunos as $func): ?>
                            <div class="d-flex flex-column mb-3">
                                <h5>Dados Pessoais</h5>
                                <span><b>Nome:</b> <?= $func->nome; ?></span>
                                <span><b>CPF:</b> <?= $func->cpf; ?></span>
                                <span><b>Responsável 1:</b> <?= $func->responsavel1; ?></span>
                                <span><b>Responsável 2:</b> <?= $func->responsavel2; ?></span>
                                <span><b>Sexo:</b> <?= $func->sexo; ?></span>
                                <span><b>Data de nascimento:</b> <?= $func->dataCorreta; ?></span>
                            </div>
                            <div class="d-flex flex-column">
                                <h5>Dados Instituicionais</h5>
                                <span><b>Nº de Matrícula:</b> <?= $func->matricula; ?></span>
                                <span><b>Turma:</b> <?= $func->turma; ?></span>
                                <?php
                                    $sql_show = "SELECT nome FROM professores,turmas WHERE codigo = '$func->turma' AND cpf = cpf_professor";
                                    $stmt2 = $conn->prepare($sql_show);
                                    $stmt2->execute();
                                    $professor = $stmt2->fetchAll(PDO::FETCH_OBJ);
                                    foreach($professor as $func2):
                                        $nomeProfessor = $func2->nome;
                                    endforeach;
                                ?>
                                <span><b>Professor(a):</b> <?= $nomeProfessor ?></span>
                                <span><b>Turno:</b> <?php if($func->turma[2] === "V"){echo "Vespertino";}else{echo"Matutino";} ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <div id="linha-vertical" class="mx-5"></div>
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <div class="d-flex flex-column justify-content-center align-items-center pb-4">    
                                <?php
                                    $sql_show = "SELECT * FROM notas WHERE aluno = '$id'";
                                    $stmt3 = $conn->prepare($sql_show);
                                    $stmt3->execute();
                                    $alunoNotas = $stmt3->fetchAll(PDO::FETCH_ASSOC);
                                    $sql_show ="SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema = 'pccbd' AND table_name = 'notas'";
                                    $stmt4 = $conn->prepare($sql_show);
                                    $stmt4->execute();
                                    while ($linha = $stmt4->fetch(PDO::FETCH_ASSOC)) {
                                        $num_disciplinas = ($linha['COUNT(*)'] - 1)/4;
                                    }
                                    $total = 0;
                                    $cont = 0;
                                    foreach($alunoNotas as $x):
                                        for($h = 1 ; $h <= 4 ; $h++){
                                            for($i = 1 ; $i <= $num_disciplinas ; $i++){
                                                $y = "nota_" . $i . "_p$h";
                                                if(isset($x[$y])){
                                                    $total += $x[$y];
                                                    $cont++;
                                                } 
                                            }
                                        }
                                        if($cont === 0){
                                            $total2 = 0;
                                        } else {
                                            $total2 = ($total/$cont);
                                        }
                                    endforeach;
                                    if($total2 > 8.5 && $total2 <= 10){
                                        $txt = "INCRÍVEL! XD";
                                    } elseif($total2 > 7.5){
                                        $txt = "MUITO BOM! :)";
                                    } elseif($total2 > 6){
                                        $txt = "RAZOÁVEL! :L";
                                    } elseif($total2 > 4){
                                        $txt = "PRECISA MELHORAR! '-'";
                                    } elseif($total2 > 0){
                                        $txt = "PRECISA MELHORAR BASTANTE! :(";
                                    } elseif($total2 === 0){
                                        $txt = "Nenhuma nota do aluno foi inserida.";
                                    } else{
                                        $txt = "Algo deu errado!";
                                    }
                                ?>
                                <h3>A média de notas do aluno é: <?= number_format($total2, 1, '.', '') ?></h3>
                                <h5><?= $txt ?></h5>
                            </div>
                            <div>
                                <a href="boletim.php" class="btn btn-lg btn-secondary btn-block mb-2">Boletim</a>
                                <a href="faltas3.php" class="btn btn-lg btn-secondary btn-block mb-2">Faltas</a>
                                <a href="coments3.php" class="btn btn-lg btn-secondary btn-block mb-2">Comentários do Prof.</a>
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
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
        <title>Home - Direção</title>
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
                                        <a class="nav-link" href="direcaoLogged.php"><h5>Home <span class="sr-only">(current)</span></h5></a>
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
                    <div class="bg-light p-4 rounded box-logged2-admin d-flex flex-column justify-content-center align-items-center">
                        <a href="#openModal"><button type="button" class="btn-admin btn btn-lg btn-secondary mb-2">Imprimir Notas das Turmas</button></a>
                        <a href="scripts/imprimeMedia.php"><button type="button" class="btn btn-lg btn-secondary mb-2">Imprimir Média de todas as turmas</button></a>
                        <a href="turmaDirecao.php"><button type="button" class="btn btn-lg btn-secondary mb-2">Turmas/Alunos</button></a>
                    <div>
                    <div id="openModal" class="modalDialog">
                        <div>
                            <a href="#close" title="Close" class="close">X</a>
                            <h4 class="my-2">Imprimir notas das turmas</h4>
                            <hr>
                            <div class="d-flex flex-column my-2">
                                <h5>Selecione a turma e o período.</h5>
                                <form method="post">
                                    <select id="turma" name="turma" class="custom-select mb-3">
                                    <?php
                                        $sql_show = "SELECT codigo FROM turmas";
                                        $stmt = $conn->prepare($sql_show);
                                        $stmt->execute();
                                        $turmas = $stmt->fetchAll(PDO::FETCH_OBJ);
                                        foreach($turmas as $t): 
                                    ?>
                                        <option value="<?= $t->codigo ?>"><?= $t->codigo ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <select id="periodo" name="periodo" class="custom-select mb-3">
                                        <option value="1">1º Período</option>
                                        <option value="2">2º Período</option>
                                        <option value="3">3º Período</option>
                                        <option value="4">4º Período</option>
                                    </select>
                                    <input type="submit" class="btn btn-secondary px-3" value="Imprimir">
                                </form>
                                <?php
                                    if(isset($_POST['turma']) && isset($_POST['periodo'])){
                                        $periodo = "p" . $_POST['periodo'];
                                        $sql_show = "SELECT * FROM disciplinas";
                                        $stmt = $conn->prepare($sql_show);
                                        $stmt->execute();
                                        $num_disciplinas = $stmt->rowCount();
                                        $disciplinas = $stmt->fetchAll(PDO::FETCH_OBJ);
                                        $colunas_disciplinas = "";
                                        for($j = 1 ;$j <= $num_disciplinas; $j++){
                                            $colunas_disciplinas = $colunas_disciplinas . "nota_" . $j . "_" . $periodo; 
                                            if($j != $num_disciplinas){
                                                $colunas_disciplinas = $colunas_disciplinas . ",";
                                            }
                                        }
                                        $x = "scripts/imprimirNotas.php?p=" . $_POST['periodo'] . "&d=" . $colunas_disciplinas . "&turma=" . $_POST['turma'];
                                        echo ("<script>window.location.replace('$x');</script>");
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
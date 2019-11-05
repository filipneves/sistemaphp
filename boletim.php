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
        <title>Boletim</title>
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
                                        <a class="nav-link" href="#"><h5>Configurações</h5></a>
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
                        $sql_show = "SELECT * FROM disciplinas";
                        $stmt = $conn->prepare($sql_show);
                        $stmt->execute();
                        #Aqui criamos uma variavel chamada "funcionarios" onde ele recebe o resultado do objeto "stmt". com a função fatchALL, retornamos a lista de nomes, um array, mas como objetos, onde chamaremos mais abaixo no foreach
                        $num_disciplinas = $stmt->rowCount();
                        $disciplinas = $stmt->fetchAll(PDO::FETCH_OBJ);
                        $porcentagem = 100/$num_disciplinas . "%";
                        /* nota_d1_p1, */
                        $sql_show = "SELECT *  FROM notas WHERE aluno = $id";
                        $stmt = $conn->prepare($sql_show);
                        $stmt->execute();
                        
                        $alunoNotas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        
                    ?>
                    <!-------------------------------------------------TABELA ------------------------------------------------>
                    <div class="container">
                        <div class="card mt-3">
                            <div class="card-header d-flex justify-content-between">
                                <h3 class="mr-5">Boletim</h3>
                                <a href="scripts/imprimirBoletim.php"><button class="btn btn btn-secondary">Imprimir</button></a>
                            </div>
                            <div class="card-body">
                                <h6>N.P = Não Pontuado</h6>
                                <table id="tableNotaSaw" class="table table-striped table-bordered tablesaw tablesaw-stack" data-tablesaw-mode="stack">
                                    <thead>
                                        <tr>
                                            <th class="cell-center period-cell">Período</th>
                                            <?php foreach($disciplinas as $d ): ?>
                                                <th class="cell-center" width="<?= $porcentagem ?>"><?= $d->nome_disciplina ?></th>
                                            <?php endforeach; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            foreach($alunoNotas as $a): 
                                                for($i = 1; $i <= 4;$i++){
                                                    echo "<tr><th class='cell-center cell-a justify-content-center align-items-center'>$i" . "º</th>";
                                                    for($h = 1; $h <= $num_disciplinas;$h++){
                                                        $x = "nota_$h" . "_p$i";                                                       
                                                        if(isset($a[$x])){
                                                            if($a[$x] < 6){
                                                                $c = "red";
                                                            } else{
                                                                $c = "black";
                                                            }
                                                            echo "<td style='color:$c' class='cell-center cell-a justify-content-center align-items-center'>$a[$x]</td>";
                                                        } else {
                                                            echo "<td class='cell-center cell-a justify-content-center align-items-center'><b>N.P</b></td>";
                                                        }
                                                        if($h === $num_disciplinas){
                                                            echo "</tr>";
                                                        }
                                                    }
                                                }    
                                            endforeach; 
                                        ?>
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
<?php
    include "scripts/bdconn.php";
    $conn = getConnection();
    include "scripts/verifLogin.php";
    verificaLogProf2();
    $idProf = $_SESSION['profLog'];
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Home - Professor</title>
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
                                        <a class="nav-link" href="profLogged.php"><h5>Home <span class="sr-only">(current)</span></h5></a>
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
                <?php
                    $sql_show = "SELECT nome,alocacao FROM professores WHERE cpf = $idProf";
                    $stmt = $conn->prepare($sql_show);
                    $stmt->execute();

                    #Aqui criamos uma variavel chamada "funcionarios" onde ele recebe o resultado do objeto "stmt". com a função fatchALL, retornamos a lista de nomes, um array, mas como objetos, onde chamaremos mais abaixo no foreach
                    $profInfo = $stmt->fetchAll(PDO::FETCH_OBJ);
                    foreach($profInfo as $x):
                        $aloc = $x->alocacao;
                        $nomeSobrenome = $x->nome;
                    endforeach;
                ?>
                <div class="p-4 d-flex justify-content-center flex-column align-items-center">
                    <div class="bg-light p-4 rounded box-logged2-admin d-flex flex-column justify-content-center align-items-center">
                        <?php
                            $nome = "";
                            for($i = 0; $i < strlen($nomeSobrenome) ;$i++){
                                if($nomeSobrenome[$i] != " "){
                                    $nome = $nome . $nomeSobrenome[$i];
                                } else {
                                    break;
                                }
                            }
                            echo "<h5>Bem vindo Prof. $nome</h5>";
                            if($aloc === "0"){
                                echo "
                                    <h5>Você ainda não está alocado em nenhuma turma.</h5>
                                    <h5>Contate a direção para mais informações.</h5>
                                ";
                            } else{
                                $sql_show = "SELECT * FROM turmas WHERE cpf_professor = $idProf";
                                $stmt = $conn->prepare($sql_show);
                                $stmt->execute();
                                $turmaInfo = $stmt->fetchAll(PDO::FETCH_OBJ);
                                foreach($turmaInfo as $y):
                                    $turma = $y->codigo;
                                endforeach;
                                $_SESSION['turma'] = $turma;
                                echo "
                                    <h5 class='mb-3'>Sua Turma: $turma</h5>
                                    <div class='box-logged2-admin d-flex flex-column justify-content-center align-items-center'>
                                        <a href='notas.php?p=1'><button type='button' class='btn btn-lg btn-secondary mb-2'>Gerenciar Notas da Turma</button></a>
                                        <a href='faltas.php'><button type='button' class='btn btn-lg btn-secondary mb-2'>Gerenciar Faltas da Turma</button></a>
                                        <a href='coments.php'><button type='button' class='btn btn-lg btn-secondary mb-2'>Gerenciar Comentários da Turma</button></a>
                                        <a href='#openModal'><button type='button' class='btn btn-lg btn-secondary mb-2'>Outras Opções</button></a>
                                    </div>
                                ";
                            }
                        ?>
                        <div id="openModal" class="modalDialog">
                            <div>
                                <a href="#close" title="Close" class="close">X</a>
                                <h2>Outras Opções</h2>
                                <div class="d-flex flex-column my-2">
                                    <a href="scripts/imprimirPresenca.php" target="_blank" class="btn btn-secondary mb-3">Gerar Lista de Presença</a>
                                </div>
                            </div>
                        </div>
                    <div>
                </div>  
            </div>  
        </div>
        <script src="libs/jquery/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="libs/bootstrap/js/bootstrap.min.js"></script>  
    </body>
</html>
<?php
    include "scripts/bdconn.php";
    $conn = getConnection();
    include "scripts/verifLogin.php";
    verificaLogAdmin2();
    $idAdmin = $_SESSION['adminLog'];
    if(isset($_GET['id'])){

    } else {
        echo "<script>window.location.replace('turmas.php');</script>";
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Editar Turma</title>
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
                                    <li class="nav-item">
                                        <a class="nav-link" href="adminLogged.php"><h5>Home</h5></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="turmas.php"><h5>Voltar</h5></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="editAdmin.php"><h5>Configurações</h5></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="scripts/logout.php"><h5>Sair</h5></a>
                                    </li>
                                </ul>
                            </div>
                        <div>
                    </nav>
                </div>
                <div class="p-4 d-flex justify-content-center flex-column align-items-center">
                    <div class="p-3 rounded bg-light form-signin d-flex flex-column align-items-center">
                        <h3 class="mb-4">Altere os dados abaixo:</h3>
                        <div class="d-flex flex-wrap justify-content-center align-items-center">
                            <div>
                                <?php
                                    $id = $_GET['id'];
                                    $sql_show = "SELECT nome, cpf FROM professores WHERE alocacao = '0';";
                                    $stmt = $conn->prepare($sql_show);
                                    $stmt->execute();
                                    if($stmt->rowCount() == 0){
                                        /*echo "<script>alert('Não há professor disponível para alterar.');</script>";
                                        echo ("<script>window.location.replace('turmas.php');</script>");*/
                                    }
                                    $sql_show2 = "SELECT nome, cpf FROM professores, turmas WHERE codigo = '$id' AND cpf = cpf_professor;";
                                    $stmt2 = $conn->prepare($sql_show2);
                                    $stmt2->execute();
                                    $prof = $stmt2->fetchAll(PDO::FETCH_OBJ);
                                    if($stmt2->rowCount() === 0){
                                        echo "<script>window.location.replace('turmas.php');</script>";
                                    }
                                ?>
                                <div class="">
                                    <form method="post">
                                        Professor    
                                        <select class="form-control mb-3" id="professor" name="professor">
                                            <?php foreach($prof as $x): ?>    
                                            <option value="<?= $x->cpf ?>"><?= $x->nome ?></option>
                                            <?php 
                                                endforeach;
                                                // Consulta SQL que irá retornar valores do DB

                                                #Aqui criamos uma variavel chamada "funcionarios" onde ele recebe o resultado do objeto "stmt". com a função fatchALL, retornamos a lista de nomes, um array, mas como objetos, onde chamaremos mais abaixo no foreach
                                                $profs = $stmt->fetchAll(PDO::FETCH_OBJ);
                                                foreach($profs as $func):
                                            ?>
                                            <option value="<?=$func->cpf;?>"><?=$func->nome;?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        Turno
                                        <select class="form-control" id="turno" name="turno">
                                            <option value="Matutino">Matutino</option>
                                            <option value="Vespertino">Vespertino</option>
                                        </select>
                                        <button type="submit" class="btn btn-secondary btn-block btn-lg mt-4">Salvar</button>
                                    </form>
                                </div>
                                <?php
                                    if(isset($_POST['professor']) && isset($_POST['turno'])){
                                        $consulta = $conn->query("SELECT cpf_professor FROM turmas WHERE codigo = '$id';");
                                        while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
                                            $idProf = $linha['cpf_professor'];
                                        }
                                        $id2 = $id[0] . $id[1] . $_POST['turno'][0];
                                        $stmt = $conn->prepare('UPDATE professores SET alocacao = :aloc WHERE cpf = :id');
                                        $stmt->execute(array(
                                            ':id'   => $idProf,
                                            ':aloc' => "0"
                                        ));

                                        $stmt2 = $conn->prepare('UPDATE turmas SET cpf_professor = :prof, turno = :turno WHERE codigo = :id');
                                        $stmt2->execute(array(
                                          ':id'   => $id,
                                          ':prof' => $_POST['professor'],
                                          ':turno' => $_POST['turno']
                                        ));
                                        $stmt4 = $conn->prepare('UPDATE turmas SET codigo = :cod WHERE codigo = :id');
                                        $stmt4->execute(array(
                                          ':id'   => $id,
                                          ':cod' => $id2
                                        ));
                                        $stmt3 = $conn->prepare('UPDATE professores SET alocacao = :aloc WHERE cpf = :id');
                                        $stmt3->execute(array(
                                            ':id'   => $_POST['professor'],
                                            'aloc' => "1"
                                        ));
                                        echo ("<script>alert('Alterações feitas com sucesso.');</script>");
                                        echo ("<script>window.location.replace('turmas.php');</script>");
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
<?php
    include "scripts/bdconn.php";
    $conn = getConnection();
    include "scripts/verifLogin.php";
    verificaLogAdmin2();
    $idAdmin = $_SESSION['adminLog'];
    $matricula = $_GET['m'];
    include "scripts/alterAluno.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Editar Aluno</title>
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
                                        <a class="nav-link" href="editAdmin.php"><h5>Configurações</h5></a>
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
                    $sql_show = "SELECT *, DATE_FORMAT(data_nascimento,'%d/%m/%Y') AS dataCorreta FROM alunos WHERE matricula = '$matricula'";
                    $stmt = $conn->prepare($sql_show);
                    $stmt->execute();
                    /* 
                        Aqui criamos uma variavel chamada "alunos" onde ela recebe o resultado do objeto "stmt". 
                        Com a função fetchALL, retornamos os dados do aluno logado. 
                    */
                    $aluno = $stmt->fetchAll(PDO::FETCH_OBJ);
                ?>
                <div class="justify-content-center align-items-center d-flex mt-5 pb-5">
                    <div class="d-flex flex-wrap px-5">
                        <div class="bg-light p-4 rounded">
                            <h5 class="mt-0 mb-3">Configurações</h5>
                            <?php 
                                foreach($aluno as $a): 
                                    if($a->sexo === "M" || $a->sexo === "m"){
                                        $x1 = "Masculino";
                                        $x2 = $a->sexo;
                                        $y1 = "Feminino";
                                        $y2 = "F";
                                    } else{
                                        $x1 = "Feminino";
                                        $x2 = $a->sexo;
                                        $y1 = "Masculino";
                                        $y2 = "M";
                                    }
                                    $sql_show = "SELECT codigo FROM turmas WHERE codigo != '$a->turma'";
                                    $stmt = $conn->prepare($sql_show);
                                    $stmt->execute();
                                    $turmas = $stmt->fetchAll(PDO::FETCH_OBJ);
                            ?>
                                
                                <form method="post" class="mt-2 mb-0" onsubmit="return verificaEditAluno();">
                                    <div class="d-flex">    
                                        <div class="mr-2">    
                                            <h6>Nome</h6>
                                            <input name="nome" id="nome" type="text" class="form-control mb-1" maxlenght="100" value="<?= $a->nome ?>" size="31" required>
                                            <h6>CPF</h6>
                                            <input name="cpf" id="cpf" type="text" class="form-control mb-1" maxlenght="11" value="<?= $a->cpf ?>" required>
                                            <h6>Senha</h6>
                                            <input name="senha" id="senha" type="text" class="form-control mb-1" maxlenght="10" value="<?= $a->senha ?>" required>
                                            <h6>Turma</h6>
                                            <select id="turma" name="turma" class="form-control mb-1">
                                                <option value="<?= $a->turma ?>"><?= $a->turma ?></option>
                                                <?php 
                                                    foreach($turmas as $t): 
                                                    $turma = $t->codigo;
                                                ?>
                                                    <option value="<?= $turma ?>"><?= $turma ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <h6>Matrícula</h6>
                                            <div class="d-flex mb-3">
                                                <input name="matricula" id="matricula" class="form-control" type="text" value="<?= $a->matricula ?>" readonly>
                                                <button type="button" onclick="geraMatricula();" class="btn btn-secondary ml-3">Gerar</button>
                                            </div>
                                        </div>
                                        <div class="ml-2">
                                            <h6>Responsável 1</h6>
                                            <input name="resp1" id="resp1" type="text" class="form-control mb-1" maxlenght="100" value="<?= $a->responsavel1 ?>" size="31" required>
                                            <h6>Responsável 2</h6>
                                            <input name="resp2" id="resp2" type="text" class="form-control mb-1" maxlenght="100" value="<?= $a->responsavel2 ?>">
                                            <h6>Gênero</h6>
                                            <select id="genero" name="genero" class="form-control mb-1">
                                                <option value="<?= $x2 ?>"><?= $x1 ?></option>
                                                <option value="<?= $y2 ?>"><?= $y1 ?></option>
                                            </select>
                                            <h6>Data de nascimento</h6>
                                            <input name="data" id="data" type="date" class="form-control mb-1" maxlenght="100" value="<?= $a->data_nascimento ?>">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <input type="submit" class="btn btn-success btn-lg" value="Salvar">
                                    </div>
                                
                                </form>
                                <?php
                                    if(isset($_POST['nome']) && isset($_POST['senha']) && isset($_POST['cpf']) && isset($_POST['resp1']) && isset($_POST['matricula']) && isset($_POST['data'])){
                                        alterAluno($a->nome,$a->senha,$a->cpf,$a->responsavel1,$a->responsavel2,$a->matricula,$a->sexo,$a->turma,$a->data_nascimento,$conn);
                                    }
                                    endforeach; 
                                ?> 
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
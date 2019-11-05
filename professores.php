<?php
    include "scripts/bdconn.php";
    $conn = getConnection();
    include "scripts/verifLogin.php";
    verificaLogAdmin2();
    $idAdmin = $_SESSION['adminLog'];
    include "scripts/adcProfessor.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Gerenciar Professores</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="libs/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon" />
    </head>
    <body onkeypress="para();">
        <div class="box-home container-fluid d-flex flex-column justify-content-center align-items-center">
            <div class="box-logged btn-block">
                <div>
                    <nav class="navbar navbar-expand-lg navbar-light bg-light d-flex justify-content-between">
                        <a class="navbar-brand" href="#"><img src="img/logo.png" class="img-fluid" width="100"></a>
                        <div class="d-flex justify-content-end">
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
                <div class="p-4 d-flex justify-content-center flex-column align-items-center">
                    <?php 
                        $sql_show = "SELECT * FROM professores ORDER BY nome asc";
                        $stmt = $conn->prepare($sql_show);
                        $stmt->execute();
                        $profs = $stmt->fetchAll(PDO::FETCH_OBJ);
                    ?>
                    <div class="container">
                        <div class="card mt-3">
                            <div class="card-header d-flex justify-content-between">
                                <h2 class="mr-5">Gerenciar Professores</h2>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Nome</th>
                                        <th>CPF</th>
                                        <th>Senha</th>
                                        <th>Alocação</th>
                                        <th>Alterações</th>
                                    </tr>
                                    <?php foreach($profs as $func): ?>
                                        <tr>
                                            <td><?= $func->nome; ?></td>
                                            <td><?= $func->cpf; ?></td>
                                            <td><?= $func->senha; ?></td>
                                            <td>
                                                <?php 
                                                    $aloc = $func->alocacao;
                                                    if($aloc === "0"){
                                                        echo "Não";
                                                    } else {
                                                        echo "Sim";
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <a href="edit.php?cpf=<?= $func->cpf ?>&c=3" class="btn btn-info">Editar</a>
                                                <a onclick="return confirm('Tem certeza que deseja excluir esse professor?')" href="scripts/profDelete.php?cpf=<?= $func->cpf ?>&aloc=<?= $aloc ?>" class="btn btn-danger">Excluir</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                        <td colspan="5">
                                            <h4 class="mb-3">Adicionar Professor</h4>
                                            <form method="post" class="d-flex justify-content-center align-items-center my-0" onsubmit="return validacaoProf();">
                                                Nome: <input class="mx-2 form-control" id="name" name="name" maxlenght="100"type="text" placeholder="Nome e Sobrenome" required>
                                                CPF: <input class="mx-2 form-control" id="cpf" name="cpf" maxlength="11" type="text" placeholder="CPF" required>
                                                Senha: <input class="mx-2 form-control" id="senha" name="senha" maxlength="15" type="text" placeholder="Senha" required>
                                                <input class="btn btn-success" type="submit" value="Adicionar">
                                            </form>
                                            <?php
                                                if(isset($_POST['name']) && isset($_POST['senha']) && isset($_POST['cpf'])){
                                                    cadastraProf();
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
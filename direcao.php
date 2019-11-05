<?php
    include "scripts/bdconn.php";
    $conn = getConnection();
    include "scripts/verifLogin.php";
    verificaLogAdmin2();
    $idAdmin = $_SESSION['adminLog'];
    
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Gerenciar Direção</title>
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
                        // Consulta SQL que irá retornar valores do DB
                        /*$sql_show = "SELECT * FROM direcao";
                        $stmt = $conn->prepare($sql_show);
                        $stmt->execute();*/
                        
                        $sql_show = "SELECT * FROM direcao WHERE funcao = '1'";
                        $stmt = $conn->prepare($sql_show);
                        $stmt->execute();
                        $diretor = $stmt->fetchAll(PDO::FETCH_OBJ);

                        $sql_show2 = "SELECT * FROM direcao WHERE funcao = '0'";
                        $stmt2 = $conn->prepare($sql_show2);
                        $stmt2->execute();
                        $vice_diretor = $stmt2->fetchAll(PDO::FETCH_OBJ);
                        
                        $verifica = $conn->prepare("SELECT cpf FROM direcao WHERE funcao = :x;"); // Diretor
                        $verifica->execute(array(':x' => "1"));
                        
                        $verifica2 = $conn->prepare("SELECT cpf FROM direcao WHERE funcao = :x;"); // Vice-diretor
                        $verifica2->execute(array(':x' => "0"));

                        #Aqui criamos uma variavel chamada "funcionarios" onde ele recebe o resultado do objeto "stmt". com a função fatchALL, retornamos a lista de nomes, um array, mas como objetos, onde chamaremos mais abaixo no foreach
                        
                    ?>
                    <!-------------------------------------------------TABELA ------------------------------------------------>
                    <div class="container">
                        <div class="card mt-3">
                            <div class="card-header d-flex justify-content-between">
                                <h2 class="mr-5">Gerenciar Direção</h2>
                                <div>
                                    <?php
                                        if($verifica->rowCount() === 0){
                                            echo "<a href='adcDirecao.php?funcao=1' class='btn btn-secondary btn-lg'>Adicionar Diretor</a>";
                                        }
                                        if($verifica2->rowCount() === 0){
                                            echo "<a href='adcDirecao.php?funcao=0' class='btn btn-secondary btn-lg ml-3'>Adicionar Vice-Diretor</a>";
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="card-body">
                                <h4>Diretor</h4>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Nome</th>
                                        <th>CPF</th>
                                        <th>Senha</th>
                                        <th>Alterações</th>
                                    </tr>
                                    <?php foreach($diretor as $func): ?>
                                        <tr>
                                            <td><?= utf8_encode($func->nome); ?></td>
                                            <td><?= $func->cpf; ?></td>
                                            <td><?= $func->senha; ?></td>
                                            <td>
                                                <a href="edit.php?cpf=<?= $func->cpf ?>&c=2" class="btn btn-info">Editar</a>
                                                <a onclick="return confirm('Tem certeza que deseja excluir esse membro?')" href="scripts/direcaoDelete.php?cpf=<?= $func->cpf ?>" class="btn btn-danger">Excluir</a>
                                            </td>
                                        </tr>
                                    <?php 
                                        endforeach;
                                        if($verifica->rowCount() === 0){
                                            echo "<tr><td colspan='4'><h5>Ainda não há diretor adicionado.</h5></td></tr>";
                                        }
                                    ?>
                                </table>
                                <h4>Vice-Diretor</h4>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Nome</th>
                                        <th>CPF</th>
                                        <th>Senha</th>
                                        <th>Alterações</th>
                                    </tr>
                                    <?php foreach($vice_diretor as $func): ?>
                                        <tr>
                                            <td><?= utf8_encode($func->nome); ?></td>
                                            <td><?= $func->cpf; ?></td>
                                            <td><?= $func->senha; ?></td>
                                            <td>
                                                <a href="edit.php?cpf=<?= $func->cpf ?>&c=2" class="btn btn-info">Editar</a>
                                                <a onclick="return confirm('Tem certeza que deseja excluir esse membro?')" href="scripts/direcaoDelete.php?cpf=<?= $func->cpf ?>" class="btn btn-danger">Excluir</a>
                                            </td>
                                        </tr>
                                    <?php 
                                        endforeach;
                                        if($verifica2->rowCount() === 0){
                                            echo "<tr><td colspan='4'><h5>Ainda não há vice-diretor adicionado.</h5></td></tr>";
                                        }
                                    ?>
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
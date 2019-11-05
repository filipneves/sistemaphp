<?php
    include "scripts/bdconn.php";
    $conn = getConnection();
    include "scripts/verifLogin.php";
    verificaLogAdmin2();
    $idAdmin = $_SESSION['adminLog'];
    include "scripts/adcAdmin.php";
    $consulta = $conn->query("SELECT cpf, chef FROM admins WHERE cpf = '$idAdmin';");
    while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
        if($linha['chef'] === "0"){
            echo ("<script>window.location.replace('adminLogged.php');</script>");
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Gerenciar Administradores - School+</title>
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
                        $sql_show = "SELECT * FROM admins WHERE cpf != $idAdmin ORDER BY nome asc";
                        $stmt = $conn->prepare($sql_show);
                        $stmt->execute();

                        #Aqui criamos uma variavel chamada "funcionarios" onde ele recebe o resultado do objeto "stmt". com a função fatchALL, retornamos a lista de nomes, um array, mas como objetos, onde chamaremos mais abaixo no foreach
                        $admins = $stmt->fetchAll(PDO::FETCH_OBJ);
                    ?>
                    <!-------------------------------------------------TABELA ------------------------------------------------>
                    <div class="container">
                        <div class="card mt-3">
                            <div class="card-header d-flex justify-content-between">
                                <h2 class="mr-5">Administradores</h2>
                            </div>
                            <div class="card-body">
                                <small>Obs: Seus dados não aparecem nesta seção, para alterá-los acesse a seção configurações (canto superior direito).</small>
                                <table class="table table-bordered mt-3">
                                    <tr>
                                        <th>Nome</th>
                                        <th>CPF</th>
                                        <th>Senha</th>
                                        <th>Alterações</th>
                                    </tr>
                                    <?php foreach($admins as $func): ?>
                                        <tr>
                                            <td><?= utf8_encode($func->nome); ?></td>
                                            <td><?= $func->cpf; ?></td>
                                            <td><?= $func->senha; ?></td>
                                            <td>
                                                <a href="edit.php?cpf=<?= $func->cpf ?>&c=1" class="btn btn-info">Alterar</a>
                                                <a onclick="return confirm('Tem certeza que deseja PROMOVER esse administrador para um ADMINISTRADOR SUPERIOR? Ao fazer isso você é automaticamente despromovido.')" href="scripts/promoAdmin.php?cpf=<?= $func->cpf ?>" class="btn btn-success">Promover</a>
                                                <a onclick="return confirm('Tem certeza que deseja EXCLUIR esse administrador?')" href="scripts/adminDelete.php?cpf=<?= $func->cpf ?>" class="btn btn-danger">Excluir</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                        <td colspan="5">
                                            <form method="post" class="d-flex justify-content-center align-items-center my-0" onsubmit="return validacaoProf();">
                                                Nome: <input class="mx-2 form-control" id="name" name="name" maxlenght="100"type="text" placeholder="Nome e Sobrenome" required>
                                                CPF: <input class="mx-2 form-control" id="cpf" name="cpf" maxlength="11"type="text" placeholder="CPF" required>
                                                Senha: <input class="mx-2 form-control" id="senha" name="senha" maxlength="15" type="text" placeholder="Senha" required>
                                                <input class="btn btn-success" type="submit" value="Adicionar">
                                            </form>
                                            <?php
                                                if(isset($_POST['name']) && isset($_POST['senha']) && isset($_POST['cpf'])){
                                                    cadastraAdmin();
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
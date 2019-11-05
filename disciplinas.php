<?php
    include "scripts/bdconn.php";
    $conn = getConnection();
    include "scripts/verifLogin.php";
    verificaLogAdmin2();
    $idAdmin = $_SESSION['adminLog'];
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Gerenciar Disciplinas</title>
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
                <div class="p-4 d-flex justify-content-center flex-column align-items-center">
                <div class="container">
                        <div class="card mt-3">
                            <div class="card-header d-flex justify-content-between">
                                <h2 class="mr-5">Gerenciar Disciplinas</h2>
                            </div>
                            <div class="card-body d-flex">
                                <?php 
                                    $sql_show = "SELECT * FROM disciplinas";
                                    $stmt = $conn->prepare($sql_show);
                                    $stmt->execute();
                                    $disciplinas = $stmt->fetchAll(PDO::FETCH_OBJ);
                                ?>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Disciplinas</th>
                                        <th>Excluir</th>
                                    </tr>
                                    <?php foreach($disciplinas as $x): ?>
                                    <tr>
                                        <td><?= $x->nome_disciplina ?></td>
                                        <td>
                                            <a onclick="return confirm('Tem certeza que deseja excluir essa disciplina?')" href="scripts/disciplinaDelete.php?cod=<?= $x->codigo_disciplina ?>" class="btn btn-danger">Excluir</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                        <td colspan="3">
                                            <h4 class="mb-3">Adicionar Disciplina</h4>
                                            <form method="post">    
                                                <input class="mx-2" type="text" name="disciplina" id="disciplina" maxlenght="100" required>
                                                <input type="submit" class="btn btn-success" value="Adicionar">
                                            </form>
                                            <?php
                                                if(isset($_POST['disciplina'])){
                                                    $disc = $_POST['disciplina'];
                                                    $sql_insert = "INSERT INTO disciplinas (codigo_disciplina, nome_disciplina) VALUES (?, ?)";
                                                    $stmt = $conn->prepare($sql_insert);
                                                    for($i = 1 ;  $i != 0 ; $i++){
                                                        $cod_disciplina = $i;
                                                        $verifica = $conn->prepare("SELECT * FROM disciplinas WHERE codigo_disciplina = :cod;");
                                                        $verifica->execute(array(':cod' => $cod_disciplina));
                                                        if($verifica->rowCount() === 0){
                                                            $discCod = $cod_disciplina;
                                                            $i = 0;
                                                            break;
                                                        }
                                                    }
                                                    $stmt->bindValue(1, $discCod);
                                                    $stmt->bindValue(2, $disc);
                                                    if($stmt->execute()){
                                                        /* Ao adicionar alguma disciplina ocorre um pequeno DELAY, pois o sistema está criando
                                                        4 colunas de notas na tabela NOTAS, cada coluna é referente a um período do ano */
                                                        for($j = 1 ; $j <= 4 ; $j++){
                                                            $disc2 = "nota_" . $discCod . "_p" . $j;
                                                            $sth = $conn->exec("ALTER TABLE notas ADD $disc2 DECIMAL(3,1)");
                                                        }
                                                        echo "<script>alert('Disciplina $disc adicionada.');</script>";
                                                        echo ("<script>window.location.replace('disciplinas.php');</script>");
                                                    } else {
                                                        echo "<script>alert('Algo deu errado!');</script>";
                                                    }
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
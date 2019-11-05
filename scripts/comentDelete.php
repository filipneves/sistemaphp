<?php
    include "bdconn.php";
    $matricula = $_GET['m'];
    $codigo = $_GET['c'];
    $conn = getConnection();
    $consulta = $conn->query("SELECT cpf FROM alunos WHERE matricula = '$matricula';");
    if($consulta->rowCount() == 0){
        echo ("<script>window.location.replace('coments.php');</script>");
    } 
    else{
        while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $cpf = $linha['cpf'];
        }
    }
    $sql_del = "DELETE FROM coment WHERE codigo = $codigo;";
    $stmt = $conn->prepare($sql_del);
    $stmt->execute();
    echo ("<script>alert('Comentário excluído com sucesso!');window.location.replace('../coments2.php?m=$matricula');</script>");
?>
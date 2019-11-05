<?php
    include "bdconn.php";
    $matricula = $_GET['m'];
    $conn = getConnection();
    $consulta = $conn->query("SELECT cpf FROM alunos WHERE matricula = '$matricula';");
    if($consulta->rowCount() == 0){
        echo ("<script>window.location.replace('faltas.php');</script>");
    } 
    else{
        while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $cpf = $linha['cpf'];
        }
    }
    $data = $_GET['data'];
    $sql_del = "DELETE FROM faltas WHERE aluno ='$cpf' AND data = '$data';";
    $stmt = $conn->prepare($sql_del);
    $stmt->execute();
    echo ("<script>alert('Falta excluída com sucesso!');window.location.replace('../faltas2.php?m=$matricula');</script>");
?>
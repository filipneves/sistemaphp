<?php
    include "bdconn.php";
    $cpf = $_GET['cpf'];
    $x = $_GET['aloc'];
    $conn = getConnection();
    if($x === "0"){
        $sql_del = "DELETE FROM professores WHERE cpf ='$cpf';";
        $stmt = $conn->prepare($sql_del);
        $stmt->execute();
    } else {
        echo "<script>alert('Esse professor não pode ser excluído, ele está cadastrado em uma turma. Para exclui-lo é necessário antes excluir a turma.');</script>";
    }
    echo ("<script>window.location.replace('../professores.php');</script>");
?>
<?php
    include "bdconn.php";
    $cpf = $_GET['cpf'];
    $conn = getConnection();
    $sql_del = "DELETE FROM alunos WHERE cpf ='$cpf';";
    $stmt = $conn->prepare($sql_del);
    $stmt->execute();
    $turma = $_GET['turma'];
    echo ("<script>window.location.replace('../alunos.php?id=$turma');</script>");
?>
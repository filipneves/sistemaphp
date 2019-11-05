<?php
    include "bdconn.php";
    $id = $_GET['id'];
    $conn = getConnection();
    $consulta = $conn->query("SELECT cpf_professor FROM turmas WHERE codigo = '$id';");
    while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
        $idProf = $linha['cpf_professor'];
    }
    $x = "0";
    $stmt2 = $conn->prepare('UPDATE professores SET alocacao = :valor WHERE cpf = :num');
    $stmt2->execute(array(
        ':num'   => $idProf,
        ':valor' => $x
    ));
    $sql_del = "DELETE FROM turmas WHERE codigo ='$id'";
    $stmt = $conn->prepare($sql_del);
    $stmt->execute();
    header('Location: ../turmas.php');
?>
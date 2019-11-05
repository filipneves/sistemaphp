<?php
    include "bdconn.php";
    $cpfLogged = $_SESSION['adminLog'];
    $cpf = $_GET['cpf'];
    $conn = getConnection();
    $stmt = $conn->prepare('UPDATE admins SET chef = :x WHERE cpf = :cpf');
    $stmt->execute(array(
      ':x'   => "1",
      ':cpf' => $cpf
    ));
    $stmt = $conn->prepare('UPDATE admins SET chef = :x WHERE cpf = :cpf');
    $stmt->execute(array(
      ':x'   => "0",
      ':cpf' => $cpfLogged
    ));
    echo ("<script>alert('Alteração Concluída, você será redirecionado para a página inicial.');</script>");
    echo ("<script>window.location.replace('../adminLogged.php');</script>");
?>
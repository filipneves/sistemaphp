<?php
    include "bdconn.php";
    $cpf = $_GET['cpf'];
    $conn = getConnection();
    $sql_del = "DELETE FROM admins WHERE cpf ='$cpf';";
    $stmt = $conn->prepare($sql_del);
    $stmt->execute();
    echo ("<script>window.location.replace('../admins.php');</script>");
?>
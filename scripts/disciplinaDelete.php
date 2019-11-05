<?php
    include "bdconn.php";
    $codigo = $_GET['cod'];
    $conn = getConnection();
    $consulta = $conn->query("SELECT count(codigo_disciplina) FROM disciplinas;");
    $sql_del = "DELETE FROM disciplinas WHERE codigo_disciplina ='$codigo'";
    $stmt = $conn->prepare($sql_del);
    $stmt->execute();
    for($i = 1 ; $i <= 4 ; $i++){
        $y = "nota_" . $codigo . "_p" . $i;
        $sth = $conn->exec("ALTER TABLE notas DROP $y;");
    }
    while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
        $num_disciplinas = $linha['count(codigo_disciplina)'];
    }
    for($i = $codigo; $i < $num_disciplinas; $i++){
        $i2 = $i + 1;
        $stmt = $conn->prepare('UPDATE disciplinas SET codigo_disciplina = :cod WHERE codigo_disciplina = :cod2');
        $stmt->execute(array(
            ':cod'   => $i,
            ':cod2' => $i2
        ));
        for($j = 1; $j <= 4; $j++){
            $h = "nota_$i" . "_p$j";
            $h2 = "nota_$i2" . "_p$j";
            $stmt2 = $conn->prepare("ALTER TABLE notas CHANGE COLUMN `$h2` $h DECIMAL(3,1);");
            $stmt2->execute();
        }
    }
    header('Location: ../disciplinas.php');
?>


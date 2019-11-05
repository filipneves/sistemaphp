<?php
    include "bdconn.php";
    $conn=getConnection();
    include "../libs/mpdf/mpdf.php";
    $sql_show = "SELECT codigo FROM turmas";
    $stmt = $conn->prepare($sql_show);
    $stmt->execute();
    $turmas = $stmt->fetchAll(PDO::FETCH_OBJ);
    $sql_show = "SELECT * FROM disciplinas";
    $stmt = $conn->prepare($sql_show);
    $stmt->execute();
    $num_disciplinas = $stmt->rowCount();
    $disciplinas = $stmt->fetchAll(PDO::FETCH_OBJ);
    $i = 1;
    foreach($disciplinas as $d):
        $nomed[$i] = $d->nome_disciplina;
        $i++;
    endforeach;
    foreach($turmas as $t):
        $turma = $t->codigo;
        for($p = 1 ; $p <= $num_disciplinas ; $p++){
            if(!(isset($nd[$p]))){
                $nd[$p] = 0;
            }
            if(!(isset($cd[$p]))){
                $cd[$p] = 0;
            }
            for($j = 1 ;$j <= 4; $j++){
                $x = "nota_" . $p . "_p" . $j;
                $sql_show = "SELECT $x FROM alunos, notas WHERE cpf = aluno AND turma = '$turma'";
                $stmt = $conn->prepare($sql_show);
                $stmt->execute();
                $alunosNotas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($alunosNotas as $a):
                    if(isset($a[$x])){
                        $nd[$p] += $a[$x];
                        $cd[$p]++;
                    }
                endforeach;
            }
        }
        echo "<table border='1'><tr><th>$turma</th></tr><tr>";
        for($p = 1 ; $p <= $num_disciplinas ; $p++){
            echo "<td>" . $nomed[$p] . "</td>";
        }
        echo "<td>Geral</td>";
        echo "</tr><tr>";
        $medg = 0;
        for($p = 1 ; $p <= $num_disciplinas ; $p++){
            if($cd[$p] === 0){
                $medt = "N.P";
            } else {
                $medt = number_format($nd[$p]/$cd[$p], 1, '.', '');
                $medg += $medt;
            }
            echo "<td>" . $medt . "</td>";
        }
        if($medg === 0){
            $medg2 = "N.P";
        } else {
            $medg2 = number_format($medg/$num_disciplinas, 1, '.', '');
        }
        echo "<td>" . $medg2 . "</td>";
        echo "</tr></table>";
    endforeach;
    
   /* $sql_show = "SELECT * FROM disciplinas";
    $stmt = $conn->prepare($sql_show);
    $stmt->execute();
    $disciplinas = $stmt->fetchAll(PDO::FETCH_OBJ);
    $num_disciplinas = $stmt->rowCount();
    $sql_show = "SELECT nome, $d, matricula FROM alunos, notas WHERE cpf = aluno AND turma = '$turma' ORDER BY nome asc";
    $stmt = $conn->prepare($sql_show);
    $stmt->execute();
    $alunosNotas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $consulta = $conn->query("SELECT nome FROM professores,turmas WHERE cpf = cpf_professor AND codigo = '$turma';");
    while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
        $nomeProf = $linha['nome'];
    }*/
?>

        
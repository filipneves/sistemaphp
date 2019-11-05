<?php
    include "bdconn.php";
    $conn=getConnection();
    include "../libs/mpdf/mpdf.php";
    $cpf = $_SESSION['alunoLog'];
    $sql_show = "SELECT * FROM disciplinas";
    $stmt = $conn->prepare($sql_show);
    $stmt->execute();
    $disciplinas = $stmt->fetchAll(PDO::FETCH_OBJ);
    $num_disciplinas = $stmt->rowCount();
    $sql_show = "SELECT * FROM alunos, notas WHERE cpf = aluno AND cpf = $cpf";
    $stmt = $conn->prepare($sql_show);
    $stmt->execute();
    $alunoNotas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $sql_show = "SELECT * FROM faltas WHERE aluno = $cpf";
    $stmt = $conn->prepare($sql_show);
    $stmt->execute();
    $alunoFaltas = $stmt->rowCount();
    $consulta = $conn->query("SELECT nome, matricula,turma FROM alunos WHERE cpf = '$cpf';");
    while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
        $nome = $linha['nome'];
        $matricula = $linha['matricula'];
        $turma = $linha['turma'];
    }
    $html="
        <div>
            <div align='center'>
                <span>BOLETIM</span>
            </div>
            <div>
                <span>Aluno: " . $nome . "</span><br>
                <span>Turma: " . $turma . "</span><br>
                <span>Matrícula: " . $matricula . "</span><br>
                <span>Documento gerado em: " . date("d/m/Y") . "</span><br>
            </div>
            <table border='1'>
                <tr>
                    <td></td>
                    <th colspan='" . $num_disciplinas . "' align='center'>Disciplinas</th>
                </tr>
                <tr>
                    <th align='center'><p>Período</p></th>";
                    foreach ($disciplinas as $z):
                        $html.="<th>$z->nome_disciplina</th>";
                    endforeach;
                foreach($alunoNotas as $a): 
                    for($i = 1; $i <= 4;$i++){
                        $html.= "<tr><th align='center'>$i" . "º</th>";
                        for($h = 1; $h <= $num_disciplinas;$h++){
                            if(!(isset($m[$h]))){
                                $m[$h] = 0;
                            }
                            if(!(isset($n[$h]))){
                                $n[$h] = 0;
                            }
                            $x = "nota_$h" . "_p$i";                                                       
                            if(isset($a[$x])){
                                if($a[$x] < 6){
                                    $c = "red";
                                } else{
                                    $c = "black";
                                }
                                $html.= "<td style='color:$c' align='center'>$a[$x]</td>";
                                $m[$h] += $a[$x];
                                $n[$h]++;
                            } else {
                                $html.= "<td align='center'><b>N.P</b></td>";
                            }
                            if($h === $num_disciplinas){
                                $html.= "</tr>";
                            }
                        }
                    }    
                endforeach;
    $html.="<tr><th>Média</th>";
    for($h = 1 ; $h <= $num_disciplinas; $h++){
        if($n[$h] === 0){
            $html.="<td align='center'><b>N.P</b></td>";
        } else {
            $f = $m[$h];
            $g = $n[$h];
            $html.="<td align='center'>" . number_format($f/$g, 1, '.', '') . "</td>";
        }
    }
    $html.="</tr></table></div>";
    $html.="<span>Número de Faltas: $alunoFaltas</span>";
    $mpdf=new mPDF(
    '',    // mode - default ''
    '',    // format - A4, for example, default ''
    0,     // font size - default 0
    '',    // default font family
    30,    // margin_left
    15,    // margin right
    15,     // margin top
    0,    // margin bottom
    6,     // margin header
    0,     // margin footer
    'P');  // L - landscape, P - portrait
    $mpdf->SetDisplayMode('fullpage');
    $arquivo="notas" . $matricula . ".pdf";
    $mpdf->WriteHTML($html);
    $mpdf->Output($arquivo, "I");
?>
<?php
    include "bdconn.php";
    $conn=getConnection();
    include "../libs/mpdf/mpdf.php";
    $p = $_GET['p'];
    $d = $_GET['d'];
    $periodo = "p" . $p;
    if(isset($_SESSION['turma'])){
        $turma=$_SESSION['turma'];
    } else{
        $turma=$_GET['turma'];
    }
    $sql_show = "SELECT * FROM disciplinas";
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
    }
    $html="
        <div>
            <div align='center'>
                <span>NOTAS - ". $p ."º PERÍODO</span>
            </div>
            <div>
                <span>Turma: " . $turma . "</span><br>
                <span>Professor(a): " . $nomeProf . "</span><br>
                <span>Documento gerado em: " . date("d/m/Y") . "</span><br>
            </div>
            <table border='1'>
                <tr>
                    <td colspan='2'></td>
                    <th colspan='". $num_disciplinas ."' align='center'>Disciplinas</th>
                </tr>
                <tr>
                    <th align='center'><p>Matrícula</p></th>
                    <th align='center'><p>Nome</p></th>";
                    foreach ($disciplinas as $z):
                        $html.="<th>$z->nome_disciplina</th>";
                    endforeach;
                "</tr>";
        foreach ($alunosNotas as $x):
            $html.="<tr><td><p>".$x['matricula']."</p></td><td><p>".$x['nome']."</p>";
            for($i = 1; $i <= $num_disciplinas;$i++){
                $y = "nota_" . $i . "_" . $periodo;                                                        
                if(isset($x[$y])){
                    $html.="<td>$x[$y]</td>";
                } else {
                    $html.="<td><b>N.P</b></td>";
                }
            }
            $html.="</tr>";
        endforeach;
        $html.="
        </table>
            <span><b>N.P = Não Pontuado</b></pan>
        </div>";
        $mpdf=new mPDF(
        '',    // mode - default ''
        'A4-L',    // format - A4, for example, default ''
        0,     // font size - default 0
        '',    // default font family
        15,    // margin_left
        15,    // margin right
        15,     // margin top
        0,    // margin bottom
        6,     // margin header
        0,     // margin footer
        'L');  // L - landscape, P - portrait
    $mpdf->SetDisplayMode('fullpage');
    $arquivo="notas" . $turma . "-" . $p ."periodo.pdf";
    $mpdf->WriteHTML($html);
    $mpdf->Output($arquivo, "I");
?>
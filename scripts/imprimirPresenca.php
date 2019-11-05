<?php
    include "bdconn.php";
    $conn=getConnection();
    include "../libs/mpdf/mpdf.php";
    $turma=$_SESSION['turma'];
    $sql_show="SELECT nome, matricula FROM alunos WHERE turma = '$turma' ORDER BY nome asc";
    $stmt=$conn->prepare($sql_show);
    $stmt->execute();
    $num_alunos = $stmt->rowCount();
    $cpf = $_SESSION['profLog'];
    $consulta = $conn->query("SELECT nome FROM professores WHERE cpf = '$cpf';");
    while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
        $nomeProf = $linha['nome'];
    }
    $alunos=$stmt->fetchAll(PDO::FETCH_OBJ);
    $html="
        <div>
            <div align='center'>
                <span>LISTA DE PRESENÇA</span>
            </div>
            <div>
                <span>Turma: " . $turma . "</span><br>
                <span>Professor(a): " . $nomeProf . "</span><br>
                <span>Documento gerado em: " . date("d/m/Y") . "</span><br>
            </div>
            <div>
                <span>* = Presente / F = Falta / FJ = Falta Justificada
            </div>
            <table border='1'>
                <tr>
                    <td></td>
                    <td></td>
                    <th colspan='5' align='center'>Datas</th>
                </tr>
                <tr>
                    <th align='center'><p>Matrícula</p></th>
                    <th align='center'><p>Nome</p></th>
                    <td>___/___</td>
                    <td>___/___</td>
                    <td>___/___</td>
                    <td>___/___</td>
                    <td>___/___</td>
                </tr>";
        foreach ($alunos as $x):
            $html.="<tr><td><p>".$x->matricula."</p></td><td><p>".$x->nome."</p></td><td></td><td></td><td></td><td></td><td></td></tr>";
        endforeach;
        $html.="</table></div>";
        $mpdf=new mPDF(
        '',    // mode - default ''
        '',    // format - A4, for example, default ''
        0,     // font size - default 0
        '',    // default font family
        35,    // margin_left
        15,    // margin right
        15,     // margin top
        0,    // margin bottom
        6,     // margin header
        0,     // margin footer
        'L');  // L - landscape, P - portrait
    $mpdf->SetDisplayMode('fullpage');
    $arquivo="listaFrequencia" . $turma . ".pdf";
    $mpdf->WriteHTML($html);
    $mpdf->Output($arquivo, "I");
?>
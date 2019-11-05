<script>
    function validacaoNota(){
        var listaNotas = document.getElementById("linhaNotas").getElementsByClassName("nota");
        var num_disciplinas = document.getElementById('num_disciplinas').value;
        for(var i = 0; i < num_disciplinas; i++){
            if(listaNotas[i].value > 10 || listaNotas[i].value < 0){
                alert("Todos os valores tem que estar no intervalo de 0 <= NOTA <= 10");
                return false;
            }
        }
    }
</script>
<?php
    function alterNotas($conn, $p, $cpf,$m) {
        $num_disciplinas = $_POST['num_disciplinas'];
        for($i = 1; $i <= $num_disciplinas; $i++){
            $x = "n" . $i;
            if(isset($_POST[$x])){
                $z = "nota_$i" . "_p$p";
                if($_POST[$x] === ""){
                    $y = NULL;
                } else {
                    $y =  $_POST[$x];
                }

                $stmt = $conn->prepare("UPDATE notas SET $z = :nota WHERE aluno = :cpf;");
                $stmt->execute(array(':cpf' => $cpf , ':nota' => $y));
            }
        }
        echo ("<script>alert('Alterações concluídas com sucesso!');window.location.replace('alterNotas.php?m=$m&p=$p');</script>");
    }
?>
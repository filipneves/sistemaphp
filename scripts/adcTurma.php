<?php
    $conn = getConnection();
    function cadastraTurma(){
        $conn = getConnection();
        $serie = $_POST['serie'];
        $turno = $_POST['turno'];
        $cod_turno = $turno[0];
        if($_POST['professor'] == NULL){
            echo "<script>alert('Escolha um professor para prosseguir. Caso não haja professor disponível é necessário que seja cadastrado.');</script>";
        }else{
            foreach(range('A', 'Z') as $letra) {
                $cod_turma = $serie . $letra . $cod_turno;
                $verifica = $conn->prepare("SELECT * FROM turmas WHERE codigo = :cod;");
                $verifica->execute(array(':cod' => $cod_turma));
                if($verifica->rowCount() === 0){
                    $professor = $_POST['professor'];
                    $sql_insert = "INSERT INTO turmas (codigo, cpf_professor, turno) VALUES (?, ?, ?)";
                    $stmt2 = $conn->prepare($sql_insert);
                    $stmt2->bindValue(1, $cod_turma);
                    $stmt2->bindValue(2, $professor);
                    $stmt2->bindValue(3, $turno);
                    $stmt3 = $conn->prepare('UPDATE professores SET alocacao = :aloc WHERE cpf = :id');
                    $stmt3->execute(array(
                        ':id'   => $professor,
                        ':aloc' => "1"
                    ));
        
                    if($stmt2->execute()){
                        # Mensagem de cadastro concluído
                        echo "<script>alert('Cadastro Concluído! O código da turma é $cod_turma.');</script>";
                        echo ("<script>window.location.replace('turmas.php');</script>");
                    } else {
                        # Mensagem informando que ocorreu algum erro
                        echo "<script>alert('Algo deu errado!');</script>";
                    }
                    break;
                }
            }
        }
    }
?>
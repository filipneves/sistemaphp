<?php
    function cadastraFalta($aluno,$matricula){
        $conn = getConnection();
        $data = $_POST['data'];
        $hoje = date('Y-m-d');
        if($data <= $hoje){
            if(isset($_POST['descricao'])){
                $descricao = $_POST['descricao'];
            } else {
                $descricao = "";
            }
            if(isset($_POST['justificada'])){
                $justificada = "1";
            } else {
                $justificada = "0";
            }
            $sql_insert = "INSERT INTO faltas (aluno, data, justificada, descricao) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql_insert);
            $stmt->bindValue(1, $aluno);
            $stmt->bindValue(2, $data);
            $stmt->bindValue(3, $justificada);
            $stmt->bindValue(4, $descricao);
            if($stmt->execute()){
                # Mensagem de cadastro concluído
                echo "<script>alert('Falta Cadastrada!');</script>";
                # Redirecionando para outra página
                echo ("<script>window.location.replace('faltas2.php?m=$matricula');</script>");
            } else {
                # Mensagem informando que ocorreu algum erro
                echo "<script>alert('Algo deu errado!');</script>";
            }
        }
        else {
            echo ("<script>alert('Data Inválida!');</script>");
        } 
    }
?>
<?php
    function cadastraComent($cpf,$matricula){
        $conn = getConnection();
        for($i = 0; $i < 1;){
            $codigo =  rand(100000,999999);
            $consulta = $conn->query("SELECT codigo FROM coment WHERE codigo = '$codigo';");
            if($consulta->rowCount() == 0){
                $i++;
            } 
        }
        $comentario = $_POST['descricao'];
        $stmt = $conn->prepare('INSERT INTO coment (codigo,texto,data_adc,cpf_aluno) VALUES(:codigo,:texto,:data_adc,:cpf_aluno)');
        $stmt->execute(array(
            ':codigo' => $codigo,
            ':texto' => $comentario,
            'data_adc' => date('Y-m-d'),
            ':cpf_aluno' => $cpf
        ));
        echo "<script>alert('Comentário Cadastrado!');</script>";
        echo ("<script>window.location.replace('coments2.php?m=$matricula');</script>");
    }
?>
<?php
    function cadastraAluno($turma,$conn){
        $cpf = $_POST['cpf'];
        $verifica = $conn->prepare("SELECT * FROM alunos WHERE cpf = :cpf");
        $verifica->execute(array(':cpf' => $cpf));
        $verifica2 = $conn->prepare("SELECT cpf FROM professores WHERE cpf = :cpf");
        $verifica2->execute(array(':cpf' => $cpf));
        $verifica3 = $conn->prepare("SELECT cpf FROM direcao WHERE cpf = :cpf");
        $verifica3->execute(array(':cpf' => $cpf));
        $verifica4 = $conn->prepare("SELECT cpf FROM admins WHERE cpf = :cpf");
        $verifica4->execute(array(':cpf' => $cpf));
        if($verifica->rowCount() === 0 && $verifica2->rowCount() === 0 && $verifica3->rowCount() === 0 && $verifica4->rowCount() === 0){
            $nome = $_POST['name'];
            $senha = $_POST['senha'];
            $nameResp = $_POST['nameResp1'];
            $nameResp2 = $_POST['nameResp2'];
            $nascimento = $_POST['dataNsc'];
            if($_POST['genre'] === "M"){
                $sexo = "Masculino";
            } else {
                $sexo = "Feminino";
            }
            $matricula = date("Y");
            $matricula = $matricula . rand(0000,9999);
            $verifica2 = $conn->prepare("SELECT * FROM alunos WHERE matricula = :mat");
            $verifica2->execute(array(':mat' => $matricula));
            if($verifica2->rowCount() === 0){
                $sql_insert = "INSERT INTO alunos (nome, cpf, matricula, sexo, responsavel1, responsavel2, data_nascimento, senha, turma) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql_insert);
                $stmt->bindValue(1, $nome);
                $stmt->bindValue(2, $cpf);
                $stmt->bindValue(3, $matricula);
                $stmt->bindValue(4, $sexo);
                $stmt->bindValue(5, $nameResp);
                $stmt->bindValue(6, $nameResp2);
                $stmt->bindValue(7, $nascimento);
                $stmt->bindValue(8, $senha);
                $stmt->bindValue(9, $turma);
                if($stmt->execute()){
                    $sql_insert2 = "INSERT INTO notas (aluno) VALUES (?)";
                    $stmt2 = $conn->prepare($sql_insert2);
                    $stmt2->bindValue(1, $cpf);
                    if($stmt2->execute()){
                        echo "<script>alert('Cadastro Concluído! O número de matricula é $matricula.');</script>";
                        echo ("<script>window.location.replace('alunos.php?id=$turma');</script>");
                    }
                } else {
                    echo "<script>alert('Algo deu errado!');</script>";
                }
            } else {
                /* A escolha da matrícula é feita de forma aleatória, são 8999 possibilidades, a chance de que
                   uma matrícula seja semelhante a outra já cadastrada é muito pequena. PORÉM, caso aconteça, é
                   solicitado que o administrador tente refazer o cadastro.*/
                echo "<script>alert('Ocorreu um erro...Tente Novamente.   :(');</script>";
                echo ("<script>window.location.replace('alunos.php?id=$turma');</script>");
            }
        } else {
            echo "<script>alert(CPF já cadastrado.');</script>";
        }
    }
?>
<script>
    function validarCPF(inputCPF){
        var soma = 0;
        var resto;
        var inputCPF = document.getElementById('cpf').value;

        if(inputCPF == '00000000000') return false;
        for(i=1; i<=9; i++) soma = soma + parseInt(inputCPF.substring(i-1, i)) * (11 - i);
        resto = (soma * 10) % 11;

        if((resto == 10) || (resto == 11)) resto = 0;
        if(resto != parseInt(inputCPF.substring(9, 10))) return false;

        soma = 0;
        for(i = 1; i <= 10; i++) soma = soma + parseInt(inputCPF.substring(i-1, i))*(12-i);
        resto = (soma * 10) % 11;

        if((resto == 10) || (resto == 11)) resto = 0;
        if(resto != parseInt(inputCPF.substring(10, 11))) return false;
        return true;
    }
    function validacaoAluno() {
        var erro = "";
        var nome = document.getElementById('name');
        if(nome.value.length < 6 || nome.value.length > 100){
            erro = erro + "- Nome Inválido\n"; 
        }
        var cpf = document.getElementById('cpf');
        if(!(validarCPF(cpf))){
            erro = erro + "- CPF Inválido\n";
        }
        var senha = document.getElementById('senha');
        if(senha.value.length < 5 || senha.value.length > 10){
            erro = erro + "- Senha Inválida\n";
        }
        var resp1 = document.getElementById('nameResp1');
        if(resp1.value.length < 6 || resp1.value.length > 100){
            erro = erro + "- Nome do Responsável 1 Inválido\n"; 
        }
        var resp2 = document.getElementById('nameResp2');
        if(resp2.value != ""){
            if(resp2.value.length < 6 || resp2.value.length > 100){
                erro = erro + "- Nome do Responsável 2 Inválido\n"; 
            }
        }
        if(erro != ""){
            alert(erro);
            return false;
        } else {
            var nome = nome.value;
            var cpf = cpf.value;
            var senha = senha.value;
            var resp1 = resp1.value;
            var resp2 = resp2.value;
            var genero = document.getElementById('genre').value; 
            var data = document.getElementById('dataNsc').value;
            var data2 = data[8] + data[9] + "/" + data[5] + data[6] + "/" + data[0] + data[1] + data[2] + data[3]; 
            var z = "Os dados estão corretos? \n\n Nome: " + nome + "\n CPF: " + cpf + "\n Senha: " + senha + "\n Responsável 1: " + resp1 + "\n Responsável 2: " + resp2 + "\n Gênero: " + genero + "\n Data de Nascimento: " + data2; 
            var x = confirm(z);
            if(x == false){
                return false;
            }
        }
    }
</script>

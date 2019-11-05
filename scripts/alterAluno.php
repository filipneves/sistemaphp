<?php
    function verificaUpdate($update) {
        if($update != ""){
            $update .= ", ";
        }
        return $update;
    }
    function alterAluno($nome,$senha,$cpf,$resp1,$resp2,$matricula,$genero,$turma,$data,$conn) {
        $update = "";
        if($nome != $_POST['nome']){
            $update .= "nome = " . "'" . $_POST['nome'] . "'";
        }
        if($senha != $_POST['senha']){
            $update = verificaUpdate($update);
            $update .= "senha = " . "'" . $_POST['senha'] . "'";
        }
        $conf = 0;
        if($cpf != $_POST['cpf']){
            $update = verificaUpdate($update);
            $verifica = $conn->prepare("SELECT cpf FROM professores WHERE cpf = :cpf");
            $verifica->execute(array(':cpf' => $_POST['cpf']));
            $verifica2 = $conn->prepare("SELECT cpf FROM admins WHERE cpf = :cpf");
            $verifica2->execute(array(':cpf' => $_POST['cpf']));
            $verifica3 = $conn->prepare("SELECT cpf FROM direcao WHERE cpf = :cpf");
            $verifica3->execute(array(':cpf' => $_POST['cpf']));
            $verifica4 = $conn->prepare("SELECT cpf FROM alunos WHERE cpf = :cpf");
            $verifica4->execute(array(':cpf' => $_POST['cpf']));
            if($verifica->rowCount() === 0 && $verifica2->rowCount() === 0 && $verifica3->rowCount() === 0 && $verifica4->rowCount() === 0){
                $update .= "cpf = " . "'" . $_POST['cpf'] . "'";
            } else {
                $conf = 1;
            }
        }
        if($matricula != $_POST['matricula']){
            $update = verificaUpdate($update);
            $update .= "matricula = " . "'" . $_POST['matricula'] . "'";
        }
        if($resp1 != $_POST['resp1']){
            $update = verificaUpdate($update);
            $update .= "responsavel1 = " . "'" . $_POST['resp1'] . "'";
        }
        if($resp2 != $_POST['resp2']){
            $update = verificaUpdate($update);
            $update .= "responsavel2 = " . "'" . $_POST['resp2'] . "'";
        }
        if($genero != $_POST['genero']){
            $update = verificaUpdate($update);
            $update .= "sexo = " . "'" . $_POST['genero'] . "'";
        }
        if($turma != $_POST['turma']){
            $update = verificaUpdate($update);
            $update .= "turma = " . "'" . $_POST['turma'] . "'";
        }
        if($data != $_POST['data']){
            $update = verificaUpdate($update);
            $update .= "data_nascimento = " . "'" . $_POST['data'] . "'";
        }
        if($conf === 0){
            if($update != ""){
                $stmt = $conn->prepare('UPDATE alunos SET ' . $update . ' WHERE cpf = ' . $cpf);
                $stmt->execute();
                echo "<script>alert('Alterações concluídas');window.location.replace('alunos.php?id=$turma');</script>";
            } else {
                echo "<script>alert('Nenhuma alteração foi feita');</script>";
            }
        } else{
            echo "<script>alert('O CPF informado já está cadastrado');</script>";
        }
        
        
    }
?>
<script>
    function geraMatricula() {
        var ano = new Date().getFullYear();
        var x = Math.floor(Math.random() * (9999 - 1000 + 1) + 1000);
        var y = ano.toString() + x.toString();
        document.getElementById('matricula').setAttribute('value', y);
    }

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

    function verificaEditAluno() {
        var erro = "";
        var nome = document.getElementById('nome');
        if(nome.value.length < 6 || nome.value.length > 100){
            erro = erro + "- Nome Inválido\n"; 
        }
        var resp1 = document.getElementById('resp1');
        if(resp1.value.length < 6 || resp1.value.length > 100){
            erro = erro + "- Nome do Responsável 1 Inválido\n"; 
        }
        var resp2 = document.getElementById('resp2');
        if(resp2.value.lenght != ""){
            if(resp2.value.length < 6 || resp2.value.length > 100){
                erro = erro + "- Nome do Responsável 2 Inválido\n"; 
            }
        }
        var cpf = document.getElementById('cpf');
        if(!(validarCPF(cpf))){
            erro = erro + "- CPF Inválido\n";
        }
        var senha = document.getElementById('senha');
        if(senha.value.length < 5 || senha.value.length > 10){
            erro = erro + "- Senha Inválida\n";
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
            var genero = document.getElementById('genero').value; 
            var turma = document.getElementById('turma').value;
            var data = document.getElementById('data').value;
            var data2 = data[8] + data[9] + "/" + data[5] + data[6] + "/" + data[0] + data[1] + data[2] + data[3]; 
            var z = "Os dados estão corretos? \n\n Nome: " + nome + "\n CPF: " + cpf + "\n Senha: " + senha + "\n Responsável 1: " + resp1 + "\n Responsável 2: " + resp2 + "\n Turma: " + turma + "\n Gênero: " + genero + "\n Data de Nascimento: " + data2; 
            var x = confirm(z);
            if(x == false){
                return false;
            }
        }
    }
</script>
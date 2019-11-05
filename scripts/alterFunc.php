<?php
    function alterFunc($nome,$cpf,$senha,$table,$conn){
        $i = 0;
        if($nome != $_POST['nome']){
            $stmt = $conn->prepare('UPDATE ' . $table . ' SET nome = :nome WHERE cpf = :id');
            $stmt->execute(array(
                ':id'   => $cpf,
                ':nome' => $_POST['nome']
            ));
            $i++;
        }
        if($senha != $_POST['senha']){
            $stmt = $conn->prepare('UPDATE ' . $table . ' SET senha = :senha WHERE cpf = :id');
            $stmt->execute(array(
                ':id'   => $cpf,
                ':senha' => $_POST['senha']
            ));
            $i++;
        }
        if($cpf != $_POST['cpf']){
            $verifica = $conn->prepare("SELECT cpf FROM professores WHERE cpf = :cpf");
            $verifica->execute(array(':cpf' => $_POST['cpf']));
            $verifica2 = $conn->prepare("SELECT cpf FROM admins WHERE cpf = :cpf");
            $verifica2->execute(array(':cpf' => $_POST['cpf']));
            $verifica3 = $conn->prepare("SELECT cpf FROM direcao WHERE cpf = :cpf");
            $verifica3->execute(array(':cpf' => $_POST['cpf']));
            $verifica4 = $conn->prepare("SELECT cpf FROM alunos WHERE cpf = :cpf");
            $verifica4->execute(array(':cpf' => $_POST['cpf']));
            if($verifica->rowCount() === 0 && $verifica2->rowCount() === 0 && $verifica3->rowCount() === 0 && $verifica4->rowCount() === 0){
                $stmt = $conn->prepare('UPDATE ' . $table .  ' SET cpf = :cpf WHERE cpf = :id');
                $stmt->execute(array(
                    ':id'   => $cpf,
                    ':cpf' => $_POST['cpf']
                ));
            } else {
                echo "<script>alert('CPF já cadastrado.');</script>";
            }
            $i++;
        }
        if($i != 0){
            echo "<script>alert('Alterações Concluídas');</script>";
            echo "<script>window.location.replace('$table.php');</script>";
        } else{
            echo "<script>alert('Nenhuma alteração foi feita');</script>";
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
    function validacaoFunc(){
        var erro = "";
        var nome = document.getElementById('nome');
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
        if(erro != ""){
            alert(erro);
            return false;
        } else {
            var nome = nome.value;
            var cpf = cpf.value;
            var senha = senha.value;
            var z = "Os dados estão corretos? \n\n Nome: " + nome + "\n CPF: " + cpf + "\n Senha: " + senha;
            var x = confirm(z);
            if(x == false){
                return false;
            }
        }
    }
</script>
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
    
    function validacaoProf() {
        var erro = "";
        var nome = document.getElementById('name');
        if(nome.value.length < 6 || nome.value.length > 100){
            erro = erro + "- Nome Inválido\n";
            /*alert('Nome inválido!');*/
            
        }
        var cpf = document.getElementById('cpf');
        if(!(validarCPF(cpf))){
            erro = erro + "- CPF Inválido\n";
            /*alert("CPF inválido");*/
            
        }
        var senha = document.getElementById('senha');
        if(senha.value.length < 5 || senha.value.length > 10){
            erro = erro + "- Senha Inválida\n";
            /*alert('Informe uma senha com no mínimo 5 caracteres e no máximo 10 caracteres');*/
            
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
<?php
    function cadastraDirecao(){
        $conn = getConnection();
        $cpf = $_POST['cpf'];
        $verifica = $conn->prepare("SELECT cpf FROM admins WHERE cpf = :cpf");
        $verifica->execute(array(':cpf' => $cpf));
        $verifica2 = $conn->prepare("SELECT cpf FROM professores WHERE cpf = :cpf");
        $verifica2->execute(array(':cpf' => $cpf));
        $verifica3 = $conn->prepare("SELECT cpf FROM direcao WHERE cpf = :cpf");
        $verifica3->execute(array(':cpf' => $cpf));
        $verifica4 = $conn->prepare("SELECT cpf FROM alunos WHERE cpf = :cpf");
        $verifica4->execute(array(':cpf' => $cpf));
        if($verifica->rowCount() === 0 && $verifica2->rowCount() === 0 && $verifica3->rowCount() === 0 && $verifica4->rowCount() === 0){
            $nome = $_POST['name'];
            $senha = $_POST['senha'];
            $funcao = $_GET['funcao'];
            $sql_insert = "INSERT INTO direcao (nome, cpf, senha, funcao) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql_insert);
            $stmt->bindValue(1, $nome);
            $stmt->bindValue(2, $cpf);
            $stmt->bindValue(3, $senha);
            $stmt->bindValue(4, $funcao);
            if($stmt->execute()){
                echo "<script>alert('Cadastro Concluído!');</script>";
                echo ("<script>window.location.replace('direcao.php');</script>");
            } else {
                echo "<script>alert('Algo deu errado!');</script>";
            }
        } else {
            echo "<script>alert('CPF já cadastrado!');</script>";
        }
    }
?>
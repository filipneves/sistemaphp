<?php
    
    function loginFunc(){
        # Recebendo conexão com o banco de dados
        $conn = getConnection();
        $cpf = $_POST['loginIdent'];
        $senha = $_POST['loginSenha'];
        $verifica = $conn->prepare("SELECT cpf FROM professores WHERE cpf = :cpf;");
        $verifica->execute(array(':cpf' => $cpf));
        if($verifica->rowCount() === 0){
            $verifica2 = $conn->prepare("SELECT cpf FROM admins WHERE cpf = :cpf;");
            $verifica2->execute(array(':cpf' => $cpf));
            if($verifica2->rowCount() === 0){
                $verifica3 = $conn->prepare("SELECT cpf FROM direcao WHERE cpf = :cpf;");
                $verifica3->execute(array(':cpf' => $cpf));
                if($verifica3->rowCount() === 0){
                    echo "<script>alert('Dados Incorretos!');</script>";
                } else {
                    $verifica4 = $conn->prepare("SELECT cpf FROM direcao WHERE cpf = :cpf AND senha = :senha;");
                    $verifica4->execute(array(':cpf' => $cpf, ':senha' => $senha));
                    if($verifica4->rowCount() === 0){
                        echo "<script>alert('Dados Incorretos!.');</script>";
                    } else {
                        $_SESSION['direcaoLog'] = "$cpf";
                        echo ("<script>window.location.replace('direcaoLogged.php');</script>");
                    }
                }
            } else {
                $verifica3 = $conn->prepare("SELECT cpf FROM admins WHERE cpf = :cpf AND senha = :senha;");
                $verifica3->execute(array(':cpf' => $cpf, ':senha' => $senha));
                if($verifica3->rowCount() === 0){
                    echo "<script>alert('Dados Incorretos!.');</script>";
                } else {
                    $_SESSION['adminLog'] = "$cpf";
                    echo ("<script>window.location.replace('adminLogged.php');</script>");
                }
            }
        } else {
            $verifica3 = $conn->prepare("SELECT cpf FROM professores WHERE cpf = :cpf AND senha = :senha");
            $verifica3->execute(array(':cpf' => $cpf, ':senha' => $senha));
            if($verifica3->rowCount() === 0){
                echo "<script>alert('Dados Incorretos!');</script>";
            } else {
                $_SESSION['profLog'] = "$cpf";
                echo ("<script>window.location.replace('profLogged.php');</script>");
            }
        }
    } 
            

    function loginAluno(){
        # Recebendo conexão com o banco de dados
        $conn = getConnection();
        # Amazenando email inserido
        $id = $_POST['loginMatriculaCpf'];
        # Verificando se já possui usuário com email cadastrado
        $x = strlen($id);
        if ($x === 11){
            $verifica = $conn->prepare("SELECT cpf FROM alunos WHERE cpf = :id;");
            $verifica->execute(array(':id' => $id));
            if($verifica->rowCount() === 0){
                # Se não existir, isso será informado
                echo "<script>alert('Não existe aluno cadastrado com esse CPF.');</script>";
            } else {
                # Se existir, é feito a verificação para ver se a senha inserida está atrelada ao email
                $senha = $_POST['loginSenha'];
                $verifica2 = $conn->prepare("SELECT senha FROM alunos WHERE cpf = :id AND senha = :senha;");
                $verifica2->execute(array(':id' => $id, ':senha' => $senha));
                if($verifica2->rowCount() === 0){
                    # Se não, será informado que a senha está incorreta
                    echo "<script>alert('A senha está incorreta!.');</script>";
                } else {
                    # Se sim, a sessão (SESSION) receberá o email do usuário e ele será redirecionada para outra página
                    $_SESSION['alunoLog'] = "$id";
                    echo ("<script>window.location.replace('homeAluno.php');</script>");
                    header('Location: homeAluno.php');
                }
            }
        } elseif ($x === 8) {
            $verifica = $conn->prepare("SELECT cpf FROM alunos WHERE matricula = :id;");
            $verifica->execute(array(':id' => $id));
            if($verifica->rowCount() === 0){
                # Se não existir, isso será informado
                echo "<script>alert('Não existe aluno cadastrado com essa matrícula.');</script>";
            } else {
                # Se existir, é feito a verificação para ver se a senha inserida está atrelada ao email
                $senha = $_POST['loginSenha'];
                $verifica2 = $conn->prepare("SELECT senha FROM alunos WHERE matricula = :id AND senha = :senha;");
                $verifica2->execute(array(':id' => $id, ':senha' => $senha));
                if($verifica2->rowCount() === 0){
                    # Se não, será informado que a senha está incorreta
                    echo "<script>alert('A senha está incorreta!.');</script>";
                } else {
                    while ($linha = $verifica->fetch(PDO::FETCH_ASSOC)) {
                        $id = $linha['cpf'];
                    }
                    # Se sim, a sessão (SESSION) receberá o email do usuário e ele será redirecionada para outra página
                    $consulta = $conn->query("SELECT cpf FROM alunos WHERE matricula = '$x';");
                    while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
                        $id = $linha['cpf'];
                    }
                    $_SESSION['alunoLog'] = "$id";
                    echo ("<script>window.location.replace('homeAluno.php');</script>");
                    header('Location: homeAluno.php');
                }
            }
        } else {
            echo "<script>alert('Login Inválido!.');</script>";
        }
    } 

?>
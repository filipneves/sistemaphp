<?php
    function verificaLogAluno(){
        if(isset($_SESSION['alunoLog'])){
            header('Location: homeAluno.php');
        }
    }

    function verificaLogAluno2(){
        if(!(isset($_SESSION['alunoLog']))){
            header('Location: index.php');
        }
    }

    function verificaLogAdmin(){
        if((isset($_SESSION['adminLog']))){
            header('Location: adminLogged.php');
        }
    }

    function verificaLogAdmin2(){
        if(!(isset($_SESSION['adminLog']))){
            header('Location: loginFunc.php');
        }
    }

    function verificaLogProf(){
        if((isset($_SESSION['profLog']))){
            header('Location: profLogged.php');
        }
    }

    function verificaLogProf2(){
        if(!(isset($_SESSION['profLog']))){
            header('Location: loginFunc.php');
        }
    }

    function verificaLogDirecao(){
        if((isset($_SESSION['direcaoLog']))){
            header('Location: profLogged.php');
        }
    }

    function verificaLogDirecao2(){
        if(!(isset($_SESSION['direcaoLog']))){
            header('Location: loginFunc.php');
        }
    }
?>
<?php
    session_start();
    function getConnection(){
        $dsn = 'mysql:host=localhost;dbname=id11261191_pccbd';
        $user = 'id11261191_root';
        $password = '123415263'; 
        try {
            $conn = new PDO($dsn, $user,$password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
        return $conn;
    }
?>
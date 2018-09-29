<?php
/**
 * Created by PhpStorm.
 * User: tassio
 * Date: 10/01/2018
 * Time: 11:11
 */

require_once "db/conexao.php";

session_start();
$login = $_POST['login'];
$passwd = $_POST['password'];

try {
    global $pdo;
    $statement = $pdo->prepare("SELECT Usuario, Senha FROM usuario WHERE Usuario = :login and Senha = :senha;");
    $statement->bindValue(":login", $login);
    $statement->bindValue(":senha", sha1($passwd));
    if ($statement->execute()) {
        $rs = $statement->fetch(PDO::FETCH_OBJ);
        $login = $rs->usuario;
        $passwd = $rs->Senha;
        if( $login!=null and $passwd != null)
        {
            $_SESSION['login'] = $login;
            $_SESSION['senha'] = $passwd;
            header('location:index.php');
        }
        else{
            unset ($_SESSION['login']);
            unset ($_SESSION['senha']);
            header('location:index.php');

        }
    } else {
        throw new PDOException("Erro: Não foi possível executar a declaração sql");
    }
} catch (PDOException $erro) {
    echo "Erro: ".$erro->getMessage();
}

?>
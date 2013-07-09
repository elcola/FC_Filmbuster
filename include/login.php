<?php

session_start();
include"dbms.inc.php";
if (isset($_POST["login"]) && isset($_POST["password"])) {
    $email = $_POST["login"];
    $pass = $_POST["password"];
    //connect to the mysql database/

    $sql = mysql_query("SELECT email FROM utenti WHERE email='$email' AND pass='$pass' ");
    //verifica che la persoan esista nel DB
    $existCount = mysql_num_rows($sql);
    if ($existCount == 1) {
        while ($row = mysql_fetch_array($sql)) {
            $email = $row["email"];
        }

        $_SESSION["login"] = $email;
        $_SESSION["password"] = $pass;

        header("location:../index.php?var=$email");
    } else {
        echo'Errore nei dati immessi riprova <a href="index.php">Click qui</a>';
    }
}
?>
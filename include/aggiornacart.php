<?php

session_start();
require "dbms.inc.php";


for ($i=0;$i<count($_SESSION['spesa']);$i++) {
    if($_POST["item".$_SESSION['spesa'][$i]['art_id']]!=$_SESSION['spesa'][$i]['quantity']){
        $_SESSION['tot']-= floatval($_SESSION['spesa'][$i]['quantity'])*$_SESSION['spesa'][$i]['prezzo'];
        $_SESSION['spesa'][$i]['quantity']=$_POST["item".$_SESSION['spesa'][$i]['art_id']];
        $_SESSION['tot']+= floatval($_SESSION['spesa'][$i]['quantity'])*$_SESSION['spesa'][$i]['prezzo'];
    }
}
header("location:../cart.php?");
?>
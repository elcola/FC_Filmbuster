<?php

session_start();
require "dbms.inc.php";

print_r($_SESSION['spesa'][0]['prezzo']) ;
$spesa=array();
$c=0;
$_SESSION['tot']=0.00;
for ($i=0;$i<count($_SESSION['spesa']);$i++) {
    if($_SESSION['spesa'][$i]['art_id']!=$_GET['id']){
        $spesa[$c]= array('art_id' => $_GET['id'],
    'quantity' => $_SESSION['spesa'][$i]['quantity'],
    'titolo' => $_SESSION['spesa'][$i]['titolo'],
    'immagine'=>$_SESSION['spesa'][$i]['immagine'],
    'prezzo'=>$_SESSION['spesa'][$i]['prezzo']);
        $_SESSION['tot']+= $_SESSION['spesa'][$i]['prezzo']*floatval($_SESSION['spesa'][$i]['quantity']);
        $c++;
    }
}
unset($_SESSION['spesa']);
$_SESSION['spesa'] = $spesa;

header("location:../cart.php?");
?>
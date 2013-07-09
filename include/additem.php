<?php

session_start();
require "dbms.inc.php";


$quantity = $_POST['quantity'];
$query= "SELECT titolo, immagine, prezzo FROM prodotti WHERE id='" . $_GET['id'] . "'";
$result = getResult($query);
$spesa = is_array($_SESSION['spesa']) ? $_SESSION['spesa'] : array();
$tot = is_float($_SESSION['tot']) ? $_SESSION['tot']: 0.00;
for ($i=0;$i<count($spesa);$i++){
    if($_SESSION['spesa'][$i]['art_id']==$_GET['id']){
        $_SESSION['spesa'][$i]['quantity']+=$quantity;
        $tot+= $result[0]['prezzo']*$quantity;
        $_SESSION['tot'] =$tot;
        goto a;
    }
}
$spesa[count($spesa)] = array('art_id' => $_GET['id'],
    'quantity' => $quantity,
    'titolo' => $result[0]['titolo'],
    'immagine'=>$result[0]['immagine'],
    'prezzo'=>$result[0]['prezzo']);
$tot+= $result[0]['prezzo']*$quantity;
$_SESSION['spesa'] = $spesa;
$_SESSION['tot'] =$tot;
a:

header("location:../prodotto.php?id=" . $_GET['id']);
?>
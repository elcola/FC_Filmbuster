<?php
session_start();

require "include/dbms.inc.php";
require "include/template2.inc.php";
$header = new Template("dtml/menu.html");
$oid = "SELECT nome FROM menu";
$result = getResult($oid);
$header->setContent("menu_place", $result);
if (isset($_SESSION["login"])) {
    $query_gruppo = "SELECT id_gruppo FROM utenti WHERE email='" . $_SESSION['login'] . "'";
    $gruppo = getResult($query_gruppo);

    if ($gruppo[0][id_gruppo] == 1) {
        $topbar = new Template("dtml/log_cliente.html");
        $queryute = "SELECT nome FROM utenti WHERE email='" . $_SESSION['login'] . "'";
        $ute = getResult($queryute);
        $topbar->setContent("utente_place", $ute);
        $i=0;
        foreach ($_SESSION['spesa'] as $key => $value){
            $i+=$value['quantity'];
        }
        $cart=array(
            'tot' => $_SESSION['tot'],
            'numero' => $i
        );
        $topbar->setContent("cart_place",$cart );
    } else if ($gruppo[0][id_gruppo] == 2) {
        $topbar = new Template("dtml/log_amministratore.html");
    } else {
        $topbar = new Template("dtml/log_titolare.html");
    }
} else {
    $topbar = new Template("dtml/not_logged.html");
}
$header->setContent("topbar_place", $topbar->get());

$footer = new Template("dtml/footer.html");
$skin = new Template("dtml/skin.html");
$lettera = new Template("dtml/a-z.html");
$result2=array('0-9','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
$lettera->setContent("lettera_place", $result2);
$body = new Template("dtml/content.html");
$oid3="SELECT id, titolo, immagine, prezzo
FROM Prodotti
WHERE genere='".$_GET['genere']."'
LIMIT ".$page.", 30";
$result3=getResult($oid3);
$body->setContent("titolo_place",$_GET['genere']);
$body->setContent("catalogo_place",$result3);
$skin->setContent("header",$header->get());
$skin->setContent("lettera",$lettera->get());
$skin->setContent("body",$body->get());
$skin->setContent("footer",$footer->get());
$skin->close();

?>
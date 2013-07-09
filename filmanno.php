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

$page=($_GET['page']-1)*30;
$body = new Template("dtml/content.html");
$oid3="SELECT id, titolo, immagine, prezzo
FROM Prodotti
WHERE anno='".$_GET['anno']."'
LIMIT ".$page.", 30";
$result3=getResult($oid3);
$body->setContent("titolo_place",$_GET['anno']);
$body->setContent("catalogo_place",$result3);
$oid4="SELECT count(*)as count
FROM Prodotti
WHERE anno='".$_GET['anno']."'";
$result4= getResult($oid4);
$result4[0]['current']= $_GET['page'];
$page = new Template("dtml/page.html");
$page->setContent("page_place",$result4);
$skin->setContent("header",$header->get());
$skin->setContent("body",$body->get());
$skin->setContent("page",$page->get());
$skin->setContent("footer",$footer->get());
$skin->close();
?>
<?php
session_start();

require "include/dbms.inc.php";
require "include/template2.inc.php";
$header = new Template("dtml/menu.html");
$oid = "SELECT nome FROM menu";
$result = getResult($oid);
$header->setContent("menu_place", $result);
$skin = new Template("dtml/skin.html");
$body = new Template("dtml/prodotto.html");
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
$queryprod = "SELECT * FROM prodotti WHERE id='" . $_GET['id'] . "'";
$prod = getResult($queryprod);
$body->setContent("prodotto_place", $prod);
$skin->setContent("header",$header->get());
$skin->setContent("body",$body->get());
$skin->setContent("footer",$footer->get());
$skin->close();

?>
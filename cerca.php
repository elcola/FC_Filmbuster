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
$search = new Template("dtml/cerca.html");
$search->setContent("search_place", $_POST['cerca']);
            // recuperiamo il valore ricerca inviato con get
            $ricerca = $_GET['ricerca'];
            // vediamo se è stato inviato, e quindi uguale a ok
            if ( $ricerca == 'ok' ) {
                // recuperiamo ora cerca inviato con post
                $cerca = $_POST['cerca'];
                // vediamo se è stato compilato il campo
                if ( $cerca == TRUE && $cerca != '' ) {
                    // ora vediamo se supera i tre caratteri
                    if ( strlen($cerca) >= 3 ) {
                        // ora depuriamo la stringa da cercare sul database
                        $cerca=str_replace("' ","&#39; ",$cerca);
                        $cerca=str_replace("'","&#39; ",$cerca);
                        $page=($_GET['page']-1)*30;
                        // ora possiamo effettuare la nostra ricerca sul db, state attenti alla sintassi
                        $query = "SELECT id, titolo, immagine, prezzo FROM prodotti WHERE titolo LIKE '%".$cerca."%' LIMIT ".$page.", 30";
                        $risultato = getResult($query);
                        $body = new Template("dtml/content.html");
                        $body->setContent("catalogo_place",$risultato);

            

            }else {
            echo "Devi inserire almeno 3 caratteri";

            }

            } else {
            echo "Non hai compilato il modulo ricerca";          
                
              
         }
         
    }
if ($_GET['page']!=''){   
$query = "SELECT count(*)as count FROM prodotti WHERE titolo LIKE '%".$cerca."%'";
$result4= getResult($query);
$result4[0]['current']= $_GET['page'];
$page = new Template("dtml/page.html");
$page->setContent("page_place",$result4);}
$skin->setContent("header",$header->get());
$skin->setContent("cerca",$search->get());
if(empty($body)== false){
$skin->setContent("body",$body->get());
$skin->setContent("page", $page->get());}
$skin->setContent("footer",$footer->get());
$skin->close();
?>
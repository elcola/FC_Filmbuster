<?php

Class categorie extends TagLibrary {

    function insertcategorie($name, $data, $pars) {
        foreach ($data as $key => $value) {
            $oid2 = "SELECT count(*)as count FROM prodotti WHERE genere='" . $value['nome'] . "'";
            $result2 = getResult($oid2);
            $content.="<h2><a href='/filmbuster/genere.php?genere=" . $value['nome'] . "&page=1' title='" . $value['nome'] . "'>" . $value['nome'] . "(" . $result2[0]['count'] . ")</a></h2><br />";
        }
        return $content;
    }

}

?>
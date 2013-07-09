<?php

Class anno extends TagLibrary {

    function insertanno($name, $data, $pars) {
        foreach ($data as $key => $value) {
            $oid2 = "SELECT count(*)as count FROM prodotti WHERE anno='" . $value['anno'] . "'";
            $result2 = getResult($oid2);
            $content.="<h2><a href='/filmbuster/filmanno.php?anno=" . $value['anno'] . "&amp;page=1' title='" . $value['anno'] . "'>" . $value['anno'] . "(" . $result2[0]['count'] . ")</a></h2><br />";
        }
        return $content;
    }

}

?>
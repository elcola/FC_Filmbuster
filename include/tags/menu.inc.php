<?php

Class menu extends TagLibrary {

    function insertmenu($name, $data, $pars) {
        foreach ($data as $key => $value) {

            switch ($value['nome']) {
                case 'categorie':
                    $content.="<li class='upmenu'><a title='" . $value['nome'] . "'>" . $value['nome'] . "</a>";
                    $content.="<div class='dd'><ul id='left'>";
                    $oid2 = "SELECT nome FROM submenu";
                    $result2 = getResult($oid2);
                    $numero = count($result2);
                    for ($i = 0; $i < intval($numero / 2); $i++) {
                        $content.="<a href='/filmbuster/genere.php?genere=" . $result2[$i]['nome'] . "&page=1' title='" . $result2[$i]['nome'] . "'><li>" . $result2[$i]['nome'] . "</li></a>";
                    }
                    $content.="</ul><ul id='right'>";
                    for ($i = intval($numero / 2); $i < $numero; $i++) {
                        $content.="<a href='/filmbuster/genere.php?genere=" . $result2[$i]['nome'] . "&page=1' title='" . $result2[$i]['nome'] . "'><li>" . $result2[$i]['nome'] . "</li></a>";
                    }
                    $content.="</ul></div></li>";
                    break;
                case 'anno':
                    $content.="<li class='upmenu'><a title='" . $value['nome'] . "'>" . $value['nome'] . "</a>";
                    $content.="<div class='dd'><ul><ul id='left'>";
                    $oid2 = "SELECT anno FROM anno";
                    $result2 = getResult($oid2);
                    $numero = count($result2);
                    for ($i = 0; $i < intval($numero / 2); $i++) {
                        $content.="<a href='/filmbuster/filmanno.php?anno=" . $result2[$i]['anno'] . "&page=1' title='" . $result2[$i]['anno'] . "'><li>" . $result2[$i]['anno'] . "</li></a>";
                    }
                    $content.="</ul><ul id='right'>";
                    for ($i = intval($numero / 2); $i < $numero; $i++) {
                        $content.="<a href='/filmbuster/filmanno.php?anno=" . $result2[$i]['anno'] . "&page=1' title='" . $result2[$i]['anno'] . "'><li>" . $result2[$i]['anno'] . "</li></a>";
                    }
                    $content.="</ul></div></li>";
                    break;
                case 'a-z':
                    $content.="<li class='upmenu'><a href='/filmbuster/" . $value['nome'] . ".php' title='" . $value['nome'] . "'>" . $value['nome'] . "</a>";
                    $content.="<div class='dd'><ul><ul id='left'>";
                    $oid2 = "SELECT anno FROM anno";
                    $result2 = array('0-9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
                    $numero = count($result2);
                    for ($i = 0; $i < intval($numero / 2) + 1; $i++) {
                        $content.="<a href='/filmbuster/lettera.php?lettera=" . $result2[$i] . "&page=1' title='" . $result2[$i] . "'><li>" . $result2[$i] . "</li></a>";
                    }
                    $content.="</ul><ul id='right'>";
                    for ($i = intval($numero / 2) + 1; $i < $numero; $i++) {
                        $content.="<a href='/filmbuster/lettera.php?lettera=" . $result2[$i] . "&page=1' title='" . $result2[$i] . "'><li>" . $result2[$i] . "</li></a>";
                    }
                    $content.="</ul></div></li>";
                    break;
                case 'home':
                    $content.="<li><a href='/filmbuster/index.php' title='" . $value['nome'] . "'>" . $value['nome'] . "</a></li>";
                    break;
                default:
                    $content.="<li><a href='/filmbuster/" . $value['nome'] . ".php' title='" . $value['nome'] . "'>" . $value['nome'] . "</a></li>";
                    break;
            }
        }
        return $content;
    }

}

?>
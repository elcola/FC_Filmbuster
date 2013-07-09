<?php

Class form extends TagLibrary {

    function lettera($name, $data, $pars) {
        foreach ($data as $key => $value) {
            if ($value == '0-9') {
                $content.="<li class='first'><a class='padd_first'title='" . $value . "' href='/filmbuster/lettera.php?lettera=" . $value . "&page=1'>" . $value . "</a></li>";
            }
            else
                $content.="<li><a title='" . $value . "' href='/filmbuster/lettera.php?lettera=" . $value . "&page=1'>" . $value . "</a></li>";
        }
        return $content;
    }

    function search($name, $data, $pars) {
        $data = str_replace("'", "&#39;", $data);
        $content.="<input type='text' name='cerca' value='" . $data . "'><input type='submit' value='Invia'>";
        return $content;
    }

}

?>
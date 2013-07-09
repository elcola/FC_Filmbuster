<?php

Class titolo extends TagLibrary {

    function inserttitolo($name, $data, $pars) {
        switch ($data) {
            case 'A':
            case 'B':
            case 'C':
            case 'D':
            case 'E':
            case 'F':
            case 'G':
            case 'H':
            case 'I':
            case 'J':
            case 'K':
            case 'L':
            case 'M':
            case 'N':
            case 'O':
            case 'P':
            case 'Q':
            case 'R':
            case 'S':
            case 'T':
            case 'U':
            case 'V':
            case 'W':
            case 'X':
            case 'Y':
            case 'Z':$content.="<h2>Film con la lettera &quot;" . $data . "&quot;</h2>";
                break;
            default: $content.="<h2>" . $data . "</h2>";
                break;
        }
        return $content;
    }

}

?>
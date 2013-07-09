<?php

Class catalogo extends TagLibrary {

    function insertcatalogo($name, $data, $pars) {
        foreach ($data as $key => $value) {
            $prezzo_int=intval($value['prezzo']);
            $prezzo_dec=intval(($value['prezzo']-floatval($prezzo_int))*100);
            if ($prezzo_dec < 10) {

                
                        
                $content.="<div class='product'>
    <a class='left' href='prodotto.php?id=" . $value['id'] . "' title='" . $value['titolo'] . "'><img src='img/film/" . $value['immagine'] . "' alt='" . $value['nome'] . "' /></a>
    <div class='price'>
        <div class='inner'>
            <span class='title'>Price</span>
            <strong><span>&#8364;</span>" . $prezzo_int . "<sup>.0" . $prezzo_dec . "</sup></strong>
        </div>
    </div>
    <div class='info'>
        <a href='prodotto.php?id=" . $value['id'] . "'><p class='titolo'>" . $value['titolo'] . "</p></a><br />
    </div>
</div>";
            } else {
                $content.="<div class='product'>
    <a class='left' href='prodotto.php?id=" . $value['id'] . "' title='" . $value['titolo'] . "'><img src='img/film/" . $value['immagine'] . "' alt='" . $value['nome'] . "' /></a>
    <div class='price'>
        <div class='inner'>
            <span class='title'>Price</span>
            <strong><span>&#8364; </span>" . $prezzo_int. "<sup>." . $prezzo_dec. "</sup></strong>
        </div>
    </div>
    <div class='info'>
        <a href='prodotto.php?id=" . $value['id'] . "'><p class='titolo'>" . $value['titolo'] . "</p></a><br />
    </div>
</div>";

            }
        }
        return $content;
    }

    function page($name, $data, $pars) {
        $prev1 = $data[0]['current'] - 1;
        $next1 = $data[0]['current'] + 1;
        $last = intval($data[0]['count'] / 31) + 1;
        if ($data[0]['current'] > '1') {
            $content.="<td class='pager'><a href='/filmbuster/animazione.php?page=" . $prev1 . "' style='text-decoration: none;'><b>«</b></a></td>";
        }
        $content.="<td class='pagebr'>&nbsp;</td><td class='highlight'><b>1</b></td>";
        if ($data[0]['current'] == $last) {
            
        } else {
            $content.="<td class='pagebr'>&nbsp;</td>
                <td class='pager'><a href='/filmbuster/animazione.php?page=" . $next1 . "' style='text-decoration: none;'><b>»</b></a></td>";
        }
        $content.="<td class='pagebr'>&nbsp;</td><td class='pager'>di " . $last . "</td>";
        /* switch($last){
          case '1':$content.="<td class='highlight'><b>1</b></td><td class='pagebr'>&nbsp;</td>";break;
          case '2':
          switch($data[0]['current']){
          case '1':$content.="<td class='highlight'><b>1</b></td><td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='2' href='/filmbuster/animazione.php?page=2' style='text-decoration: none;'><b>2</b></a></td>
          <td class='pagebr'>&nbsp;</td>";break;
          case '2':$content.="<td class='pager'><a title='1' href='/filmbuster/animazione.php?page=1' style='text-decoration: none;'><b>1</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='highlight'><b>2</b></td><td class='pagebr'>&nbsp;
          </td>";break;
          }break;
          case '3':
          switch($data[0]['current']){
          case '1':$content.="<td class='highlight'><b>1</b></td><td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='2' href='/filmbuster/animazione.php?page=2' style='text-decoration: none;'><b>2</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='3' href='/filmbuster/animazione.php?page=3' style='text-decoration: none;'><b>3</b></a></td>
          <td class='pagebr'>&nbsp;</td>";break;
          case '2':$content.="<td class='pager'><a title='1' href='/filmbuster/animazione.php?page=1' style='text-decoration: none;'><b>1</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='highlight'><b>2</b></td><td class='pagebr'>&nbsp;</td>
          <td class='pagebr'>&nbsp;</td><td class='pager'><a title='3' href='/filmbuster/animazione.php?page=3' style='text-decoration: none;'><b>3</b></a></td>
          <td class='pagebr'>&nbsp;</td>";break;
          case '3':$content.="<td class='pager'><a title='1' href='/filmbuster/animazione.php?page=1' style='text-decoration: none;'><b>1</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='2' href='/filmbuster/animazione.php?page=2' style='text-decoration: none;'><b>2</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='highlight'><b>3</b></td><td class='pagebr'>&nbsp;</td>";break;
          }break;
          case '4':
          switch($data[0]['current']){
          case '1':$content.="<td class='highlight'><b>1</b></td><td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='2' href='/filmbuster/animazione.php?page=2' style='text-decoration: none;'><b>2</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='3' href='/filmbuster/animazione.php?page=3' style='text-decoration: none;'><b>3</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='4' href='/filmbuster/animazione.php?page=4' style='text-decoration: none;'><b>4</b></a></td>
          <td class='pagebr'>&nbsp;</td>";break;
          case '2':$content.="<td class='pager'><a title='1' href='/filmbuster/animazione.php?page=1' style='text-decoration: none;'><b>1</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='highlight'><b>2</b></td><td class='pagebr'>&nbsp;</td>
          <td class='pagebr'>&nbsp;</td><td class='pager'><a title='3' href='/filmbuster/animazione.php?page=3' style='text-decoration: none;'><b>3</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='4' href='/filmbuster/animazione.php?page=4' style='text-decoration: none;'><b>4</b></a></td>
          <td class='pagebr'>&nbsp;</td>";break;
          case '3':$content.="<td class='pager'><a title='1' href='/filmbuster/animazione.php?page=1' style='text-decoration: none;'><b>1</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='2' href='/filmbuster/animazione.php?page=2' style='text-decoration: none;'><b>2</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='highlight'><b>3</b></td><td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='4' href='/filmbuster/animazione.php?page=4' style='text-decoration: none;'><b>4</b></a></td>
          <td class='pagebr'>&nbsp;</td>";break;
          case '4':$content.="<td class='pager'><a title='1' href='/filmbuster/animazione.php?page=1' style='text-decoration: none;'><b>1</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='2' href='/filmbuster/animazione.php?page=2' style='text-decoration: none;'><b>2</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='3' href='/filmbuster/animazione.php?page=3' style='text-decoration: none;'><b>3</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='highlight'><b>4</b></td><td class='pagebr'>&nbsp;</td>";break;
          }break;
          case '5':
          switch($data[0]['current']){
          case '1':$content.="<td class='highlight'><b>1</b></td><td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='2' href='/filmbuster/animazione.php?page=2' style='text-decoration: none;'><b>2</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='3' href='/filmbuster/animazione.php?page=3' style='text-decoration: none;'><b>3</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='4' href='/filmbuster/animazione.php?page=4' style='text-decoration: none;'><b>4</b></a></td>
          <td class='pagebr'>&nbsp;</td><td class='pager'><a title='5' href='/filmbuster/animazione.php?page=5' style='text-decoration: none;'><b>5</b></a></td>
          <td class='pagebr'>&nbsp;</td>";break;
          case '2':$content.="<td class='pager'><a title='1' href='/filmbuster/animazione.php?page=1' style='text-decoration: none;'><b>1</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='highlight'><b>2</b></td><td class='pagebr'>&nbsp;</td>
          <td class='pagebr'>&nbsp;</td><td class='pager'><a title='3' href='/filmbuster/animazione.php?page=3' style='text-decoration: none;'><b>3</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='4' href='/filmbuster/animazione.php?page=4' style='text-decoration: none;'><b>4</b></a></td>
          <td class='pagebr'>&nbsp;</td><td class='pager'><a title='5' href='/filmbuster/animazione.php?page=5' style='text-decoration: none;'><b>5</b></a></td>
          <td class='pagebr'>&nbsp;</td>";break;
          case '3':$content.="<td class='pager'><a title='1' href='/filmbuster/animazione.php?page=1' style='text-decoration: none;'><b>1</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='2' href='/filmbuster/animazione.php?page=2' style='text-decoration: none;'><b>2</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='highlight'><b>3</b></td><td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='4' href='/filmbuster/animazione.php?page=4' style='text-decoration: none;'><b>4</b></a></td>
          <td class='pagebr'>&nbsp;</td><td class='pager'><a title='5' href='/filmbuster/animazione.php?page=5' style='text-decoration: none;'><b>5</b></a></td>
          <td class='pagebr'>&nbsp;</td>";break;
          case '4':$content.="<td class='pager'><a title='1' href='/filmbuster/animazione.php?page=1' style='text-decoration: none;'><b>1</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='2' href='/filmbuster/animazione.php?page=2' style='text-decoration: none;'><b>2</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='3' href='/filmbuster/animazione.php?page=3' style='text-decoration: none;'><b>3</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='highlight'><b>4</b></td><td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='5' href='/filmbuster/animazione.php?page=5' style='text-decoration: none;'><b>5</b></a></td>
          <td class='pagebr'>&nbsp;</td>";break;
          case '5':case '4':$content.="<td class='pager'><a title='1' href='/filmbuster/animazione.php?page=1' style='text-decoration: none;'><b>1</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='2' href='/filmbuster/animazione.php?page=2' style='text-decoration: none;'><b>2</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='3' href='/filmbuster/animazione.php?page=3' style='text-decoration: none;'><b>3</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='4' href='/filmbuster/animazione.php?page=4' style='text-decoration: none;'><b>4</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='highlight'><b>5</b></td><td class='pagebr'>&nbsp;</td>";break;
          }break;
          case '6':
          switch($data[0]['current']){
          case '1':$content.="<td class='highlight'><b>1</b></td><td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='2' href='/filmbuster/animazione.php?page=2' style='text-decoration: none;'><b>2</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='3' href='/filmbuster/animazione.php?page=3' style='text-decoration: none;'><b>3</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='4' href='/filmbuster/animazione.php?page=4' style='text-decoration: none;'><b>4</b></a></td>
          <td class='pagebr'>&nbsp;</td><td class='pager'><a title='5' href='/filmbuster/animazione.php?page=5' style='text-decoration: none;'><b>5</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='6' href='/filmbuster/animazione.php?page=6' style='text-decoration: none;'><b>6</b></a></td>
          <td class='pagebr'>&nbsp;</td>";break;
          case '2':$content.="<td class='pager'><a title='1' href='/filmbuster/animazione.php?page=1' style='text-decoration: none;'><b>1</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='highlight'><b>2</b></td><td class='pagebr'>&nbsp;</td>
          <td class='pagebr'>&nbsp;</td><td class='pager'><a title='3' href='/filmbuster/animazione.php?page=3' style='text-decoration: none;'><b>3</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='4' href='/filmbuster/animazione.php?page=4' style='text-decoration: none;'><b>4</b></a></td>
          <td class='pagebr'>&nbsp;</td><td class='pager'><a title='5' href='/filmbuster/animazione.php?page=5' style='text-decoration: none;'><b>5</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='6' href='/filmbuster/animazione.php?page=6' style='text-decoration: none;'><b>6</b></a></td>
          <td class='pagebr'>&nbsp;</td>";break;
          case '3':$content.="<td class='pager'><a title='1' href='/filmbuster/animazione.php?page=1' style='text-decoration: none;'><b>1</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='2' href='/filmbuster/animazione.php?page=2' style='text-decoration: none;'><b>2</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='highlight'><b>3</b></td><td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='4' href='/filmbuster/animazione.php?page=4' style='text-decoration: none;'><b>4</b></a></td>
          <td class='pagebr'>&nbsp;</td><td class='pager'><a title='5' href='/filmbuster/animazione.php?page=5' style='text-decoration: none;'><b>5</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='6' href='/filmbuster/animazione.php?page=6' style='text-decoration: none;'><b>6</b></a></td>
          <td class='pagebr'>&nbsp;</td>";break;
          case '4':$content.="<td class='pager'><a title='1' href='/filmbuster/animazione.php?page=1' style='text-decoration: none;'><b>1</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='2' href='/filmbuster/animazione.php?page=2' style='text-decoration: none;'><b>2</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='3' href='/filmbuster/animazione.php?page=3' style='text-decoration: none;'><b>3</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='highlight'><b>4</b></td><td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='5' href='/filmbuster/animazione.php?page=5' style='text-decoration: none;'><b>5</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='6' href='/filmbuster/animazione.php?page=6' style='text-decoration: none;'><b>6</b></a></td>
          <td class='pagebr'>&nbsp;</td>";break;
          case '5':$content.="<td class='pager'><a title='1' href='/filmbuster/animazione.php?page=1' style='text-decoration: none;'><b>1</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='2' href='/filmbuster/animazione.php?page=2' style='text-decoration: none;'><b>2</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='3' href='/filmbuster/animazione.php?page=3' style='text-decoration: none;'><b>3</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='4' href='/filmbuster/animazione.php?page=4' style='text-decoration: none;'><b>4</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='highlight'><b>5</b></td><td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='6' href='/filmbuster/animazione.php?page=6' style='text-decoration: none;'><b>6</b></a></td>
          <td class='pagebr'>&nbsp;</td>";break;
          case '6':$content.="<td class='pager'><a title='1' href='/filmbuster/animazione.php?page=1' style='text-decoration: none;'><b>1</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='2' href='/filmbuster/animazione.php?page=2' style='text-decoration: none;'><b>2</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='3' href='/filmbuster/animazione.php?page=3' style='text-decoration: none;'><b>3</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='4' href='/filmbuster/animazione.php?page=4' style='text-decoration: none;'><b>4</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='5' href='/filmbuster/animazione.php?page=5' style='text-decoration: none;'><b>5</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='highlight'><b>6</b></td><td class='pagebr'>&nbsp;</td>";break;
          }break;

          default:

          }
          switch($data[0]['current']){
          case '1':
          $content.="<td class='highlight'><b>1</b></td><td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='2' href='/filmbuster/animazione.php?page=0' style='text-decoration: none;'><b>1</b></a></td>
          <td class='pagebr'>&nbsp;</td>
          <td class='pager'><a title='6&nbsp;-&nbsp;10' href='/filmbuster/animazione.php?page=1' style='text-decoration: none;'><b>2</b></a></td>
          <td class='pagebr'>&nbsp;</td>";
          } */
        /* <td class="pager"><a href="/index.php?page=6" style="text-decoration: none;"><b>«</b></a></td>
          <td class="pagebr">&nbsp;</td>
          <td class="pager"><a title="1&nbsp;-&nbsp;5" href="/index.php?page=0" style="text-decoration: none;"><b>1</b></a></td>
          <td class="pagebr">&nbsp;</td>
          <td class="pager"><a title="6&nbsp;-&nbsp;10" href="/index.php?page=1" style="text-decoration: none;"><b>2</b></a></td>
          <td class="pagebr">&nbsp;</td>
          <td class="pager"><a title="11&nbsp;-&nbsp;15" href="/index.php?page=2" style="text-decoration: none;"><b>3</b></a></td>
          <td class="pagebr">&nbsp;</td>
          <td class="pager">...</td>
          <td class="pagebr">&nbsp;</td>
          <td class="pager"><a title="26&nbsp;-&nbsp;30" href="/index.php?page=5" style="text-decoration: none;"><b>6</b></a></td>
          <td class="pagebr">&nbsp;</td>
          <td class="pager"><a title="31&nbsp;-&nbsp;35" href="/index.php?page=6" style="text-decoration: none;"><b>7</b></a></td>
          <td class="pagebr">&nbsp;</td>
          <td class="highlight"><b>8</b></td>
          <td class="pagebr">&nbsp;</td>
          <td class="pager"><a title="41&nbsp;-&nbsp;45" href="/index.php?page=8" style="text-decoration: none;"><b>9</b></a></td>
          <td class="pagebr">&nbsp;</td>
          <td class="pager"><a title="46&nbsp;-&nbsp;50" href="/index.php?page=9" style="text-decoration: none;"><b>10</b></a></td>
          <td class="pagebr">&nbsp;</td>
          <td class="pager">...</td>
          <td class="pagebr">&nbsp;</td>
          <td class="pager"><a title="4536&nbsp;-&nbsp;4540" href="/index.php?page=907" style="text-decoration: none;"><b>908</b></a></td>
          <td class="pagebr">&nbsp;</td>
          <td class="pager"><a title="4541&nbsp;-&nbsp;4545" href="/index.php?page=908" style="text-decoration: none;"><b>909</b></a></td>
          <td class="pagebr">&nbsp;</td>
          <td class="pager"><a title="4546&nbsp;-&nbsp;4546" href="/index.php?page=909" style="text-decoration: none;"><b>910</b></a></td>
          <td class="pagebr">&nbsp;</td>
          <td class="pager"><a href="/index.php?page=8" style="text-decoration: none;"><b>»</b></a></td> */
        return $content;
    }

}

?>
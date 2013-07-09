<?php
Class cart extends TagLibrary {

    function insertcart ($name, $data, $pars) {
        foreach ($data as $key => $value) {
                $content.="<tr class='cart-product'>
                <td><a href='prodotto.php?id=".$value['art_id']."' title='".$value['titolo']."' class='product-image'><img src='img/film/".$value['immagine']."' width='75' height='75' alt='".$value['titolo']."'></a></td>
                <td class='cart-title'>
                    <h2 >
                        <a href='prodotto.php?id=".$value['art_id']."'>".$value['titolo']."</a>
                    </h2>         
                </td>

                <td>
                    <span >

                        <span >€&nbsp;".$value['prezzo']."</span>            
                    </span>
                </td>
                <td >
                <div id='dropdown-dark'>
                      <select id='dropdown-select' name='quantity'>
                        <option selected='selected'>".$value['quantity']."</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                      </select>                    
                    </div>
                </td>
                <td>
                    <span >

                        <span >€&nbsp;".floatval($value['quantity'])*$value['prezzo']."</span>            
                    </span>


                </td>
                <td class='a-center last'><a href='include/deleteitem.php?id=".$value['art_id']."' title='Cancella articolo' class='btn-remove btn-remove2'>Cancella articolo</a></td>
            </tr>";
            
        }
        return $content;
    }

    function inserttotals($name, $data, $pars) {
        $iva=round($data*0.21, 2, PHP_ROUND_HALF_UP);
        $content.="<colgroup><col>
                    <col width='1'>
                </colgroup><tfoot>
                    <tr>
                        <td style='' colspan='1'>
                            <strong>Imponibile</strong>
                        </td>
                        <td style=''>
                            <strong><span>€&nbsp;".$data."</span></strong>
                        </td>
                    </tr>
                    <tr>
                        <td style='' colspan='1'>
                            IVA (21%)            </td>
                        <td style=''><span>€&nbsp;".$iva."</span></td>
                    </tr>
                    <tr>
                        <td style='' colspan='1'>
                            <strong>Totale</strong>
                        </td>
                        <td style=''>
                            <strong><span>€&nbsp;".($data+$iva)."</span></strong>
                        </td>
                    </tr>
                </tfoot>
                <tbody>
                    <tr>
                        <td style='' colspan='1'>
                            Totale parziale    </td>
                        <td style=''>
                            <span>€&nbsp;".$data."</span>    </td>
                    </tr>
                </tbody>";
        return $content;
    }

}
?>


<?php

Class slider extends TagLibrary {

    function insertslider($name, $data, $pars) {
        foreach ($data as $key => $value) {  
        $prezzo_int=intval($value['prezzo']);
        $prezzo_dec=intval(($value['prezzo']-floatval($prezzo_int))*100);
            if ($prezzo_dec < 10) {
                $content.="<li><img href='#' src='img/film/" . $value['immagine'] . "' alt='Slide Image' width='250' height='350' />
						<div class='slide-entry'>
							<h2>" . $value['titolo'] . "<br /></h2>
							<h6><span>Acquistalo ora nel nostro e-commerces a soli</span></h6>
                                                        <h4>" . $prezzo_int . "<sup>.0" . $prezzo_dec . " &#8364;</sup></h4> 
							<a href='prodotto.php?id=".$value['id']."' class='button' title='Buy now'><span>Buy now</span></a>
						</div>
					</li>";
            } else {
                $content.="<li><img href='#' src='img/film/" . $value['immagine'] . "' alt='Slide Image' width='250' height='350' />
						<div class='slide-entry'>
							<h2>" . $value['titolo'] . "<br /></h2>
							<h6><span>Acquistalo ora nel nostro e-commerces a soli</span></h6>
                                                        <h4>" . $prezzo_int . "<sup>." . $prezzo_dec . " &#8364;</sup></h4> 
							<a href='prodotto.php?id=".$value['id']."' class='button' title='Buy now'><span>Buy now</span></a>
						</div>
					</li>";
            }
        }
        return $content;
    }

}

?>
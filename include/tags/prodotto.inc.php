<?php

Class prodotto extends TagLibrary {

    function insertspec($name, $data, $pars) {
        $data[0]['regia'] = htmlentities($data[0]['regia']);
        $data[0]['trama'] = htmlentities($data[0]['trama']);
        $prezzo_int = intval($data[0]['prezzo']);
        $prezzo_dec = intval(($data[0]['prezzo'] - floatval($prezzo_int)) * 100);
        $content.="<div id='specifica'>
            <div class='sx'>
            <img itemprop='image' class='round-border' src='img/film/" . $data[0]['immagine'] . "' alt='Image'>
            <div class='price'>
        <div class='inner'>
            <span class='title'>Price</span>";
        if ($prezzo_dec < 10) {

            $content.="<strong><span>&#8364; </span>" . $prezzo_int . "<sup>.0" . $prezzo_dec . "</sup></strong>";
        } else {
            $content.="<strong><span>&#8364; </span>" . $prezzo_int . "<sup>." . $prezzo_dec . "</sup></strong>";
        }
        $content.="</div>
    </div></div><div class='dx'><ul>        	
                            <li class='scheda-title'><h2>" . $data[0]['titolo'] . "</h2></li>
		
                
		<li>
			<span class='scheda-label-cnt'>GENERE:</span>
			<span itemprop='genre'><h3>" . ucfirst($data[0]['genere']) . "</h3></span>
		</li>						
		<li>
			<span class='scheda-label-cnt'>NAZIONE:</span>
                        <span itemprop='nation'><h3>" . $data[0]['nazione'] . "</h3></span>
		</li>					
		<li>
			<span class='scheda-label-cnt'>DURATA:</span> 
			<span itemprop='duration'><h3>" . $data[0]['durata'] . " minuti</h3></span>
		</li>				
		<li>
			<span class='scheda-label-cnt'>ANNO DI DISTRIBUZIONE:</span>
			<span itemprop='datePublished'><h3>" . $data[0]['anno'] . "</h3></span>
                 </li> 
                 <li>
			<span class='scheda-label-cnt'>REGIA:</span>
			<span itemprop='datePublished'><h3>" . $data[0]['regia'] . "</h3></span>
                 </li> 
                 <li>
			<span class='scheda-label-cnt'>ATTORI:</span>
			<span itemprop='datePublished'><h3>" . $data[0]['attori'] . "</h3></span>
                 </li>                 
                 <div class='last-item'><span class='scheda-label-cnt'>Quantità:</span>
                 ";
        if (isset($_SESSION['login'])){
            $content.="<form  method='post' action='include/additem.php?id=" . $_GET['id'] . "'>
                    <div id='dropdown-dark'>
                      <select id='dropdown-select' name='quantity'>
                        <option selected='selected'>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                      </select>                    
                    </div><div class='t'><img src='img/cart2.png'>
                <button id='carr' title='Add to cart' onclick='alertadd()'>ADD TO CART</button></div>";        
        }
        else{
            $content.="
                <form  method='post' action='#'>
                    <div id='dropdown-dark'>
                      <select id='dropdown-select' name='quantity'>
                        <option selected='selected'>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                      </select>                    
                    </div><div class='t'><img src='img/cart2.png'><button id='carr' title='Add to cart' onclick='alertlogin()'>ADD TO CART</button></div>";
        }
                    $content.="</div>
                 </li>
                 </ul>
                 </div>
                  </div>
                 <div>
                    <span class='scheda-label-cnt'>TRAMA:</span>
			<span itemprop='datePublished'><h3>" . $data[0]['trama'] . "</h3></span>
                 </div>
        ";

        return $content;
    }

}

?>

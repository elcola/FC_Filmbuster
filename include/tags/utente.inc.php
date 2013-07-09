<?php

Class utente extends TagLibrary {

    function insertutente($name, $data, $pars) {
        $content.="<span class='profile'>Welcome, <a href='profilo_cliente.php' title='Profile Link'>".$data[0]['nome']."</a>.</span>
<span class='profile'><a href='include/logout.php' title='Logout'>logout</a></span>"; 


        return $content;
    }
    function insertcart($name, $data, $pars) {
        if($data['numero']!=0){
        $content.="<span class='shopping'>Shopping Cart (".$data['numero'].") <a href='cart.php' title='Shopping Cart'>&euro;".$data['tot']."</a></span>";
        }
        else{
            $content.="<span class='shopping'>Shopping Cart (0) <a href='cart.php' title='Shopping Cart'>&euro;0.00</a></span>";
        }
        return $content;
    }
}

?>

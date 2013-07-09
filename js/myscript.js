var mouse_is_inside = false;

$(document).ready(function() {
    $(".login_btn").click(function() {
        var loginBox = $("#login_box");
        if (loginBox.is(":visible"))
            loginBox.fadeOut("fast");
        else
            loginBox.fadeIn("fast");
        return false;
    });
    
    $("#login_box").hover(function(){ 
        mouse_is_inside=true; 
    }, function(){ 
        mouse_is_inside=false; 
    });

    $("body").click(function(){
        if(! mouse_is_inside) $("#login_box").fadeOut("fast");
    });
});


$(document).ready(function() {
    $("#submit_first").click(function(){
       if(
          ($("input[name=nomeF]").val()!=="") &&
          ($("input[name=cognomeF]").val()!=="") &&
          ($("input[name=viaF]").val()!=="") &&
          ($("input[name=comuneF]").val()!=="") &&
          ($("input[name=provinciaF]").val()!=="") &&
          ($("input[name=capF]").val()!=="") &&
          ($("input[name=paeseF]").val()!=="")
       ){
       $(".first-step").css("display","none");
       $(".second-step").css("display","block");
       }
       else
       alert("Devi compilare tutti i campi per procedere");
   });
   $("#submit_second").click(function(){
       if(
          ($("input[name=nomeS]").val()!=="") &&
          ($("input[name=cognomeS]").val()!=="") &&
          ($("input[name=viaS]").val()!=="") &&
          ($("input[name=comuneS]").val()!=="") &&
          ($("input[name=provinciaS]").val()!=="") &&
          ($("input[name=capS]").val()!=="") &&
          ($("input[name=paeseS]").val()!=="")
       ){
       $(".second-step").css("display","none");
       $(".third-step").css("display","block");
       }
       else
       alert("Devi compilare tutti i campi per procedere");
   });
   $("#submit_third").click(function(){
       if(
       ($("input[name=metodoS]").val()=="PostaOrdinaria") ||
       ($("input[name=metodoS]").val()=="CorriereEspresso") ||
       ($("input[name=metodoS]").val()=="CorriereInternazionale")
       ){
       $(".third-step").css("display","none");
       $(".fourth-step").css("display","block");
       }
       else alert("Devi inserire il metodo di spedizione per procedere");
   });
   $("#submit_fourth").click(function(){
       if(
       ($("input[name=metodoP]").val()=="selected")){
       $(".fourth-step").css("display","none");
       $(".fifth-step").css("display","block");
       }
       else alert("Devi inserire il metodo di pagamento per procedere");
   });
   
});

$(document).ready(function() {
    $("#submit_profilo").click(function(){
       $(".profilo-step").css("display","block");
       $(".anagrafica-step").css("display","none");
       $(".indirizzo-step").css("display","none");
       $(".email-step").css("display","none");
       $(".password-step").css("display","none");
	   $(".insprodotto-step").css("display","none");
	   $(".delprodotto-step").css("display","none");
	   $(".modprodotto-step").css("display","none");
	   $(".aggnews-step").css("display","none");
	   $(".delnews-step").css("display","none");
	   $(".modnews-step").css("display","none");
	   $(".insutente-step").css("display","none");
	   $(".delutente-step").css("display","none");
	   $(".modslide-step").css("display","none");
	   $(".vendite-step").css("display","none");
   });
   $("#submit_anagrafica").click(function(){
        $(".profilo-step").css("display","none");
       $(".anagrafica-step").css("display","block");
       $(".indirizzo-step").css("display","none");
       $(".email-step").css("display","none");
       $(".password-step").css("display","none");
	   $(".insprodotto-step").css("display","none");
	   $(".delprodotto-step").css("display","none");
	   $(".modprodotto-step").css("display","none");
	   $(".aggnews-step").css("display","none");
	   $(".delnews-step").css("display","none");
	   $(".modnews-step").css("display","none");
	   $(".insutente-step").css("display","none");
	   $(".delutente-step").css("display","none");
	   $(".modslide-step").css("display","none");
	   $(".vendite-step").css("display","none");
   });
   $("#submit_indirizzo").click(function(){
        $(".profilo-step").css("display","none");
       $(".anagrafica-step").css("display","none");
       $(".indirizzo-step").css("display","block");
       $(".email-step").css("display","none");
       $(".password-step").css("display","none");
	   $(".insprodotto-step").css("display","none");
	   $(".delprodotto-step").css("display","none");
	   $(".modprodotto-step").css("display","none");
	   $(".aggnews-step").css("display","none");
	   $(".delnews-step").css("display","none");
	   $(".modnews-step").css("display","none");
	   $(".insutente-step").css("display","none");
	   $(".delutente-step").css("display","none");
	   $(".modslide-step").css("display","none");
	   $(".vendite-step").css("display","none");
   });
   $("#submit_email").click(function(){
        $(".profilo-step").css("display","none");
       $(".anagrafica-step").css("display","none");
       $(".indirizzo-step").css("display","none");
       $(".email-step").css("display","block");
       $(".password-step").css("display","none");
	   $(".insprodotto-step").css("display","none");
	   $(".delprodotto-step").css("display","none");
	   $(".modprodotto-step").css("display","none");
	   $(".aggnews-step").css("display","none");
	   $(".delnews-step").css("display","none");
	   $(".modnews-step").css("display","none");
	   $(".insutente-step").css("display","none");
	   $(".delutente-step").css("display","none");
	   $(".modslide-step").css("display","none");
	   $(".vendite-step").css("display","none");
   });
   $("#submit_password").click(function(){
        $(".profilo-step").css("display","none");
       $(".anagrafica-step").css("display","none");
       $(".indirizzo-step").css("display","none");
       $(".email-step").css("display","none");
       $(".password-step").css("display","block");
	   $(".insprodotto-step").css("display","none");
	   $(".delprodotto-step").css("display","none");
	   $(".modprodotto-step").css("display","none");
	   $(".aggnews-step").css("display","none");
	   $(".delnews-step").css("display","none");
	   $(".modnews-step").css("display","none");
	   $(".insutente-step").css("display","none");
	   $(".delutente-step").css("display","none");
	   $(".modslide-step").css("display","none");
	   $(".vendite-step").css("display","none");
   });
   $("#submit_insprodotto").click(function(){
        $(".profilo-step").css("display","none");
       $(".anagrafica-step").css("display","none");
       $(".indirizzo-step").css("display","none");
       $(".email-step").css("display","none");
       $(".password-step").css("display","none");
       $(".insprodotto-step").css("display","block");	   
	   $(".delprodotto-step").css("display","none");
	   $(".modprodotto-step").css("display","none");
	   $(".aggnews-step").css("display","none");
	   $(".delnews-step").css("display","none");
	   $(".modnews-step").css("display","none");
	   $(".insutente-step").css("display","none");
	   $(".delutente-step").css("display","none");
	   $(".modslide-step").css("display","none");
	   $(".vendite-step").css("display","none");
   });
   $("#submit_delprodotto").click(function(){
        $(".profilo-step").css("display","none");
       $(".anagrafica-step").css("display","none");
       $(".indirizzo-step").css("display","none");
       $(".email-step").css("display","none");
       $(".password-step").css("display","none");
       $(".insprodotto-step").css("display","none");	   
	   $(".delprodotto-step").css("display","block");
	   $(".modprodotto-step").css("display","none");
	   $(".aggnews-step").css("display","none");
	   $(".delnews-step").css("display","none");
	   $(".modnews-step").css("display","none");
	   $(".insutente-step").css("display","none");
	   $(".delutente-step").css("display","none");
	   $(".modslide-step").css("display","none");
	   $(".vendite-step").css("display","none");
   });
   $("#submit_modprodotto").click(function(){
        $(".profilo-step").css("display","none");
       $(".anagrafica-step").css("display","none");
       $(".indirizzo-step").css("display","none");
       $(".email-step").css("display","none");
       $(".password-step").css("display","none");
	   $(".insprodotto-step").css("display","none");
	   $(".delprodotto-step").css("display","none");
	   $(".modprodotto-step").css("display","block");
	   $(".aggnews-step").css("display","none");
	   $(".delnews-step").css("display","none");
	   $(".modnews-step").css("display","none");
	   $(".insutente-step").css("display","none");
	   $(".delutente-step").css("display","none");
	   $(".modslide-step").css("display","none");
	   $(".vendite-step").css("display","none");
   });
   $("#submit_aggnews").click(function(){
        $(".profilo-step").css("display","none");
       $(".anagrafica-step").css("display","none");
       $(".indirizzo-step").css("display","none");
       $(".email-step").css("display","none");
       $(".password-step").css("display","none");
	   $(".insprodotto-step").css("display","none");
	   $(".delprodotto-step").css("display","none");
	   $(".modprodotto-step").css("display","none");
	   $(".aggnews-step").css("display","block");
	   $(".delnews-step").css("display","none");
	   $(".modnews-step").css("display","none");
	   $(".insutente-step").css("display","none");
	   $(".delutente-step").css("display","none");
	   $(".modslide-step").css("display","none");
	   $(".vendite-step").css("display","none");
   });
   $("#submit_delnews").click(function(){
        $(".profilo-step").css("display","none");
       $(".anagrafica-step").css("display","none");
       $(".indirizzo-step").css("display","none");
       $(".email-step").css("display","none");
       $(".password-step").css("display","none");
	   $(".insprodotto-step").css("display","none");
	   $(".delprodotto-step").css("display","none");
	   $(".modprodotto-step").css("display","none");
	   $(".aggnews-step").css("display","none");
	   $(".delnews-step").css("display","block");
	   $(".modnews-step").css("display","none");
	   $(".insutente-step").css("display","none");
	   $(".delutente-step").css("display","none");
	   $(".modslide-step").css("display","none");
	   $(".vendite-step").css("display","none");
   });
   $("#submit_modnews").click(function(){
        $(".profilo-step").css("display","none");
       $(".anagrafica-step").css("display","none");
       $(".indirizzo-step").css("display","none");
       $(".email-step").css("display","none");
       $(".password-step").css("display","none");
	   $(".insprodotto-step").css("display","none");
	   $(".delprodotto-step").css("display","none");
	   $(".modprodotto-step").css("display","none");
	   $(".aggnews-step").css("display","none");
	   $(".delnews-step").css("display","none");
	   $(".modnews-step").css("display","block");
	   $(".insutente-step").css("display","none");
	   $(".delutente-step").css("display","none");
	   $(".modslide-step").css("display","none");
	   $(".vendite-step").css("display","none");
   });
   $("#submit_insutente").click(function(){
        $(".profilo-step").css("display","none");
       $(".anagrafica-step").css("display","none");
       $(".indirizzo-step").css("display","none");
       $(".email-step").css("display","none");
       $(".password-step").css("display","none");
	   $(".insprodotto-step").css("display","none");
	   $(".delprodotto-step").css("display","none");
	   $(".modprodotto-step").css("display","none");
	   $(".aggnews-step").css("display","none");
	   $(".delnews-step").css("display","none");
	   $(".modnews-step").css("display","none");
	   $(".insutente-step").css("display","block");
	   $(".delutente-step").css("display","none");
	   $(".modslide-step").css("display","none");
	   $(".vendite-step").css("display","none");
   });
   $("#submit_delutente").click(function(){
        $(".profilo-step").css("display","none");
       $(".anagrafica-step").css("display","none");
       $(".indirizzo-step").css("display","none");
       $(".email-step").css("display","none");
       $(".password-step").css("display","none");
	   $(".insprodotto-step").css("display","none");
	   $(".delprodotto-step").css("display","none");
	   $(".modprodotto-step").css("display","none");
	   $(".aggnews-step").css("display","none");
	   $(".delnews-step").css("display","none");
	   $(".modnews-step").css("display","none");
	   $(".insutente-step").css("display","none");
	   $(".delutente-step").css("display","block");
	   $(".modslide-step").css("display","none");
	   $(".vendite-step").css("display","none");
   });
   $("#submit_modslide").click(function(){
        $(".profilo-step").css("display","none");
       $(".anagrafica-step").css("display","none");
       $(".indirizzo-step").css("display","none");
       $(".email-step").css("display","none");
       $(".password-step").css("display","none");
	   $(".insprodotto-step").css("display","none");
	   $(".delprodotto-step").css("display","none");
	   $(".modprodotto-step").css("display","none");
	   $(".aggnews-step").css("display","none");
	   $(".delnews-step").css("display","none");
	   $(".modnews-step").css("display","none");
	   $(".insutente-step").css("display","none");
	   $(".delutente-step").css("display","none");
	   $(".modslide-step").css("display","block");
	   $(".vendite-step").css("display","none");
   });
   $("#submit_vendite").click(function(){
        $(".profilo-step").css("display","none");
       $(".anagrafica-step").css("display","none");
       $(".indirizzo-step").css("display","none");
       $(".email-step").css("display","none");
       $(".password-step").css("display","none");
	   $(".insprodotto-step").css("display","none");
	   $(".delprodotto-step").css("display","none");
	   $(".modprodotto-step").css("display","none");
	   $(".aggnews-step").css("display","none");
	   $(".delnews-step").css("display","none");
	   $(".modnews-step").css("display","none");
	   $(".insutente-step").css("display","none");
	   $(".delutente-step").css("display","none");
	   $(".modslide-step").css("display","none");
	   $(".vendite-step").css("display","block");
   });
});
function alertadd(){
    alert("Il prodotto è stato aggiunto al carrello!");
};
function alertlogin(){
    alert("Devi essere loggato per aggiungere un prodotto al carrello!");
}
function controllanumero(nome){    
    inp=document.form1.nome.toString();
    alert(inp);
}
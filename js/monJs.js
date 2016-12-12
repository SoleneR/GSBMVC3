$(function(){
    
    /*-----------------------Page connexion----------------------------------*/
    $('#pageConnexion #btnconnexion').bind("click", function(e) {
            e.preventDefault();
            var login = $("#pageConnexion #login").val(); 
            var mdp = $("#pageConnexion #mdp").val();
            $.post("ajax/traiterConnexion.php",{
                        "login" : login,        
                        "mdp" : mdp },
                        foncRetourConnexion,"json" );
    });
    
    function foncRetourConnexion(data){
            if(data != null){
                $.mobile.changePage("#pageAgendaJour");
             }
             else{
                $("#pageConnexion #message").css({color:'red'});
                $("#pageConnexion #message").html("erreur de login et/ou mdp");
             }
    }
    
    
    
});

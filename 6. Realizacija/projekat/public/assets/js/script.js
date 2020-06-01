$(document).ready(function(){
    
    setTimeout(sakrijPoruku, 5000);
    
    function sakrijPoruku(){
        $(".poruka").html("");
    }
    
    //poziva metodu koja proverava da li je piscev staz dovoljno dugacak i ako jeste preusmerava ga na stranicu za slanje zahteva
    $("#slanje").click(function(){
        $.ajax({
            type: 'get',
            url: baseURL+"/mozeLiPoslati",
            success: function(response){
                if(response!=""){
                    $(".poruka").css("color", "red");
                    $(".poruka").html(response);
                    setTimeout(sakrijPoruku, 5000);
                }
                else{
                    window.location.href=baseURL+"/slanjeZahteva";
                }
            }
        });
    });
    
    $(".korisnik").click(korisnik);
    
    //proverava da li je kliknuti korisnik u statusu citaoca ako nije preusmerava na stranicu sa listom tekstova
    function korisnik(){
        var idkor=$(this).data('id');
        $.ajax({
            type: 'get',
            url: baseURL+"/citalac/"+idkor,
            success: function(response){
                if(response!=""){
                    $(".poruka").css("color", "red");
                    $(".poruka").html(response);
                    setTimeout(sakrijPoruku, 5000);
                }
                else{
                    window.location.href=baseURL+"/pregledTekstova/"+idkor;
                }
            }
        });
    }
    
});

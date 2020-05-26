$(document).ready(function(){
    
    setTimeout(sakrijPoruku, 5000);
    
    function sakrijPoruku(){
        $(".poruka").html("");
    }
    
    $("#slanje").click(function(){
        $.ajax({
            type: 'get',
            url: baseURL+"/mozeLiPoslati",
            success: function(response){
                if(response!=""){
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
    
    function korisnik(){
        var idkor=$(this).data('id');
        $.ajax({
            type: 'get',
            url: baseURL+"/citalac/"+idkor,
            success: function(response){
                if(response!=""){
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

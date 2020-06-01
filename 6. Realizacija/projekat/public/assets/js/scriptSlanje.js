$(document).ready(function(){
    
    setTimeout(sakrijPoruku, 5000);
    
    function sakrijPoruku(){
        $(".poruka").html("");
    }
    
    $("#posalji").click(slanje);
    
    $(document).on('keypress', function(e){
        if(e.which==13){
            slanje();
        }
    });
    
    //poziva php metodu za pravljenje novog zahteva
    function slanje(){
        var oblast=$("#oblast").val();
        $.ajax({
            type: 'get',
            url: baseURL+"/noviZahtev",
            data:{
                oblast:oblast
            },
            success: function(response){
                if(response=="Poslat je zahtev"){
                    $(".poruka").css("color", "white");
                }
                else{
                    $(".poruka").css("color", "red");
                }
                $(".poruka").html(response);
                setTimeout(sakrijPoruku, 5000);
            }
        });
    }
    
});



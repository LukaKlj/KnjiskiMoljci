$(document).ready(function(){
    
    setTimeout(sakrijPoruku, 5000);
    
    function sakrijPoruku(){
        $(".poruka").html("");
    }
    
    $("#posalji").click(function(){
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
    });
    
});



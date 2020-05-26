$(document).ready(function(){
    
    setTimeout(sakrijPoruku, 5000);
    
    function sakrijPoruku(){
        $(".poruka").html("");
    }
    
    $(".odobri").click(odobri);
    
    function odobri(){
        var index=$(this).data("index");
        var parametar=parametri[index];
        $.ajax({
            type: 'get',
            url: baseURL+"/odobri/"+parametar,
            success:function(){
                proveriTekstove();
            }
        });
    }
    
    $(".odbaci").click(odbaci);
    
    function odbaci(){
        var index=$(this).data("index");
        var parametar=parametri[index];
        $.ajax({
            type: 'get',
            url: baseURL+"/odbaci/"+parametar,
            success:function(){
                proveriTekstove();
            },
            error: function(response){
                alert(response);
                console.log(response);
            }
        });
    }
    
    function proveriTekstove(){
        $.ajax({
            type: 'get',
            url: baseURL+"/osveziTekstove",
            success: function(response){
                $("#telo").html(response);
                $(".odobri").click(odobri);
                $(".odbaci").click(odbaci);
                $(".korisnik").click(korisnik);
            }
        });
    };
    
    setInterval(proveriTekstove, 5000);
    
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



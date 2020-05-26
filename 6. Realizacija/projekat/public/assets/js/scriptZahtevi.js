$(document).ready(function(){
    
    setTimeout(sakrijPoruku, 5000);
    
    function sakrijPoruku(){
        $(".poruka").html("");
    }
    
    $(".vrati").click(vrati);
    
    function vrati(){
        var index=$(this).data("index");
        var parametar2=parametri2[index];
        $.ajax({
            type: 'get',
            url: baseURL+"/vrati/"+parametar1+"/"+parametar2,
            success:function(){
                proveriZahteve();
            }
        });
    }
    
    $(".odobri").click(odobri);
    
    function odobri(){
        var index=$(this).data("index");
        var parametar2=parametri2[index];
        $.ajax({
            type: 'get',
            url: baseURL+"/odobri/"+parametar1+"/"+parametar2,
            success:function(response){
                $(".poruka").css("color", "white");
                $(".poruka").html(response);
                setTimeout(sakrijPoruku, 5000);
                proveriZahteve();
            }
        });
    }
    
    $(".odbaci").click(odbaci);
    
    function odbaci(){
        var index=$(this).data("index");
        var parametar2=parametri2[index];
        $.ajax({
            type: 'get',
            url: baseURL+"/odbaci/"+parametar1+"/"+parametar2,
            success:function(){
                proveriZahteve();
            }
        });
    }
    
    function proveriZahteve(){
        $.ajax({
            type: 'get',
            url: baseURL+"/osveziZahteve/"+parametar1,
            success: function(response){
                $("#telo").html(response);
                $(".vrati").click(vrati);
                $(".odobri").click(odobri);
                $(".odbaci").click(odbaci);
            }
        });
    };
    
    setInterval(proveriZahteve, 5000);
});

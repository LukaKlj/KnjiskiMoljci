$(document).ready(function(){
    
    setTimeout(sakrijPoruku, 5000);
    
    function sakrijPoruku(){
        $(".poruka").html("");
    }
    
    $(".vrati").click(vrati);
    
    //poziv aphp metodu za vracanje recenzenta u status pisca
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
    
    //poziva php metodu za odobravanje zahteva za unapredjenje u status recenzenta
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
    
    //poziva php metodu za odbacivanje zahteva za unapredjenje u status recenzenta
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
    
    //poziva php metodu za osvezavanje zahteva za unapredjenje u status recenzenta
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

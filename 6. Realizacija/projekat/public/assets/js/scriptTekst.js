$(document).ready(function(){
    setTimeout(sakrijPoruku, 5000);
    
    function sakrijPoruku(){
        $(".poruka").html("");
    }
    
    $("#potvrdiOcenu").click(function(){
        var ocena=$("#ocena").val();
        $.ajax({
            type: "get",
            url: baseURL+"/oceni/"+parametar,
            data:{
                ocena: ocena
            },
            success:function(response){
                $(".poruka").css("color", "white");
                $(".poruka").html(response);
                setTimeout(sakrijPoruku, 5000);
            }
        });   
    });
    
    $("#komentarisi").click(function(){
        var komentar=$("#kom").val();
        $.ajax({
            type: "get",
            url: baseURL+"/komentarisi/"+parametar,
            data:{
                komentar: komentar
            },
            success: function(){
                $("#kom").val("");
                proveriKomentare();
            }
        });   
    });
    
    function proveriKomentare(){
        $.ajax({
            type: "get",
            url: baseURL+"/osveziKomentare/"+parametar,
            success: function(response){
                $("#telo").html(response);
                $(".korisnik").click(korisnik);
            }
        });
    }
    
    setInterval(proveriKomentare, 5000);
    
    $(window).on('beforeunload', function(){
        var strana=$("#strana").val();
        $.ajax({
            type: 'get',
            url: baseURL+"/zapamtiStranu/"+parametar,
            data: {
                strana: strana
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
    
    
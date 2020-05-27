$(document).ready(function(){
    
    setTimeout(sakrijPoruku, 5000);
    
    function sakrijPoruku(){
        $(".poruka").html("");
    }
    
    $(document).on('keypress', function(e){
        if(e.which==13){
            promeniLozinku();
        }
    });
    
    $("#promeni").click(promeniLozinku);
    
    function promeniLozinku(){
        var stara=$("#stara").val();
        var staraPonovo=$("#staraPonovo").val();
        var nova=$("#nova").val();
        $.ajax({
            type: 'post',
            url: baseURL+"/novaLozinka",
            data: {
                stara: stara,
                staraPonovo: staraPonovo,
                nova: nova
            },
            success: function(response){
                $("#stara").val("");
                $("#staraPonovo").val("");
                $("#nova").val("");
                if(response=="Uspešno promenjena lozinka") $(".poruka").css("color", "white");
                else $(".poruka").css("color", "red");
                $(".poruka").html(response);
                setTimeout(sakrijPoruku, 5000);
            }
        });
    }
});
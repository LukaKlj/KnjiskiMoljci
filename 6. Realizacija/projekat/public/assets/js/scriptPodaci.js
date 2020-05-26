$(document).ready(function(){
    
    setTimeout(sakrijPoruku, 5000);
    
    function sakrijPoruku(){
        $(".poruka").html("");
    }
    
    $("#sacuvaj").click(function(){
        var ime=$("#ime").val();
        var prezime=$("#prezime").val();
        var email=$("#email").val();
        var CreditCards=$("#CreditCards").val();
        var broj=$("#broj").val();
        var mesec=$("#mesec").val();
        var godina=$("#godina").val();
        var cvv=$("#cvv").val();
        $.ajax({
            type: 'post',
            url: baseURL+"/noviPodaci",
            data: {
                ime: ime,
                prezime: prezime,
                email: email,
                CreditCards: CreditCards,
                broj: broj,
                mesec: mesec,
                godina: godina,
                cvv: cvv
            },
            success: function(response){
                if(response=="Uspešno promenjeni podaci") $(".poruka").css("color", "white");
                else $(".poruka").css("color", "red");
                $(".poruka").html(response);
                setTimeout(sakrijPoruku, 5000);
            }
        });
    });
    
});
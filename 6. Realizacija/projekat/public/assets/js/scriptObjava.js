$(document).ready(function(){
    
    setTimeout(sakrijPoruku, 5000);
    
    function sakrijPoruku(){
        $(".poruka").html("");
    }
    
    $("form").submit(function(evt){	 
        evt.preventDefault();
        var formData = new FormData($(this)[0]);
        $.ajax({
            url: baseURL+"/noviTekst",
            type: 'POST',
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            enctype: 'multipart/form-data',
            processData: false,
            dataType: 'json',
            success: function (response) {
                if(response.boja == "bela"){
                    $(".poruka").css("color", "white");
                }
                else{
                    $(".poruka").css("color", "red");
                }
                $(".poruka").html(response.poruka);
                setTimeout(sakrijPoruku, 5000);
            }
        });
        return false;
    });
    
});




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
                $(".poruka").html(response.poruka);
                setTimeout(sakrijPoruku, 5000);
            }
        });
        return false;
    });
    
});


        //action="<?php echo site_url($controller."/noviTekst")?>" method="post" enctype="multipart/form-data"



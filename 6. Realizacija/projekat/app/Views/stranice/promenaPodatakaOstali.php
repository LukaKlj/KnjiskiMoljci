<script src="<?php echo site_url("/assets/js/scriptPodaci.js"); ?>"></script> 
<div class="container-fluid back">
    <div class="row">
        <div class="col-sm-12 text-center naslov">
            <h2>Promena ličnih podataka</h2>
        </div>
    </div>
    <div class="row">
        <div class="offset-sm-4 col-sm-4 text-center">
            <span class="poruka" style="color:red">
                <?php if(isset($poruka)) echo $poruka;?>
            </span>
        </div>
    </div>
    <div class="row">
        <div class="offset-sm-4 col-sm-4">
            <div class="table-responsive smallerfont text-center">->
                <table class="table table-sm userpass">
                    <tr>
                        <td>Ime:</td>
                        <td><input type='text' id="ime" name="ime" value="<?php echo set_value("ime", $korisnik->Ime)?>"></td>
                    </tr>
                    <tr>
                        <td>Prezime:</td>
                        <td><input type='text' id="prezime" name="prezime" value="<?php echo set_value("prezime", $korisnik->Prezime)?>"></td>
                    </tr>
                    <tr>
                        <td>e-mail:</td>
                        <td><input type='email' id="email" name="email" value="<?php echo set_value("email", $korisnik->email)?>"></td>
                    </tr>
                    <tr class="text-center">
                        <td colspan="2"><button type="button" id="sacuvaj" class="btn btn-danger btn-sm">Sacuvaj</button></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
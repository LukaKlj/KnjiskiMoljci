<script src="<?php echo site_url("/assets/js/scriptLozinka.js"); ?>"></script> 
<div class="container-fluid back">
    <div class="row">
        <div class="col-sm-12 text-center naslov">
            <h2>Promena lozinke</h2>
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
            <div class="table-responsive smallerfont text-center">
                <table class="table table-sm userpass">
                    <tr>
                        <td>Stara lozinka</td>
                        <td><input name="stara" id="stara" type="password"></td>
                    </tr>
                    <tr>
                        <td>Potvrda stare lozinke</td>
                        <td><input name="staraPonovo" id="staraPonovo" type="password"></td>
                    </tr>
                    <tr>
                        <td>Nova lozinka</td>
                        <td><input name="nova" id="nova" type="password"></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center">
                            <button type="submit" id="promeni" class="btn btn-sm btn-danger">Promeni</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
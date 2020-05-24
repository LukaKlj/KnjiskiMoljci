<div class="container-fluid back">
    <div class="row">
        <div class="col-sm-12 text-center naslov">
            <h2>Promena lozinke</h2>
        </div>
    </div>
    <div class="row">
        <div class="offset-sm-4 col-sm-4 text-center">
            <span class="poruka" style="<?php if($boja=='bela') echo "color:white"; else echo "color:red";?>">
                <?php if(isset($poruka)) echo $poruka;?>
            </span>
        </div>
    </div>
    <div class="row">
        <div class="offset-sm-4 col-sm-4">
            <div class="table-responsive smallerfont text-center">
                <form action="<?php echo site_url($controller."/novaLozinka")?>" method="post">
                    <table class="table table-sm userpass">
                        <tr>
                            <td>Stara lozinka</td>
                            <td><input name="stara" type="password"></td>
                        </tr>
                        <tr>
                            <td>Potvrda stare lozinke</td>
                            <td><input name="staraPonovo" type="password"></td>
                        </tr>
                        <tr>
                            <td>Nova lozinka</td>
                            <td><input name="nova" type="password"></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-center">
                                <button type="submit" class="btn btn-sm btn-danger">Promeni</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
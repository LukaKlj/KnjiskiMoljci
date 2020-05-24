<div class="container-fluid back">
    <div class="row">
        <div class="col-sm-12 bigpadding">
            &nbsp;
        </div>
    </div>
    <div class="row">
        <div class="offset-sm-4 col-sm-4 text-center">
            <h1 class="userpass">
                Prijava
            </h1>
            <?php if (isset($poruka)) echo "<font color='white'><b>$poruka</b></font><br>"; ?>
            <form id="loginform" action="<?= site_url("Gost/prijava") ?>" method="post">
                <table class="table userpass">
                    <tr>
                        <td>Korisničko ime</td>
                        <td>
                            <input type='text' name="korime"  value="<?= set_value('korime') ?>">
                        </td>
                        
                    </tr>
                    <tr>
                        <td>Lozinka</td>
                        <td>
                            <input type="password" name="sifra">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class='text-center'>
                            <button class='btn-danger' form="loginform" type="submit">Prijavi se</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
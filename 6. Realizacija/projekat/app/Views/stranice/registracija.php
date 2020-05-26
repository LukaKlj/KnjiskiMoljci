<div class="container-fluid back">
    <div class="row">
        <div class="col-sm-12 text-center">
            <h1 class="userpass">Registracija</h1>
            <span class="poruka text-center" style="color:red">
                <?php if(isset($poruka)) echo $poruka;?>
            </span>
        </div>
    </div>
    <form id="regform" action="<?= site_url($controller."/registracija") ?>" method="post">
        <div class="row">
            <div class="offset-sm-2 col-sm-4 text-center">
                <p class="userpass">
                    Unesite lične podatke
                </p>
                <div class="tsble-responsive smallerfont">
                    <table class='table userpass'>
                        <tr>
                            <td>Ime:</td>
                            <td><input type='text' name="ime"  value="<?= set_value('ime') ?>"></td>
                        </tr>
                        <tr>
                            <td>Prezime:</td>
                            <td><input type='text' name="prezime"  value="<?= set_value('prezime') ?>"></td>
                        </tr>
                        <tr>
                            <td>Korisnicko Ime:</td>
                            <td><input type='text' name="username"  value="<?= set_value('username') ?>"></td>
                        </tr>
                        <tr>
                            <td>Lozinka:</td>
                            <td><input type='password' name="password"></td>
                        </tr>
                        <tr>
                            <td>Potvrda lozinke:</td>
                            <td><input type='password' name='confirmpass'></td>
                        </tr>
                        <tr>
                            <td>e-mail:</td>
                            <td><input type='email' name="email"  value="<?= set_value('email') ?>"></td>
                        </tr>
                        <tr>
                            <td>Datum rođenja:</td>
                            <td><input type='date' name="date"  value="<?= set_value('date') ?>"></td>
                        </tr>
                        <tr>
                            <td>Pol:</td>
                            <td>
                                <input type='radio' name='pol' value='m' <?php echo set_radio('pol', 'm', true); ?> />Muski
                                <input type='radio' name='pol' value='z' <?php echo set_radio('pol', 'z'); ?> />Zenski
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-sm-4 text-center">
                <p class="userpass">
                    Unesite podatke za plaćanje
                </p>
                <div class="table-responsive smallerfont">
                    <table class="table teble-sm userpass">
                        <tr>
                            <td>Izaberi karticu:</td>
                            <td>
                                <select name="CreditCards" id="creditcards">
                                    <option value="visa" <?php echo set_select("CreditCards", "visa", TRUE);?>>Visa</option>
                                    <option value="mastercard" <?php echo set_select("CreditCards", "mastercard");?>>MasterCard</option>
                                    <option value="amex" <?php echo set_select("CreditCards", "amex");?>>American Express</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Broj kreditne kartice:</td>
                            <td>
                                <input type="tel" name='brojKartice' value="<?= set_value('brojKartice') ?>" inputmode="numeric" pattern="[0-9\s]{13,19}" autocomplete="cc-number" maxlength="19" placeholder="xxxx xxxx xxxx xxxx">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Datum isteka kartice:</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="month">
                                    <select name="mesec">
                                        <option value="1" <?php echo set_select("mesec", "1", TRUE);?>>Januar</option>
                                        <option value="2" <?php echo set_select("mesec", "2");?>>Februar</option>
                                        <option value="3" <?php echo set_select("mesec", "3");?>>Mart</option>
                                        <option value="4" <?php echo set_select("mesec", "4");?>>April</option>
                                        <option value="5" <?php echo set_select("mesec", "5");?>>Maj</option>
                                        <option value="6" <?php echo set_select("mesec", "6");?>>Jun</option>
                                        <option value="7" <?php echo set_select("mesec", "7");?>>Jul</option>
                                        <option value="8" <?php echo set_select("mesec", "8");?>>Avgust</option>
                                        <option value="9" <?php echo set_select("mesec", "9");?>>Septembar</option>
                                        <option value="10" <?php echo set_select("mesec", "10");?>>Oktobar</option>
                                        <option value="11" <?php echo set_select("mesec", "11");?>>Novembar</option>
                                        <option value="12" <?php echo set_select("mesec", "12");?>>Decembar</option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="year">
                                    <select name="godina">
                                        <?php
                                            for($i=0; $i<9; $i++){
                                                echo "<option value='{$godina}'".set_select('godina', "$godina").">{$godina}</option>";
                                                $godina++;
                                            }
                                        ?>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">CVV kod:</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="cvv-input">
                                    <input type="password" name='cvv' placeholder="CVV" maxlength="4" <?php set_value('cvv');?> />
                                </div>
                            </td>
                            <td>
                                <div class="cvv-details">
                                    <p>3 ili 4 cifre, najčešće <br> se nalaze kod potpisa</p>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 text-center">
                <button class='btn btn-sm btn-danger' form="regform" type="submit">Registruj se</button>
            </div>
        </div>
    </form>
</div>
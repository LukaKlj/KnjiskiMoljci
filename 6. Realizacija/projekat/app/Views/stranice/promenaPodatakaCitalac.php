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
            <div class="table-responsive smallerfont text-center">
                <table class="table table-sm userpass">
                    <tr>
                        <td>Ime:</td>
                        <td><input type='text' id='ime' name="ime" value="<?php echo set_value("ime", $korisnik->Ime)?>"></td>
                    </tr>
                    <tr>
                        <td>Prezime:</td>
                        <td><input type='text' id='prezime' name="prezime" value="<?php echo set_value("prezime", $korisnik->Prezime)?>"></td>
                    </tr>
                    <tr>
                        <td>e-mail:</td>
                        <td><input type='email' id='email' name="email" value="<?php echo set_value("email", $korisnik->email)?>"></td>
                    </tr>
                    <tr>
                        <td>Izaberi karticu:</td>
                        <td>
                            <select name="CreditCards" id="CreditCards">
                                <option value="visa" <?php if($citalac->VrstaKartice=='visa')echo set_select("CreditCards", "visa", TRUE);
                                        else echo set_select("CreditCards", "visa");?>>Visa</option>
                                <option value="mastercard" <?php if($citalac->VrstaKartice=='mastercard')echo set_select("CreditCards", "mastercard", TRUE);
                                        else echo set_select("CreditCards", "mastercard");?>>MasterCard</option>
                                <option value="amex" <?php if($citalac->VrstaKartice=='amex')echo set_select("CreditCards", "amex", TRUE);
                                        else echo set_select("CreditCards", "amex");?>>American Express</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Broj kreditne kartice:</td>
                        <td>
                            <input value="<?php echo set_value("broj", $citalac->BrojKartice)?>" id="broj" name="broj" type="text" inputmode="numeric" pattern="[0-9\s]{13,19}" autocomplete="cc-number" maxlength="19" placeholder="xxxx xxxx xxxx xxxx">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Datum isteka kartice:</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="month">
                                <select name="mesec" id="mesec">
                                    <option value="1" <?php if($citalac->MesecIsteka==1) echo set_select("mesec", "1", TRUE);
                                            else echo set_select("mesec", "1");?>>Januar</option>
                                    <option value="2" <?php if($citalac->MesecIsteka==2) echo set_select("mesec", "2", TRUE);
                                            else echo set_select("mesec", "2");?>>Februar</option>
                                    <option value="3" <?php if($citalac->MesecIsteka==3) echo set_select("mesec", "3", TRUE);
                                            else echo set_select("mesec", "3");?>>Mart</option>
                                    <option value="4" <?php if($citalac->MesecIsteka==4) echo set_select("mesec", "4", TRUE);
                                            else echo set_select("mesec", "4");?>>April</option>
                                    <option value="5" <?php if($citalac->MesecIsteka==5) echo set_select("mesec", "5", TRUE);
                                            else echo set_select("mesec", "5");?>>Maj</option>
                                    <option value="6" <?php if($citalac->MesecIsteka==6) echo set_select("mesec", "6", TRUE);
                                            else echo set_select("mesec", "6");?>>Jun</option>
                                    <option value="7" <?php if($citalac->MesecIsteka==7) echo set_select("mesec", "7", TRUE);
                                            else echo set_select("mesec", "7");?>>Jul</option>
                                    <option value="8" <?php if($citalac->MesecIsteka==8) echo set_select("mesec", "8", TRUE);
                                            else echo set_select("mesec", "8");?>>Avgust</option>
                                    <option value="9" <?php if($citalac->MesecIsteka==9) echo set_select("mesec", "9", TRUE);
                                            else echo set_select("mesec", "9");?>>Septembar</option>
                                    <option value="10" <?php if($citalac->MesecIsteka==10) echo set_select("mesec", "10", TRUE);
                                            else echo set_select("mesec", "10");?>>Oktobar</option>
                                    <option value="11" <?php if($citalac->MesecIsteka==11) echo set_select("mesec", "11", TRUE);
                                            else echo set_select("mesec", "11");?>>Novembar</option>
                                    <option value="12" <?php if($citalac->MesecIsteka==12) echo set_select("mesec", "12", TRUE);
                                            else echo set_select("mesec", "12");?>>Decembar</option>
                                </select>
                            </div>
                        </td>
                        <td>
                            <div class="year">
                                <select name="godina" id="godina">
                                    <?php
                                        for($i=0; $i<9; $i++){
                                            if($citalac->GodinaIsteka==$godina){
                                                echo "<option value='{$godina}'".set_select('godina', "$godina", TRUE).">{$godina}</option>";
                                            }
                                            else{
                                                echo "<option value='{$godina}'".set_select('godina', "$godina").">{$godina}</option>";
                                            }
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
                                <input value="<?php echo set_value("cvv", $citalac->CVV)?>" name="cvv" id="cvv" type="password" inputmode="numeric" placeholder="CVV" maxlength="4">
                            </div>
                        </td>
                        <td>
                            <div class="cvv-details">
                                <p>3 ili 4 cifre, najčešće <br> se nalaze kod potpisa</p>
                            </div>
                        </td>
                    </tr>
                    <tr class="text-center">
                        <td colspan="2"><button type="button" id="sacuvaj" class="btn btn-danger btn-sm">Sacuvaj</button></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
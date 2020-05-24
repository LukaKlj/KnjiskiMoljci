<div class="container-fluid back">
    <div class="row">
        <div class="col-sm-12 text-center">
            <h1 class="userpass">Registracija</h1>
        </div>
    </div>
    <form id="regform" action="<?= site_url("Gost/Registracija") ?>" method="post">
        <div class="row">

            <div class="offset-sm-2 col-sm-4 text-center">
                <p class="userpass">
                    Unesite lične podatke
                </p>

                <table class='table userpass'>
                    <tr>
                        <td>
                            Ime:
                        </td>
                        <td>
                            <input type='text' name="ime"  value="<?= set_value('ime') ?>">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Prezime:
                        </td>
                        <td>
                            <input type='text' name="prezime"  value="<?= set_value('prezime') ?>">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Korisnicko Ime:
                        </td>
                        <td>
                            <input type='text' name="username"  value="<?= set_value('username') ?>">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Lozinka:
                        </td>
                        <td>
                            <input type='password' name="password">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Potvrda lozinke:
                        </td>
                        <td>
                            <input type='password' name='confirmpass'>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            e-mail:
                        </td>
                        <td>
                            <input type='email' name="email"  value="<?= set_value('email') ?>">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Datum rođenja:
                        </td>
                        <td>
                            <input type='date' name="date"  value="<?= set_value('date') ?>">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Pol:
                        </td>
                        <td>
                            <input type='radio' name='pol' value='m'>Muski
                            <input type='radio' name='pol' value="z">Zenski
                        </td>
                    </tr>
                </table>

            </div>
            <div class="col-sm-4 text-center">

                <p class="userpass">
                    Unesite podatke za plaćanje
                </p>
                <table class="table userpass">
                    <tr>
                        <td>
                            Izaberi karticu:
                        </td>
                        <td>
                            <select name="tipKartice" value="<?= set_value('tipKartice') ?> id="creditcards">
                                <option value="visa">Visa</option>
                                <option value="mastercard">MasterCard</option>
                                <option value="americanexpress">American Express</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Broj kreditne kartice:
                        </td>
                        <td>
                            <input type="tel" name='brojKartice' value="<?= set_value('brojKartice') ?>" inputmode="numeric" pattern="[0-9\s]{13,19}" autocomplete="cc-number" maxlength="19" placeholder="xxxx xxxx xxxx xxxx">
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            Datum isteka kartice:
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="month">
                                <select name="mesec">
                                    <option value="januar">Januar</option>
                                    <option value="februar">Februar</option>
                                    <option value="mart">Mart</option>
                                    <option value="april">April</option>
                                    <option value="maj">Maj</option>
                                    <option value="jun">Jun</option>
                                    <option value="jul">Jul</option>
                                    <option value="avgust">Avgust</option>
                                    <option value="septembar">Septembar</option>
                                    <option value="octobar">Octobar</option>
                                    <option value="novembar">Novembar</option>
                                    <option value="decembar">Decembar</option>
                                </select>
                            </div>
                        </td>
                        <td>
                            <div class="year">
                                <select name="godina">
                                    <option value="2020">2020</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                    <option value="2027">2027</option>
                                    <option value="2028">2028</option>
                                </select>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            CVV kod:
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="cvv-input">
                                <input type="password" name='cvv' placeholder="CVV" maxlength="4">
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
        <div class="row">
            <div class="col-sm-12 text-center">
                <button class='btn-danger'  form="regform" type="submit">Registruj se</button>
            </div>
        </div>
    </form>
</div>
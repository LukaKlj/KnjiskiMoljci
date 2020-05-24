<div class="container-fluid back">
    <div class="row">
        <div class="offset-sm-4 col-sm-4">
            <div class="table-responsive smallerfont text-center">
                <form action="" method="post">
                    <table class="table userpass">
                        <tr>
                            <td>Ime:</td>
                            <td><input type='text' name="ime"> </td>
                        </tr>
                        <tr>
                            <td>Prezime:</td>
                            <td><input type='text' name="prezime"></td>
                        </tr>
                        <tr>
                            <td>e-mail:</td>
                            <td><input type='email' name="email"></td>
                        </tr>
                        <tr>
                            <td>Izaberi karticu:</td>
                            <td>
                                <select name="CreditCards" id="creditcards">
                                    <option value="visa">Visa</option>
                                    <option value="mastercard">MasterCard</option>
                                    <option value="americanexpress">American Express</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Broj kreditne kartice:</td>
                            <td>
                                <input name="broj" type="tel" inputmode="numeric" pattern="[0-9\s]{13,19}" autocomplete="cc-number" maxlength="19" placeholder="xxxx xxxx xxxx xxxx">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Datum isteka kartice:</td>
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
                                      <option value="oktobar">Oktobar</option>
                                      <option value="novembar">Novembar</option>
                                      <option value="decembar">Decembar</option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="godina">
                                    <select name="Year">
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
                            <td colspan="2">CVV kod:</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="cvv-input">
                                    <input name="cvv" type="password" inputmode="numeric" placeholder="CVV" maxlength="4">
                                </div>
                            </td>
                            <td>
                                <div class="cvv-details">
                                    <p>3 ili 4 cifre, najčešće <br> se nalaze kod potpisa</p>
                                </div>
                            </td>
                        </tr>
                        <tr class="text-center">
                            <td colspan="2"><button type="submit" class="btn-danger">Sacuvaj</button></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
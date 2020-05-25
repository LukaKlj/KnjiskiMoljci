<div class="container-fluid writerBack">
    <div class="row">
        <div class="offset-sm-4 col-sm-4 text-center">
            <h2 class="newText text-center">
                Objavljivanje teksta
            </h2>
        </div>
    </div>
    <div class="row">
        <div class="offset-sm-4 col-sm-4 text-center">
            <span class="poruka" style="<?php if($boja=="crvena") echo "color:red"; else echo "color:white";?>">
                <?php if(isset($poruka)) echo $poruka;?>
            </span>
        </div>
    </div>
    <div class="row">
        <div class="offset-sm-4 col-sm-4 text-center">
            <form action="<?php echo site_url($controller."/noviTekst")?>" method="post" enctype="multipart/form-data">
                <div class="table-responsive">
                    <table class="table table-sm newText">
                        <tr>
                            <td>Naslov</td>
                            <td>
                                <input type='text' name="naslov" value="<?php echo set_value("naslov")?>">
                            </td>
                        </tr>
                        <tr>
                            <td>Kategorija</td>
                            <td>
                                <select name="oblast">
                                    <?php
                                    foreach($oblasti as $oblast){
                                        echo "<option value='$oblast->IdObl'".set_select("oblast", "{$oblast->IdObl}").">$oblast->Naziv</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="myfile">Izaberite tekst</label>
                            </td>
                            <td>
                                <input type="file" name="myfile">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-center">
                                <button type="submit" class="btn btn-sm btn-success">Objavi</button>
                            </td>
                        </tr>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>>
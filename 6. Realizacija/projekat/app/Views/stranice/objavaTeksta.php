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
            <span style="color:red">
                <?php if(isset($poruka)) echo $poruka;?>
            </span>
        </div>
    </div>
    <div class="row">
        <div class="offset-sm-4 col-sm-4 text-center">
            <form action="<?php echo site_url($controller."/noviTekst")?>" method="post" enctype="multipart/form-data">
                <table class="table table-sm newText">
                    <tr>
                        <td>Naslov</td>
                        <td>
                            <input type='text' name="naslov">
                        </td>
                    </tr>
                    <tr>
                        <td>Kategorija</td>
                        <td>
                            <select name="oblast">
                                <?php
                                foreach($oblasti as $oblast){
                                    echo "<option value='$oblast->IdObl'>$oblast->Naziv</option>";
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
                            <input type="submit" class="btn-success" value="Objavi"/>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>>
<div class="container-fluid">
    <div class="row">
        <div class='col-sm-3 text-center userpass'>
            <h4>
                <?php echo "<a href='".site_url($controller."/pregledTekstova/{$autorTeksta->IdKor}")."'>{$autorTeksta->username}</a>" ?>
                : <?php echo $tekst->Naziv?>
            </h4>
        </div>
        <div class='col-sm-9 text-center userpass'>
            <span>Ovde upišite broj strane do koje ste stigli i to će biti sačuvano</span>
            <input type="number" id="strana" name="strana" style="width: 5%" value='<?php echo set_value("strana", $strana)?>'>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="embed-responsive embed-responsive-4by3">
                <iframe class="embed-responsive-item" src="<?php echo site_url("../texts/{$tekst->Tekst}");?>" style="border: none"></iframe>
            </div>
        </div>
    </div>
    <script>
        var parametar="<?php echo $tekst->IdTeksta;?>";
    </script>
    <script src="<?php echo site_url("/assets/js/scriptTekst.js"); ?>"></script> 
    <div class="row">
        <div class="col-sm-4 text-center">
            <span class="poruka" style="color:red">
                <?php if(isset($poruka)) echo $poruka;?>
            </span>
        </div>
        <div class="col-sm-4 text-center userpass">
            Oceni delo:&nbsp;
            <select name="ocena" id="ocena">
                <option value="bez" <?php if($ocena==null) echo set_select("ocena", "bez", true);
                                            else echo set_select("ocena", "bez");?>>Neocenjeno</option>
                <option value="0" <?php if($ocena!=null && $ocena->Ocena=="0") echo set_select("ocena", "0", true);
                                            else echo set_select("ocena", "0");?>>0</option>
                <option value="1" <?php if($ocena!=null && $ocena->Ocena=="1") echo set_select("ocena", "1", true);
                                            else echo set_select("ocena", "1");?>>1</option>
                <option value="2" <?php if($ocena!=null && $ocena->Ocena=="2") echo set_select("ocena", "2", true);
                                            else echo set_select("ocena", "2");?>>2</option>
                <option value="3" <?php if($ocena!=null && $ocena->Ocena=="3") echo set_select("ocena", "3", true);
                                            else echo set_select("ocena", "3");?>>3</option>
                <option value="4" <?php if($ocena!=null && $ocena->Ocena=="4") echo set_select("ocena", "4", true);
                                            else echo set_select("ocena", "4");?>>4</option>
                <option value="5" <?php if($ocena!=null && $ocena->Ocena=="5") echo set_select("ocena", "5", true);
                                            else echo set_select("ocena", "5");?>>5</option>
            </select>
            <button type="button" id="potvrdiOcenu" class="btn btn-sm btn-success">Potvrdi ocenu</button>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 userpass">
            <h3 class="bigpadding3">Komentari:</h3>
            <div class="table-responsive">
                <table class="table table-sm userpass">
                    <thead>
                        <th>Autor</th>
                        <th>Komentar</th>
                        <th>Vreme</th>
                    </thead>
                    <tbody id="telo">
                        <?php
                            foreach ($komentari as $komentar){
                                echo "<tr>
                                    <td><a class='pointer-link korisnik' data-id='{$korisnici[$komentar->IdKom]->IdKor}'>{$korisnici[$komentar->IdKom]->username}</a></td>
                                    <td>{$komentar->Tekst}</td>
                                    <td>{$komentar->Datum} {$komentar->Vreme}</td>
                                </tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 userpass">
            <h2>Ostavi komentar:</h2>
            <textarea name="komentar" id="kom" cols="100" rows="3" <?php echo set_value("komentar")?>></textarea>
            <button type="button" id="komentarisi" class="btn btn-sm btn-success">Komentariši</button>
        </div>
    </div>
</div>
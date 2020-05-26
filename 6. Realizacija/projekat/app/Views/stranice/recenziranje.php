<script>
    var parametri=[];
</script>
<script src="<?php echo site_url("/assets/js/scriptRecenziranje.js"); ?>"></script> 
<div class="container-fluid back">
    <div class="row">
        <div class="col-sm-12 naslov text-center">
            <h2>Recenziraj</h2>
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
        <div class="col-sm-12">
            <div class="table-responsive smallerfont">
                <table class="table table-sm userpass">
                    <thead>
                        <th>Naziv</th>
                        <th>Autor</th>
                        <th>Oblast</th>
                        <th>Vreme</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </thead>
                    <tbody id="telo">
                    <?php
                    $i=0;
                    foreach($tekstovi as $tekst){
                        echo "<script>parametri[{$i}]={$tekst->IdTeksta};</script>";
                        echo "
                        <tr>
                            <td><a href='../texts/$tekst->Tekst'>$tekst->Naziv</a></td>
                            <td><a class='pointer-link korisnik' data-id='{$korisnici[$tekst->IdTeksta]->IdKor}'>{$korisnici[$tekst->IdTeksta]->username}</a></td>
                            <td>{$oblasti[$tekst->IdTeksta]->Naziv}</td>
                            <td>{$tekst->Datum} {$tekst->Vreme}</td>
                            <td><button type='button' class='btn btn-sm btn-success odobri' data-index={$i}>Odobri</button></td>
                            <td><button type='button' class='btn btn-sm btn-danger odbaci' data-index={$i}>Odbaci</button></td>
                        </tr>";
                        $i++;
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
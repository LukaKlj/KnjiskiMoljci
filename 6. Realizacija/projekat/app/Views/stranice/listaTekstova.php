<div class="container-fluid back">
    <div class="row">
        <div class="offset-sm-4 col-sm-4 text-center">
            <span class="poruka" style="color:red">
                <?php if(isset($poruka)) echo $poruka;?>
            </span>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 text-center">
            <h3 class="newText" align="left">
                <?php echo "{$korisnik2->username}({$statusKorisnika})";?>
            </h3>
            <div class="table-responsive smallerfont">
                <table class="table table-sm newText">
                    <thead>
                        <th>Tekst</th>
                        <th>Oblast</th>
                        <th>Vreme</th>
                        <th>Prosečna ocena</th>
                    </thead>
                    <tbody>
                        <?php
                            foreach($tekstovi as $tekst){
                                echo "<tr><td><a href='".site_url($controller."/citanjeTeksta/{$tekst->IdTeksta}")."'>{$tekst->Naziv}</a></td>
                                <td>{$oblasti[$tekst->IdTeksta]->Naziv}</td>
                                <td>{$tekst->Datum} {$tekst->Vreme}</td>
                                <td><b>{$prosecneOcene[$tekst->IdTeksta]}</b></td></tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="offset-sm-9 col-sm-3 table newText smallerfont">
                Ukupna prosečna ocena: <b><?php echo $ukupnaProsecnaOcena;?></b>
            </div>
        </div>
    </div>
</div>
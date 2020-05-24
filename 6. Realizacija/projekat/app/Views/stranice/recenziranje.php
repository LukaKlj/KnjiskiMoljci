<div class="container-fluid back">
    <div class="row">
        <div class="col-sm-12 naslov text-center">
            <h2>Recenziraj</h2>
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
                    <form method="get">
                        <tbody>
                        <?php
                        foreach($tekstovi as $tekst){
                            echo "
                            <tr>
                                <td><a href='../texts/$tekst->Tekst'>$tekst->Naziv</a></td>
                                <td><a href='". site_url($controller."/pregledTekstova/{$korisnici[$tekst->IdTeksta]->IdKor}")
                                ."'>{$korisnici[$tekst->IdTeksta]->username}</a></td>
                                <td>{$oblasti[$tekst->IdTeksta]->Naziv}</td>
                                <td>{$tekst->Datum} {$tekst->Vreme}</td>
                                <td><button type='submit' class='btn-success' formaction='".site_url($controller."/odobri/$tekst->IdTeksta")."'>Odobri</button></td>
                                <td><button type='submit' class='btn-danger' formaction='". site_url($controller."/odbaci/$tekst->IdTeksta")."'>Odbaci</button></td>
                            </tr>";
                        }
                        ?>
                        </tbody>
                    </form>
                </table>
            </div>
        </div>
    </div>
</div>
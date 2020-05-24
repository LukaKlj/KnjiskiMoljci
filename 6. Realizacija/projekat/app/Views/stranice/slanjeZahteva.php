<div class="container-fluid back">
    <div class="row">
        <div class="col-sm-12 text-center naslov">
            <h2>Zahtev za unapređenje u status recenzenta</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 userpass text-center">
            <h3>Izaberi oblast:</h3>
            <form action="<?php echo site_url($controller."/noviZahtev")?>" method="get">
                <select name="oblast">
                    <?php
                        foreach($oblasti as $oblast){
                            echo "<option value='$oblast->IdObl'>$oblast->Naziv</option>";
                        }
                    ?>
                </select>
                <button type="submit" class="btn-success">Posalji zahtev</button>
            </form>
        </div>
    </div>
</div>


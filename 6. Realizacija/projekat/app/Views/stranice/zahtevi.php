<div class="container-fluid back">
        <div class="row">
            <div class="col-sm-12 text-center naslov">
                <h2>Odobravanje zahteva za unapređenje u status recenzenta</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <h3 class="userpass">Izaberi oblast:</h3>
                <ul type="square">
                <?php
                    foreach($oblasti as $oblast){
                        echo "<li><a href='". site_url($controller."/pregledZahteva/{$oblast->IdObl}")."'>$oblast->Naziv</a></li>";
                    }
                ?>  
                </ul>
            </div>
        </div>
    </div>
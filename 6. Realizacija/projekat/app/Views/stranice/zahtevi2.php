<div class="container-fluid back">
    <div class="row">
        <div class="col-sm-12 text-center naslov">
            <h2>Odobravanje zahteva za unapređenje u status recenzenta</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 text-center">
            <span style="color:red" class="font-italic smallerfont poruka">
                <?php if(isset($poruka)) echo $poruka;?>
            </span>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <h3 class="userpass">Oblast: <?php echo $oblast->Naziv;?></h3>
            <div class="table-responsive smallerfont">
                <table class="table table-sm userpass">
                    <thead>
                        <th>Autor</th>
                        <th>Prosečna ocena</th>
                        <th>Broj recenziranih dela</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </thead>
                    <form method="get">
                        <tbody>
                            <?php
                            foreach($prosecneOcene as $prosecnaOcena){
                                $broj="";
                                $recenzent=false;
                                if($prosecnaOcena["brojRecenzija"]!=null){
                                    $recenzent=true;
                                    $broj=$broj.$prosecnaOcena["brojRecenzija"];
                                }
                                echo "<tr>
                                    <td><a href='". site_url($controller."/pregledTekstova/{$prosecnaOcena["id"]}")."'>{$prosecnaOcena["username"]}</a></td>
                                    <td>{$prosecnaOcena["ocena"]}</td>
                                    <td>{$broj}</td>";
                                if($recenzent){
                                    echo "<td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td><button class='btn btn-sm btn-warning' formaction='".site_url($controller."/vrati/{$oblast->IdObl}/{$prosecnaOcena["id"]}")."'>Vrati</button></td>
                                    </tr>";
                                }
                                else{
                                    echo "<td><button class='btn btn-sm btn-success' formaction='".site_url($controller."/odobri/{$oblast->IdObl}/{$prosecnaOcena["id"]}")."'>Odobri</button></td>
                                        <td><button class='btn btn-sm btn-danger' formaction='".site_url($controller."/odbaci/{$oblast->IdObl}/{$prosecnaOcena["id"]}")."'>Odbaci</button></td>
                                        <td>&nbsp;</td>
                                    </tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </form>
                </table>
            </div>
        </div>
    </div>
</div>
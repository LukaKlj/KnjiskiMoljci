<script>
    var parametar1="<?php echo $oblast->IdObl;?>";
    var parametri2=[];
</script>
<script src="<?php echo site_url("/assets/js/scriptZahtevi.js"); ?>"></script> 
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
                    <tbody id="telo">
                        <?php
                        $i=0;
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
                            echo "<script>parametri2[{$i}]=".$prosecnaOcena['id'].";</script>";
                            if($recenzent){
                                echo "<td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td><button class='btn btn-sm btn-warning vrati' data-index='{$i}'>Vrati</button></td>
                                </tr>";
                            }
                            else{
                                echo "<td><button class='btn btn-sm btn-success odobri' data-index='{$i}'>Odobri</button></td>
                                    <td><button class='btn btn-sm btn-danger odbaci' data-index='{$i}'>Odbaci</button></td>
                                    <td>&nbsp;</td>
                                </tr>";
                            }
                            $i++;
                        }
                        ?>
                    </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
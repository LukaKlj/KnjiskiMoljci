<div class="container-fluid back">
    <div class="row">
        <div class="col-sm-3 text-center userpass">
            <span style="color:red" class="font-italic smallerfont poruka">
                <?php if(isset($poruka)) echo $poruka;?>
            </span>
        </div>
        <div class="col-sm-3">
            <form class="navbar-form" name="pretraga" action="<?php echo site_url($controller."/pretraga")?>" method="get">
                <div class="input-group">
                    <input name="kljuc" class="form-control input-sm" type="text" placeholder="Pretraga...">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default userpass">Pretrazi</button>
                    </span>
                </div>
            </form>
        </div>
        <div class="offset-sm-3 col-sm-2 userpass">
            <?php echo $pager->links()?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="table-responsive smallerfont">
                <table class="table table-sm userpass">
                    <thead>
                        <tr class="d-flex">
                            <th class="col-2">Naziv teksta</th>
                            <th class="col-2">Autor</th>
                            <th class="col-2">Prosek ocena</th>
                            <th class="col-2">Oblast</th>
                            <th class="col-4">Vreme</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($tekstovi as $tekst){
                                echo "<tr class='d-flex'>
                                    <td class='col-2'>
                                        <a href='".site_url($controller."/citanjeTeksta/{$tekst->IdTeksta}")."'>{$tekst->Naziv}</a>
                                    </td> 
                                    <td class='col-2'>
                                        <a href='".site_url($controller."/pregledTekstova/{$tekst->IdKor}")."'>{$korisnici[$tekst->IdTeksta]->username}</a>
                                    </td>
                                    <td class='col-2'>
                                        {$prosecneOcene[$tekst->IdTeksta]}
                                    </td>
                                    <td class='col-2'>
                                        {$oblasti[$tekst->IdTeksta]->Naziv}
                                    </td>
                                    <td class='col-4'>{$tekst->Datum} {$tekst->Vreme}</td>
                                </tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>                
        </div>
    </div>
</div>

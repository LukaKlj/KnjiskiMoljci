<?php namespace App\Controllers;

use App\Models\OblastModel;
use App\Models\ZahtevModel;
use App\Models\PisacModel;
use App\Models\RecenzentModel;
use App\Models\RecenzijaModel;
use App\Models\OcenaModel;
use CodeIgniter\I18n\Time;

class Admin extends Korisnik{
    protected function getController() {
        return "Admin";
    }

    protected function getStatus() {
        return "Administrator";
    }
    
    public function zahtevi(){
        $oblastModel=new OblastModel();
        $oblasti=$oblastModel->findAll();
        $this->prikaz("zahtevi", ["akcija"=>"zahtevi", "oblasti"=>$oblasti]);
    }
    
    public function pregledZahteva($idobl){
        $oblastModel=new OblastModel();
        $zahtevModel=new ZahtevModel();
        $pisacModel=new PisacModel();
        $recenzentModel=new RecenzentModel();
        $ocenaModel=new OcenaModel();
        $oblast=$oblastModel->find($idobl);
        $zahtevi=$zahtevModel->where("IdObl", $idobl)->findAll();
        $pisci=$pisacModel->pisciZaZahteve($zahtevi);
        $recenzenti=$recenzentModel->where("IdObl", $idobl)->findAll();
        $prosecneOcene=$ocenaModel->prosecneOceneKorisnika($pisci, $recenzenti);
        $poruka=$this->session->getFlashdata("poruka");
        $this->prikaz("zahtevi2", ["akcija"=>"zahtevi", "oblast"=>$oblast, 'prosecneOcene'=>$prosecneOcene, 'poruka'=>$poruka]);
    }
    
    public function vrati($idobl, $idkor){
        $db=db_connect();
        $recenzentModel=new RecenzentModel();
        $pisacModel=new PisacModel();
        $oblastModel=new OblastModel();
        $recenzijaModel=new RecenzijaModel();
        $time=new Time('now', 'Europe/Belgrade');
        $db->transStart();
        $recenzent=$recenzentModel->find($idkor);
        if($recenzent!=null){
            $pisacModel->insert([
                "IdKor"=>$idkor,
                "PocetakKarijere"=>$time->toDateString()
            ]);
            $recenzijaModel->where('IdKor', $idkor)->delete();
            $recenzentModel->delete($idkor);
            $oblast=$oblastModel->find($idobl);
            $oblastModel->update($idobl, [
                "BrojRecenzenata"=>$oblast->BrojRecenzenata-1
            ]);
        }
        $db->transComplete();
    }
    
    public function odobri($idobl, $idkor){
        $db=db_connect();
        $zahtevModel=new ZahtevModel();
        $oblastModel=new OblastModel();
        $recenzentModel=new RecenzentModel();
        $pisacModel=new PisacModel();
        $oblast=$oblastModel->find($idobl);
        $brojRecenzenata=$oblast->BrojRecenzenata;
        $db->transStart();
        $zahtev=$zahtevModel->where("IdObl", $idobl)->where("IdKor", $idkor)->first();
        if($zahtev!=null){
            if($brojRecenzenata<10){
                $recenzentModel->insert([
                    "IdKor"=>$idkor,
                    "BrojZavrsenihRecenzija"=>0,
                    "IdObl"=>$idobl
                ]);
                $pisacModel->delete($idkor);
                $oblast=$oblastModel->find($idobl);
                $oblastModel->update($idobl, [
                    "BrojRecenzenata"=>$oblast->BrojRecenzenata+1
                ]);
                $zahtevModel->where("IdKor", $idkor)->delete();
            }
            else{
                echo "Dostignut je maksimalan broj recenzenata za ovu oblast";
            }
        }
        $db->transComplete();
    }
    
    public function odbaci($idobl, $idkor) {
        $db=db_connect();
        $zahtevModel=new ZahtevModel();
        $db->transStart();
        $zahtevModel->where("IdObl", $idobl)->where("IdKor", $idkor)->delete();
        $db->transComplete();
    }
    
    public function osveziZahteve($idobl){
        $zahtevModel=new ZahtevModel();
        $pisacModel=new PisacModel();
        $recenzentModel=new RecenzentModel();
        $ocenaModel=new OcenaModel();
        $zahtevi=$zahtevModel->where("IdObl", $idobl)->findAll();
        $pisci=$pisacModel->pisciZaZahteve($zahtevi);
        $recenzenti=$recenzentModel->where("IdObl", $idobl)->findAll();
        $prosecneOcene=$ocenaModel->prosecneOceneKorisnika($pisci, $recenzenti);
        $i=0;
        foreach($prosecneOcene as $prosecnaOcena){
            $broj="";
            $recenzent=false;
            if($prosecnaOcena["brojRecenzija"]!=null){
                $recenzent=true;
                $broj=$broj.$prosecnaOcena["brojRecenzija"];
            }
            echo "<tr>
                <td><a href='". site_url($this->getController()."/pregledTekstova/{$prosecnaOcena["id"]}")."'>{$prosecnaOcena["username"]}</a></td>
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
    }
}
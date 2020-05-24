<?php namespace App\Controllers;

use App\Models\OblastModel;
use App\Models\ZahtevModel;
use App\Models\PisacModel;
use App\Models\RecenzentModel;
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
        $time=new Time('now', 'Europe/Belgrade');
        $db->transStart();
        $pisacModel->insert([
            "IdKor"=>$idkor,
            "PocetakKarijere"=>$time->toDateString()
        ]);
        $recenzentModel->delete($idkor);
        $oblast=$oblastModel->find($idobl);
        $oblastModel->update($idobl, [
            "BrojRecenzenata"=>$oblast->BrojRecenzenata-1
        ]);
        $db->transComplete();
        return redirect()->back();
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
            $zahtevModel->where("IdObl", $idobl)->where("IdKor", $idkor)->delete();
        }
        else{
            $this->session->setFlashdata("poruka", "Dostignut je maksimalan broj recenzenata za ovu oblast");
            return redirect()->back();
        }
        $db->transComplete();
        return redirect()->back();
    }
    
    public function odbaci($idobl, $idkor) {
        $zahtevModel=new ZahtevModel();
        $zahtevModel->where("IdObl", $idobl)->where("IdKor", $idkor)->delete();
        return redirect()->back();
    }
}
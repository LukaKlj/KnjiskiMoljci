<?php namespace App\Controllers;

use App\Models\OblastModel;
use App\Models\ZahtevModel;
use App\Models\PisacModel;
use CodeIgniter\I18n\Time;

class Pisac extends Korisnik{
    protected function getController() {
        return "Pisac";
    }

    protected function getStatus() {
        return "Pisac";
    }
    
    public function mozeLiPoslati(){
        $pisacModel=new PisacModel();
        $pisac=$pisacModel->find($this->session->get('korisnik')->IdKor);
        $start=Time::createFromFormat("Y-m-d", $pisac->PocetakKarijere);
        $now=new Time('now', 'Europe/Belgrade');
        $razlika=$start->difference($now);
        if($razlika->getYears()<3){
            echo "Morate bar tri godine biti u statusu pisca";
        }
    }   
    
    public function slanjeZahteva(){
        $oblastModel=new OblastModel();
        $oblasti=$oblastModel->findAll();
        $poruka=$this->session->getFlashdata("poruka");
        $this->prikaz("slanjeZahteva", ["akcija"=>"slanjeZahteva", "oblasti"=>$oblasti, "poruka"=>$poruka]);
    }
    
    public function noviZahtev(){
        $zahtevModel=new ZahtevModel();
        $time=new Time('now', 'Europe/Belgrade');
        if($zahtevModel->nePostojiNeodobren($this->session->get('korisnik')->IdKor, $this->request->getVar('oblast'))){
            $zahtevModel->save([
                'Datum'=>$time->toDateString(),
                'Vreme'=>$time->toTimeString(),
                'IdKor'=>$this->session->get('korisnik')->IdKor,
                'IdObl'=>$this->request->getVar('oblast')
            ]);
            echo "Poslat je zahtev";
        }
        else{
            echo "Već ste poslali zahtev za unapređenje u status recenzenta za ovu oblast";
        }
    }
}

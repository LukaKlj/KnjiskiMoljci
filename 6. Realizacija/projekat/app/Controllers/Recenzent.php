<?php namespace App\Controllers;

use App\Models\TekstModel;
use App\Models\KorisnikModel;
use App\Models\OblastModel;
use App\Models\CitalacModel;
use App\Models\RecenzijaModel;
use App\Models\RecenzentModel;
use App\Models\PisacModel;
use CodeIgniter\I18n\Time;

class Recenzent extends Korisnik{
    protected function getController() {
        return "Recenzent";
    }

    protected function getStatus() {
        return "Recenzent";
    }
    
    public function recenziranje(){
        $tekstModel=new TekstModel();
        $korisnikModel=new KorisnikModel();
        $oblastModel=new OblastModel();
        $tekstovi=$tekstModel->sviZaRecenziranje($this->session->get("korisnik")->IdKor);
        $korisnici=$korisnikModel->korisniciZaTekstove($tekstovi);
        $oblasti=$oblastModel->oblastiZaTekstove($tekstovi);
        $poruka=$this->session->getFlashdata("poruka");
        $this->prikaz("recenziranje", ["akcija"=>"recenziranje", "tekstovi"=>$tekstovi, "korisnici"=>$korisnici, "oblasti"=>$oblasti, 
            "poruka"=>$poruka]);
    }
    
    public function odobri($idteksta){
        $db=db_connect();
        $tekstModel=new TekstModel();
        $citalacModel=new CitalacModel();
        $recenzijaModel=new RecenzijaModel();
        $recenzentModel=new RecenzentModel();
        $pisacModel=new PisacModel();
        $tekst=$tekstModel->find($idteksta);
        $citalac=$citalacModel->find($tekst->IdKor);
        $time=new Time('now', 'Europe/Belgrade');
        $db->transStart();
        $tekstModel->update($idteksta, ["Odobren"=>1]);
        $recenzijaModel->save([
            "IdTeksta"=>$tekst->IdTeksta,
            "IdKor"=>$this->session->get("korisnik")->IdKor
        ]);
        $recenzent=$recenzentModel->find($this->session->get("korisnik")->IdKor);
        $recenzentModel->update($this->session->get("korisnik")->IdKor, [
            "BrojZavrsenihRecenzija"=>$recenzent->BrojZavrsenihRecenzija+1
        ]);
        if($citalac!=null){
            $pisacModel->insert([
                "IdKor"=>$citalac->IdKor,
                "PocetakKarijere"=>$time->toDateString()
            ]);
            $citalacModel->delete($citalac->IdKor);
        }
        $db->transComplete();
        return redirect()->to(site_url($this->getController()."/recenziranje"));
    }
    
    public function odbaci($idteksta){
        $tekstModel=new TekstModel();
        $tekst=$tekstModel->find($idteksta);
        $name=$tekst->Tekst;
        $filepath=FCPATH."/texts/".$name;
        unlink($filepath);
        $tekstModel->delete($idteksta);
        return redirect()->to(site_url($this->getController()."/recenziranje"));
    }
}
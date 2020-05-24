<?php namespace App\Controllers;

use App\Models\OblastModel;
use App\Models\TekstModel;
use App\Models\KorisnikModel;
use App\Models\OcenaModel;
use CodeIgniter\I18n\Time;

abstract class Korisnik extends BaseController{
    protected function prikaz($name, $data){
        $data["status"]=$this->getStatus();
        $data["controller"]=$this->getController();
        $data["korisnik"]=$this->session->get("korisnik");
        echo view('sabloni/header', $data);
        echo view("stranice/$name", $data);
        echo view('sabloni/footer');
    }
    
    public function index(){
        $this->prikaz("pocetna", ["akcija"=>"pocetna"]);
    }
    
    public function objavaTeksta($poruka=null){
        $oblastModel=new OblastModel();
        $oblasti=$oblastModel->findAll();
        $this->prikaz("objavaTeksta", ["akcija"=>"objava", "oblasti"=>$oblasti, "poruka"=>$poruka]);
    }
    
    public function noviTekst(){
        if(!$this->validate(["naslov"=>"required"])){
            return $this->objavaTeksta("Izaberite naslov");
        }
        $file = $this->request->getFile('myfile');
        if($file==null || !$file->isValid()){
            return $this->objavaTeksta("Priložite tekst");
        }
        if($file->getExtension()!="pdf"){
            return $this->objavaTeksta("Priložite tekst u .pdf formatu");
        }
        $tekstModel=new TekstModel();
        $link=($tekstModel->najveciID()+1).".pdf";
        $file->store('../texts/', $link);
        $time=new Time('now', 'Europe/Belgrade');
        $tekstModel->save([
            'Naziv'=>$this->request->getVar('naslov'),
            'Odobren'=>0,
            'Tekst'=>$link,
            'IdKor'=>$this->session->get('korisnik')->IdKor,
            'IdObl'=>$this->request->getVar('oblast'),
            'Datum'=>$time->toDateString(),
            'Vreme'=>$time->toTimeString()
        ]);
        return redirect()->to(site_url($this->getController()));
    }
    
    public function promenaPodataka(){
        $this->prikaz("promenaPodataka", ["akcija"=>"podaci"]);
    }
    
    public function promenaLozinke(){
        $this->prikaz("promenaLozinke", ["akcija"=>"lozinka"]);
    }
    
    public function pregledTekstova($idkor){
        $korisnikModel=new KorisnikModel();
        $tekstModel=new TekstModel();
        $ocenaModel=new OcenaModel();
        $oblastModel=new OblastModel();
        $statusKorisnika=$korisnikModel->dohvatiStatus($idkor);
        if($statusKorisnika!='Citalac'){
            $korisnik=$korisnikModel->find($idkor);
            $tekstovi=$tekstModel->tekstoviKorisnika($korisnik->IdKor);
            $prosecneOcene=[];
            $oblasti=[];
            $ukupniZbir=0;
            $ukupniBrojac=0;
            foreach($tekstovi as $tekst){
                $zbir=0;
                $brojac=0;
                if($tekst->Odobren){
                    $ocene=$ocenaModel->where("IdTeksta", $tekst->IdTeksta)->findAll();
                    foreach($ocene as $ocena){
                        $ukupniZbir+=$ocena->Ocena;
                        $ukupniBrojac++;
                        $zbir+=$ocena->Ocena;
                        $brojac++;
                    }
                }
                if($brojac==0){
                    $prosecneOcene[$tekst->IdTeksta]="Nema ocena";
                }
                else{
                    $prosecneOcene[$tekst->IdTeksta]=$zbir/$brojac;
                }
                $oblasti[$tekst->IdTeksta]=$oblastModel->find($tekst->IdObl);
            }
            if($ukupniBrojac==0){
                $ukupnaProsecnaOcena="Nema ocena";
            }
            else{
                $ukupnaProsecnaOcena=$ukupniZbir/$ukupniBrojac;
            }
            $this->prikaz("listaTekstova", ['korisnik'=>$korisnik, 'statusKorisnika'=>$statusKorisnika, 'tekstovi'=>$tekstovi, 'oblasti'=>$oblasti,
                'ukupnaProsecnaOcena'=>$ukupnaProsecnaOcena, 'prosecneOcene'=>$prosecneOcene]);
        }
        else{
            return redirect()->back();
        }
    }
    
    abstract protected function getStatus();
    abstract protected function getController();
}


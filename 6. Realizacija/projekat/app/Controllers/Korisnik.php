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
        $poruka=$this->session->getFlashdata("poruka");
        $this->prikaz("pocetna", ["akcija"=>"pocetna", "poruka"=>$poruka]);
    }
    
    public function objavaTeksta($poruka=null){
        $oblastModel=new OblastModel();
        $oblasti=$oblastModel->findAll();
        $poruka=$this->session->getFlashdata("poruka");
        $boja=$this->session->getFlashdata("boja");
        $this->prikaz("objavaTeksta", ["akcija"=>"objava", "oblasti"=>$oblasti, "poruka"=>$poruka, "boja"=>$boja]);
    }
    
    public function noviTekst(){
        if(!$this->validate(["naslov"=>"required"])){
            $this->session->setFlashdata("boja", "crvena");
            $this->session->setFlashdata("poruka", "Izaberite naslov");
            return redirect()->back()->withInput();
        }
        $file = $this->request->getFile('myfile');
        if($file==null || !$file->isValid()){
            $this->session->setFlashdata("boja", "crvena");
            $this->session->setFlashdata("poruka", "Priložite tekst");
            return redirect()->back()->withInput();
        }
        if($file->getExtension()!="pdf"){
            $this->session->setFlashdata("boja", "crvena");
            $this->session->setFlashdata("poruka", "Priložite tekst u .pdf formatu");
            return redirect()->back()->withInput();
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
        $this->session->setFlashdata("poruka", "Uspešno objavljen tekst");
        return redirect()->back();
    }
    
    public function promenaPodataka(){
        $poruka=$this->session->getFlashdata("poruka");
        $boja=$this->session->getFlashdata("boja");
        $this->prikaz("promenaPodatakaOstali", ["akcija"=>"podaci", "poruka"=>$poruka, "boja"=>$boja]);
    }
    
    public function noviPodaci() {
        if(!$this->validate(['ime'=>'required', 'prezime'=>'required', 'email'=>'required'])){
            $this->session->setFlashdata("poruka", "Sva polja moraju biti popunjena");
            return redirect()->back()->withInput();
        }
        if(!$this->validate(['email'=>'valid_email'])){
            $this->session->setFlashdata("poruka", "Loš format e-mail adrese");
            return redirect()->back()->withInput();
        }
        $korisnikModel=new KorisnikModel();
        $korisnikModel->update($this->session->get("korisnik")->IdKor,[
            'Ime'=>$this->request->getVar('ime'),
            'Prezime'=>$this->request->getVar('prezime'),
            'email'=>$this->request->getVar('email')
        ]);
        $this->session->setFlashdata("boja", "bela");
        $this->session->setFlashdata("poruka", "Uspešno promenjeni podaci");
        return redirect()->back();
    }
    
    public function promenaLozinke(){
        $poruka=$this->session->getFlashdata("poruka");
        $boja=$this->session->getFlashdata("boja");
        $this->prikaz("promenaLozinke", ["akcija"=>"lozinka", "poruka"=>$poruka, "boja"=>$boja]);
    }
    
    public function novaLozinka(){
        $korisnikModel=new KorisnikModel();
        if(!$this->validate(['stara'=>'required', 'staraPonovo'=>'required', 'nova'=>'required'])){
            $this->session->setFlashdata("poruka", "Sva polja moraju biti popunjena");
            return redirect()->back();
        }
        if($this->request->getVar('stara')!=$this->session->get('korisnik')->password){
            $this->session->setFlashdata("poruka", "Stara lozinka nije dobra");
            return redirect()->back();
        }
        if($this->request->getVar('stara')!=$this->request->getVar('staraPonovo')){
            $this->session->setFlashdata("poruka", "Potvrda stare lozinke ne odgovara staroj lozinci");
            return redirect()->back();
        }
        if(!$this->validate(['nova'=>'min_length[8]'])){
            $this->session->setFlashdata("poruka", "Nova lozinka se mora sastojati od bar 8 karaktera");
            return redirect()->back();
        }
        $korisnikModel->update($this->session->get('korisnik')->IdKor, [
            'password'=>$this->request->getVar('nova')
        ]);
        $this->session->setFlashdata("boja", "bela");
        $this->session->setFlashdata("poruka", "Uspešno promenjena lozinka");
        return redirect()->back();
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
            $poruka=$this->session->getFlashdata("poruka");
            $this->prikaz("listaTekstova", ['korisnik'=>$korisnik, 'statusKorisnika'=>$statusKorisnika, 'tekstovi'=>$tekstovi, 'oblasti'=>$oblasti,
                'ukupnaProsecnaOcena'=>$ukupnaProsecnaOcena, 'prosecneOcene'=>$prosecneOcene, "poruka"=>$poruka]);
        }
        else{
            $this->session->setFlashdata("boja", "crvena");
            $this->session->setFlashdata("poruka", "Taj korisnik je u statusu čitaoca");
            return redirect()->back()->withInput();
        }
    }
    
    abstract protected function getStatus();
    abstract protected function getController();
}


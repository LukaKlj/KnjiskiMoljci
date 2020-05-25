<?php namespace App\Controllers;

use App\Models\OblastModel;
use App\Models\TekstModel;
use App\Models\KorisnikModel;
use App\Models\KomentarModel;
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
        $tekstModel=new TekstModel();
        $korisnikModel=new KorisnikModel();
        $ocenaModel=new OcenaModel();
        $oblastModel=new OblastModel();
        $tekstovi=$this->session->getFlashdata("tekstovi");
        $pager=$this->session->getFlashdata("pager");
        if($tekstovi==null){
            $tekstovi=$tekstModel->where('Odobren', 1)->paginate(10);
            $pager=$tekstModel->pager;
        }
        $korisnici=$korisnikModel->korisniciZaTekstove($tekstovi);
        $prosecneOcene=$ocenaModel->prosecneOcene($tekstovi);
        $oblasti=$oblastModel->oblastiZaTekstove($tekstovi);
        $poruka=$this->session->getFlashdata("poruka");
        $this->prikaz("pocetna", ["akcija"=>"pocetna", "poruka"=>$poruka,
            "tekstovi"=>$tekstovi, "pager"=>$pager, "korisnici"=>$korisnici,
            "prosecneOcene"=>$prosecneOcene, "oblasti"=>$oblasti]);
    }
    
    public function pretraga(){
        $tekstModel=new TekstModel();
        $tekstovi=$tekstModel->where("Odobren", 1)->like("Naziv", $this->request->getVar("kljuc"))->paginate(10);
        if($tekstovi==null){
            $this->session->setFlashdata("poruka", "Nijedan tekst nije pronađen pa su zato prikazani svi");
        }
        $this->session->setFlashdata("tekstovi", $tekstovi);
        $this->session->setFlashdata("pager", $tekstModel->pager);
        return redirect()->back();
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
    
    public function odjava(){
        $this->session->destroy();
        return redirect()->to('/');
    }
    
    public function citanjeTeksta($idteksta){
        $tekstModel=new TekstModel();
        $komentarModel=new KomentarModel();
        $korisnikModel=new KorisnikModel();
        $ocenaModel=new OcenaModel();
        $tekst=$tekstModel->find($idteksta);
        $komentari=$komentarModel->where("IdTeksta", $idteksta)->orderBy("Datum", "ASC")->orderBy("Vreme", "ASC")->findAll();
        $korisnici=$korisnikModel->korisniciZaKomentare($komentari);
        $ocena=$ocenaModel->where("IdKor", $this->session->get('korisnik')->IdKor)->where("IdTeksta", $idteksta)->first();
        $poruka=$this->session->getFlashdata("poruka");
        $boja=$this->session->getFlashdata("boja");
        $this->prikaz("citanjeTeksta", ["poruka"=>$poruka, "boja"=>$boja, "tekst"=>$tekst, "komentari"=>$komentari,
            "korisnici"=>$korisnici, "ocena"=>$ocena]);
    }
    
    //poziva se AJAXom
    public function oceni($idteksta){
        $ocenaModel=new OcenaModel();
        if($this->request->getVar('ocena')=='bez'){
            $ocenaModel->where("IdKor", $this->session->get('korisnik')->IdKor)->where("IdTeksta", $idteksta)->delete();
            echo "Ocena obrisana";
            return;
        }
        $ocena=$ocenaModel->where("IdKor", $this->session->get('korisnik')->IdKor)->where("IdTeksta", $idteksta)->first();
        if($ocena!=null){
            $ocena=$ocenaModel->where("IdKor", $this->session->get('korisnik')->IdKor)
                    ->where("IdTeksta", $idteksta)->set(["Ocena"=>$this->request->getVar('ocena')])->update();
        }
        else{
            $ocenaModel->insert([
                'IdKor'=>$this->session->get('korisnik')->IdKor,
                'IdTeksta'=>$idteksta,
                'Ocena'=>$this->request->getVar('ocena')
            ]);
        }
        echo "Uspešno zabeležena ocena";
    }
    
    //poziva se AJAXom
    public function komentarisi($idteksta){
        $komentarModel=new KomentarModel();
        $time=new Time('now', 'Europe/Belgrade');
        $komentarModel->insert([
            'Tekst'=>$this->request->getVar('komentar'),
            'Datum'=>$time->toDateString(),
            'Vreme'=>$time->toTimeString(),
            'IdKor'=>$this->session->get('korisnik')->IdKor,
            'IdTeksta'=>$idteksta
        ]);
    }
    
    public function osveziKomentare($idteksta){
        $komentarModel=new KomentarModel();
        $korisnikModel=new KorisnikModel();
        $komentari=$komentarModel->where("IdTeksta", $idteksta)->orderBy("Datum", "ASC")->orderBy("Vreme", "ASC")->findAll();
        $korisnici=$korisnikModel->korisniciZaKomentare($komentari);
        foreach ($komentari as $komentar){
            echo "<tr>
                <td><a href='".site_url($this->getController()."/pregledTekstova/{$korisnici[$komentar->IdKom]->IdKor}")."'>{$korisnici[$komentar->IdKom]->username}</a></td>
                <td>{$komentar->Tekst}</td>
                <td>{$komentar->Datum} {$komentar->Vreme}</td>
            </tr>";
        }
    }
    
    abstract protected function getStatus();
    abstract protected function getController();
}


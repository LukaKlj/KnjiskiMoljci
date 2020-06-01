<?php namespace App\Controllers;

use App\Models\OblastModel;
use App\Models\TekstModel;
use App\Models\KorisnikModel;
use App\Models\KomentarModel;
use App\Models\OcenaModel;
use App\Models\CitaModel;
use CodeIgniter\I18n\Time;

/*Korisnik kontroler
 * sluzi za sve operacije koje mogu da obavljaju svi korisnici
 * iz nje se izvode klase ostalih specijalnih tipova korisnika
 * Autori: Marija Miletic, Filip Lazovic, Luka Kljajic
 */

abstract class Korisnik extends BaseController{
    //sluzi za enkapsuliranje pravilnog pozivanja view-ova
    protected function prikaz($name, $data){
        $data["status"]=$this->getStatus();
        $data["controller"]=$this->getController();
        $data["korisnik"]=$this->session->get("korisnik");
        echo view('sabloni/header', $data);
        echo view("stranice/$name", $data);
        echo view('sabloni/footer');
    }
    
    //podrazumevana strana, preko nje se vrsi pretraga
    public function index(){
        $tekstModel=new TekstModel();
        $korisnikModel=new KorisnikModel();
        $ocenaModel=new OcenaModel();
        $oblastModel=new OblastModel();
        $broj;
        if($this->request->getVar('brojPoStrani')!=null){
            $broj=$this->request->getVar('brojPoStrani');
        }
        else{
            $broj=20;
        }
        if($broj<1) $broj=1;
        if($this->request->getVar('kljuc')!=null){
            $tekstovi=$tekstModel->where("Odobren", 1)->like("Naziv", $this->request->getVar("kljuc"))->paginate($broj);
        }
        else{
            $tekstovi=$tekstModel->where('Odobren', 1)->paginate($broj);
        }
        $pager=$tekstModel->pager;
        $korisnici=$korisnikModel->korisniciZaTekstove($tekstovi);
        $prosecneOcene=$ocenaModel->prosecneOcene($tekstovi);
        $oblasti=$oblastModel->oblastiZaTekstove($tekstovi);
        $poruka=$this->session->getFlashdata("poruka");
        $this->prikaz("pocetna", ["akcija"=>"pocetna", "poruka"=>$poruka,
            "tekstovi"=>$tekstovi, "pager"=>$pager, "korisnici"=>$korisnici,
            "prosecneOcene"=>$prosecneOcene, "oblasti"=>$oblasti, "broj"=>$broj]);
    }
    
    //prikazuje formu za objavu teksta
    public function objavaTeksta($poruka=null){
        $oblastModel=new OblastModel();
        $oblasti=$oblastModel->findAll();
        $poruka=$this->session->getFlashdata("poruka");
        $this->prikaz("objavaTeksta", ["akcija"=>"objava", "oblasti"=>$oblasti, "poruka"=>$poruka]);
    }
    
    //logika objavljivanja novog teksta, poziva se AJAXom
    public function noviTekst(){
        if(!$this->validate(["naslov"=>"required"])){
            echo json_encode(array("poruka"=>"Izaberite naslov", "boja"=>"crvena"));
            return;
        }
        $file = $this->request->getFile('myfile');
        if($file==null || !$file->isValid()){
            echo json_encode(array("poruka"=>"Priložite tekst", "boja"=>"crvena"));
            return;
        }
        if($file->getExtension()!="pdf"){
            echo json_encode(array("poruka"=>"Priložite tekst u PDF formatu", "boja"=>"crvena"));
            return;
        }
        $tekstModel=new TekstModel();
        $link=($tekstModel->najveciID()+1).".pdf";
        $file->store('../../public/texts/', $link);
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
        echo json_encode(array("poruka"=>"Uspešno objavljen tekst", "boja"=>"bela"));
    }
    
    // prikazuje stranu za promenu podataka
    public function promenaPodataka(){
        $poruka=$this->session->getFlashdata("poruka");
        $this->prikaz("promenaPodatakaOstali", ["akcija"=>"podaci", "poruka"=>$poruka]);
    }
    
    //logika za promenu podataka, poziva se AJAXom
    public function noviPodaci() {
        if(!$this->validate(['ime'=>'required', 'prezime'=>'required', 'email'=>'required'])){
            echo "Sva polja moraju biti popunjena";
            return;
        }
        if(!$this->validate(['email'=>'valid_email'])){
            echo "Loš format e-mail adrese";
            return;
        }
        $korisnikModel=new KorisnikModel();
        $db=db_connect();
        $db->transStart();
        $korisnikModel->update($this->session->get("korisnik")->IdKor,[
            'Ime'=>$this->request->getVar('ime'),
            'Prezime'=>$this->request->getVar('prezime'),
            'email'=>$this->request->getVar('email')
        ]);
        $korisnik=$korisnikModel->find($this->session->get('korisnik')->IdKor);
        $db->transComplete();
        $this->session->set('korisnik', $korisnik);
        echo "Uspešno promenjeni podaci";
    }
    
    //prikazuje stranu za promenu lozinke
    public function promenaLozinke(){
        $poruka=$this->session->getFlashdata("poruka");
        $this->prikaz("promenaLozinke", ["akcija"=>"lozinka", "poruka"=>$poruka]);
    }
    
    //logika promene lozinke, poziva se AJAXom
    public function novaLozinka(){
        $korisnikModel=new KorisnikModel();
        if(!$this->validate(['stara'=>'required', 'staraPonovo'=>'required', 'nova'=>'required'])){
            echo "Sva polja moraju biti popunjena";
            return;
        }
        if($this->request->getVar('stara')!=$this->session->get('korisnik')->password){
            echo "Stara lozinka nije dobra";
            return;
        }
        if($this->request->getVar('stara')!=$this->request->getVar('staraPonovo')){
            echo "Potvrda stare lozinke ne odgovara staroj lozinci";
            return;
        }
        if(!$this->validate(['nova'=>'min_length[8]'])){
            echo "Nova lozinka se mora sastojati od bar 8 karaktera";
            return;
        }
        $db=db_connect();
        $db->transStart();
        $korisnikModel->update($this->session->get('korisnik')->IdKor, [
            'password'=>$this->request->getVar('nova')
        ]);
        $korisnik=$korisnikModel->find($this->session->get('korisnik')->IdKor);
        $db->transComplete();
        $this->session->set('korisnik', $korisnik);
        echo "Uspešno promenjena lozinka";
    }
    
    //proverava da li je zadati korisnik u statusu citaoca, poziva se AJAXom
    public function citalac($idkor){
        $korisnikModel=new KorisnikModel();
        $statusKorisnika=$korisnikModel->dohvatiStatus($idkor);
        if($statusKorisnika=='Citalac'){
            echo "Taj korisnik je u statusu čitaoca";
        }
    }
    
    //prikazuje sve tekstove nekog korisnika
    public function pregledTekstova($idkor){
        $korisnikModel=new KorisnikModel();
        $tekstModel=new TekstModel();
        $ocenaModel=new OcenaModel();
        $oblastModel=new OblastModel();
        $statusKorisnika=$korisnikModel->dohvatiStatus($idkor);
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
        $this->prikaz("listaTekstova", ['korisnik2'=>$korisnik, 'statusKorisnika'=>$statusKorisnika, 'tekstovi'=>$tekstovi, 'oblasti'=>$oblasti,
            'ukupnaProsecnaOcena'=>$ukupnaProsecnaOcena, 'prosecneOcene'=>$prosecneOcene, "poruka"=>$poruka]);
    }
    
    //odjavljuje se
    public function odjava(){
        $this->session->destroy();
        return redirect()->to('/');
    }
    
    //prikazuje stranicu za citanje teksta
    public function citanjeTeksta($idteksta){
        $tekstModel=new TekstModel();
        $komentarModel=new KomentarModel();
        $korisnikModel=new KorisnikModel();
        $ocenaModel=new OcenaModel();
        $citaModel=new CitaModel();
        $tekst=$tekstModel->find($idteksta);
        $cita=$citaModel->where("IdKor", $this->session->get('korisnik')->IdKor)->where("IdTeksta", $idteksta)->first();
        if($cita!=null) $strana=$cita->Strana;
        else $strana=0;
        $autorTeksta=$korisnikModel->find($tekst->IdKor);
        $komentari=$komentarModel->where("IdTeksta", $idteksta)->orderBy("Datum", "ASC")->orderBy("Vreme", "ASC")->findAll();
        $korisnici=$korisnikModel->korisniciZaKomentare($komentari);
        $ocena=$ocenaModel->where("IdKor", $this->session->get('korisnik')->IdKor)->where("IdTeksta", $idteksta)->first();
        $poruka=$this->session->getFlashdata("poruka");
        $this->prikaz("citanjeTeksta", ["poruka"=>$poruka, "tekst"=>$tekst, "komentari"=>$komentari,
            "korisnici"=>$korisnici, "ocena"=>$ocena, "autorTeksta"=>$autorTeksta, "strana"=>$strana]);
    }
    
    //ocenjuje tekst, poziva se AJAXom
    public function oceni($idteksta){
        $ocenaModel=new OcenaModel();
        $korisnikModel=new KorisnikModel();
        $tekstModel=new TekstModel();
        $tekst=$tekstModel->find($idteksta);
        $autor=$korisnikModel->find($tekst->IdKor);
        if($autor==$this->session->get('korisnik')){
            echo "Ne možete oceniti svoj tekst";
            return;
        }
        if($this->request->getVar('ocena')=='bez'){
            $ocenaModel->where("IdKor", $this->session->get('korisnik')->IdKor)->where("IdTeksta", $idteksta)->delete();
            echo "Ocena obrisana";
            return;
        }
        $ocena=$ocenaModel->where("IdKor", $this->session->get('korisnik')->IdKor)->where("IdTeksta", $idteksta)->first();
        if($ocena!=null){
            $ocenaModel->where("IdKor", $this->session->get('korisnik')->IdKor)
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
    
    //komentarise tekst, poziva se AJAXom
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
    
    //osvezava prikaz komentara, poziva se AJAXom
    public function osveziKomentare($idteksta){
        $komentarModel=new KomentarModel();
        $korisnikModel=new KorisnikModel();
        $komentari=$komentarModel->where("IdTeksta", $idteksta)->orderBy("Datum", "ASC")->orderBy("Vreme", "ASC")->findAll();
        $korisnici=$korisnikModel->korisniciZaKomentare($komentari);
        foreach ($komentari as $komentar){
            echo "<tr>
                <td><a class='pointer-link korisnik' data-id='{$korisnici[$komentar->IdKom]->IdKor}'>{$korisnici[$komentar->IdKom]->username}</a></td>
                <td>{$komentar->Tekst}</td>
                <td>{$komentar->Datum} {$komentar->Vreme}</td>
            </tr>";
        }
    }
    
    //poziva se AJAXom u trenutku kada korisnik zavrsava citanje teksta i pamti stranu koju je odabrao da bude zapamcena
    public function zapamtiStranu($idteksta){
        $citaModel=new CitaModel();
        if($this->request->getVar('strana')==0){
            $citaModel->where("IdKor", $this->session->get('korisnik')->IdKor)->where("IdTeksta", $idteksta)->delete();
            return;
        }
        $cita=$citaModel->where("IdKor", $this->session->get('korisnik')->IdKor)->where("IdTeksta", $idteksta)->first();
        if($cita!=null){
            $citaModel->where("IdKor", $this->session->get('korisnik')->IdKor)
                    ->where("IdTeksta", $idteksta)->set(["Strana"=>$this->request->getVar('strana')])->update();
        }
        else{
            $citaModel->insert([
                'IdKor'=>$this->session->get('korisnik')->IdKor,
                'IdTeksta'=>$idteksta,
                'Strana'=>$this->request->getVar('strana')
            ]);
        }
    }
    
    //Vraca string koji treba biti ispisan kao status korisnik
    abstract protected function getStatus();
    //vraca ime kontrolera
    abstract protected function getController();
}


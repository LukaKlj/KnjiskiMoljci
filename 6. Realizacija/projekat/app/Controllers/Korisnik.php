<?php namespace App\Controllers;

use App\Models\OblastModel;
use App\Models\TekstModel;
use CodeIgniter\I18n\Time;

abstract class Korisnik extends BaseController{
    protected function prikaz($name, $data){
        $data["status"]=$this->getStatus();
        $data["controller"]=$this->getController();
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
        $file->store('../../texts/', $link);
        $time=new Time('now', 'Europe/Belgrade');
        $tekstModel->save([
            'Naziv'=>$this->request->getVar('naslov'),
            'Odobren'=>0,
            'Tekst'=>$link,
            //posle dodati
            //'IdKor'=>$this->session->get('korisnik')->IdKor,
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
    
    abstract protected function getStatus();
    abstract protected function getController();
}


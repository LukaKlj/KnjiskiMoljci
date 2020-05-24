<?php namespace App\Controllers;

use App\Models\KorisnikModel;
use App\Models\CitalacModel;
use CodeIgniter\I18n\Time;

class Citalac extends Korisnik{
    protected function getController() {
        return "Citalac";
    }
    
    public function promenaPodataka(){
        $citalacModel=new CitalacModel();
        $citalac=$citalacModel->find($this->session->get('korisnik')->IdKor);
        $poruka=$this->session->getFlashdata("poruka");
        $boja=$this->session->getFlashdata("boja");
        $time=new Time("now", "Europe/Belgrade");
        $godina=$time->getYear();
        $this->prikaz("promenaPodatakaCitalac", ["akcija"=>"podaci", "poruka"=>$poruka, "boja"=>$boja, 
            "godina"=>$godina, "citalac"=>$citalac]);
    }
    
    public function noviPodaci() {
        $db=db_connect();
        if(!$this->validate(['ime'=>'required', 'prezime'=>'required', 'email'=>'required',
            'broj'=>'required', 'cvv'=>'required'])){
            $this->session->setFlashdata("poruka", "Sva polja moraju biti popunjena");
            return redirect()->back()->withInput();
        }
        if(!$this->validate(['email'=>'valid_email'])){
            $this->session->setFlashdata("poruka", "Loš format e-mail adrese");
            return redirect()->back()->withInput();
        }
        $tipKartice=$this->request->getVar("CreditCards");
        if(!$this->validate(['broj'=>"valid_cc_number[$tipKartice]"])){
            $this->session->setFlashdata("poruka", "Broj kreditne kartice nije validan");
            return redirect()->back()->withInput();
        }
        if(!$this->validate(['cvv'=>'regex_match[/^[0-9]{3,4}$/]'])){
            $this->session->setFlashdata("poruka", "Loš format CVV koda");
            return redirect()->back()->withInput();
        }
        $time=new Time("now", "Europe/Belgrade");
        $godina=$time->getYear();
        $mesec=$time->getMonth();
        if($this->request->getVar("godina")==$godina && $this->request->getVar("mesec")<$mesec){
            $this->session->setFlashdata("poruka", "Vaša kartica je istekla");
            return redirect()->back()->withInput();
        }
        $korisnikModel=new KorisnikModel();
        $citalacModel=new CitalacModel();
        $db->transStart();
        $korisnikModel->update($this->session->get("korisnik")->IdKor,[
            'Ime'=>$this->request->getVar('ime'),
            'Prezime'=>$this->request->getVar('prezime'),
            'email'=>$this->request->getVar('email')
        ]);
        $citalacModel->update($this->session->get("korisnik")->IdKor,[
            'BrojKartice'=>$this->request->getVar('broj'),
            'MesecIsteka'=>$this->request->getVar('mesec'),
            'GodinaIsteka'=>$this->request->getVar('godina'),
            'CVV'=>$this->request->getVar('cvv')
        ]);
        $db->transComplete();
        $this->session->setFlashdata("boja", "bela");
        $this->session->setFlashdata("poruka", "Uspešno promenjeni podaci");
        return redirect()->back();
    }

    protected function getStatus() {
        return "Čitalac";
    }
}

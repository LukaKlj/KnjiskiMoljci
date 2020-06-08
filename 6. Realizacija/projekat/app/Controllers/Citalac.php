<?php namespace App\Controllers;

use App\Models\KorisnikModel;
use App\Models\CitalacModel;
use CodeIgniter\I18n\Time;

/*Citalac kontroler
 * koristi se za mogucnosti svojstvene samo citaocu
 * Autor: Marija Miletic
 */

class Citalac extends Korisnik{
    //Override
    protected function getController() {
        return "Citalac";
    }
    
    //prikazuje stranu za promenu podataka, citalac ima vise podataka i zbog toga se radi override metode iz klase korisnik
    public function promenaPodataka(){
        $citalacModel=new CitalacModel();
        $citalac=$citalacModel->find($this->session->get('korisnik')->IdKor);
        $poruka=$this->session->getFlashdata("poruka");
        $time=new Time("now", "Europe/Belgrade");
        $godina=$time->getYear();
        $this->prikaz("promenaPodatakaCitalac", ["akcija"=>"podaci", "poruka"=>$poruka,
            "godina"=>$godina, "citalac"=>$citalac]);
    }
    
    //logika promene podataka za citaoce, poziva se AJAXom
    public function noviPodaci() {
        $db=db_connect();
        if(!$this->validate(['ime'=>'required', 'prezime'=>'required', 'email'=>'required',
            'broj'=>'required', 'cvv'=>'required'])){
            echo "Sva polja moraju biti popunjena";
            return;
        }
        if(!$this->validate(['email'=>'valid_email'])){
            echo "Loš format e-mail adrese";
            return;
        }
        $tipKartice=$this->request->getVar("CreditCards");
        if(!$this->validate(['broj'=>"valid_cc_number[$tipKartice]"])){
            echo "Broj kreditne kartice nije validan";
            return;
        }
        if(!$this->validate(['cvv'=>'regex_match[/^[0-9]{3,4}$/]'])){
            echo "Loš format CVV koda";
            return;
        }
        $time=new Time("now", "Europe/Belgrade");
        $godina=$time->getYear();
        $mesec=$time->getMonth();
        if($this->request->getVar("godina")==$godina && $this->request->getVar("mesec")<$mesec){
            echo "Vaša kartica je istekla";
            return;
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
            'VrstaKartice'=>$this->request->getVar('CreditCards'),
            'BrojKartice'=>$this->request->getVar('broj'),
            'MesecIsteka'=>$this->request->getVar('mesec'),
            'GodinaIsteka'=>$this->request->getVar('godina'),
            'CVV'=>$this->request->getVar('cvv')
        ]);
        $korisnik=$korisnikModel->find($this->session->get('korisnik')->IdKor);
        $db->transComplete();
        $this->session->set('korisnik', $korisnik);
        echo "Uspešno promenjeni podaci";
    }

    //Override
    protected function getStatus() {
        return "Čitalac";
    }
}

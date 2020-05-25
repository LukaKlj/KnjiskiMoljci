<?php namespace App\Controllers;

use \App\Models\KorisnikModel;
use \App\Models\CitalacModel;
use \App\Models\PisacModel;
use \App\Models\RecenzentModel;
use \App\Models\AdministatorModel;
use CodeIgniter\I18n\Time;

class Gost extends BaseController {
    protected function prikaz($page, $data) {
        $data['controller'] = 'Gost';
        echo view('sabloni/gostHeader', $data);
        echo view("stranice/$page", $data);
        echo view('sabloni/footer');
    }
    
    public function index() {
        $data = [];
        $data['akcija'] = 'prijava';
        $data['poruka']=$this->session->getFlashdata('poruka');
        $data['boja']=$this->session->getFlashdata('boja');
        $this->prikaz('prijavljivanje', $data);
    }
    
    public function prijava() {
        if(!$this->validate(['korime'=>'required', 'sifra'=>'required'])){
            $this->session->setFlashdata('poruka', 'Sva polja moraju biti popunjena');
            return redirect()->back()->withInput();
        } 

        $korModel = new KorisnikModel();
        $kor=$korModel->where('username', $this->request->getVar('korime'))->first();

        if ($kor == null) {
            $this->session->setFlashdata('poruka', 'Neispravno korisničko ime');
            return redirect()->back()->withInput();
        }
        if ($kor->password != $this->request->getVar('sifra')) {
            $this->session->setFlashdata('poruka', 'Pogrešna lozinka');
            return redirect()->back()->withInput();
        }
        $status=$korModel->dohvatiStatus($kor->IdKor);
        
        $this->session->set('korisnik', $kor);
        return redirect()->to(site_url($status));
    }

    public function registrujSe($poruka = null) {
        $data = [];
        $data['akcija'] = 'registracija';
        $data['poruka'] = $this->session->getFlashdata('poruka');
        $data['boja'] = $this->session->getFlashdata('boja');
        $time=new Time("now", "Europe/Belgrade");
        $data['godina']=$time->getYear();
        $this->prikaz('registracija', $data);
    }

    public function registracija() {
        $db= db_connect();
        $korModel = new KorisnikModel();
        $citModel = new CitalacModel(); 
        //da li su sva polja popunjena
        if (!$this->validate([
                    'ime' => 'required',
                    'prezime' => 'required',
                    'username' => 'required',
                    'password' => 'required',
                    'confirmpass' => 'required',
                    'email' => 'required',
                    'date' => 'required',
                    'brojKartice' => 'required',
                    'cvv' => 'required'
                ])) {
            $this->session->setFlashdata("poruka", "Sva polja moraju biti popunjena");
            return redirect()->back()->withInput();
        }
        //da li je username jedinstven
        if(!$this->validate(['username'=>'is_unique[Korisnik.username]'])){
            $this->session->setFlashdata("poruka", "Korisnicko ime vec postoji");
            return redirect()->back()->withInput();
        }
        //da li je lozinka dovoljno duga
        if(!$this->validate(['password'=>'min_length[8]'])){
            $this->session->setFlashdata("poruka", "Lozinka se mora sastojati od bar 8 karaktera");
            return redirect()->back()->withInput();
        }
        //da li potvrda odgovara lozinci
        if(!$this->validate(['confirmpass'=>'matches[password]'])){
            $this->session->setFlashdata("poruka", "Potvrda stare lozinke ne odgovara staroj lozinci");
            return redirect()->back()->withInput();
        }
        //da li je email dobrog formata
        if(!$this->validate(['email'=>'valid_email'])){
            $this->session->setFlashdata("poruka", "Loš format e-mail adrese");
            return redirect()->back()->withInput();
        }
        //provera datuma rodjenja
        $unetDatum=Time::createFromFormat("Y-m-d", $this->request->getVar('date'), 'Europe/Belgrade');
        $sadasnjiDatum=new Time('now', 'Europe/Belgrade');
        $razlika=$unetDatum->difference($sadasnjiDatum);
        if($unetDatum->isAfter($sadasnjiDatum) || $razlika->getYears()>122){
            $this->session->setFlashdata("poruka", "Nemoguć datum rođenja");
            return redirect()->back()->withInput();
        }
        //provera podataka vezanih za karticu
        $tipKartice=$this->request->getVar("CreditCards");
        if(!$this->validate(['brojKartice'=>"valid_cc_number[$tipKartice]"])){
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
        $db->transStart();
        $korModel->insert([
            'Ime' => $this->request->getVar('ime'),
            'Prezime' => $this->request->getVar('prezime'),
            'username' => $this->request->getVar('username'),
            'password' => $this->request->getVar('password'),
            'email' => $this->request->getVar('email'),
            'Pol' => $this->request->getVar('pol'),
            'DatumRodjenja' => $this->request->getVar('date')
        ]);
        $citModel->insert([
            'VrstaKartice' => $this->request->getVar('CreditCards'),
            'BrojKartice' => $this->request->getVar('brojKartice'),
            'MesecIsteka' => $this->request->getVar('mesec'),
            'GodinaIsteka' => $this->request->getVar('godina'),
            'CVV' => $this->request->getVar('cvv'),
            'IdKor' => $korModel->getInsertID()
        ]);
        $db->transComplete();

        $korisnik=$korModel->find($korModel->getInsertID());
        $this->session->set('korisnik', $korisnik);
        
        return redirect()->to(site_url("/Citalac"));
    }
}

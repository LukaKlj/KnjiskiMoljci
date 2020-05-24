<?php namespace App\Controllers;

use \App\Models\KorisnikModel;
use \App\Models\CitalacModel;
use \App\Models\PisacModel;
use \App\Models\RecenzentModel;
use \App\Models\AdministatorModel;

class Gost extends BaseController {

    public function index() {
        $data = [];
        $data['akcija'] = 'prijava';
        //$data['poruka']=$poruka;
        $this->prikaz('prijavljivanje.php', $data);
    }
    
    protected function prikaz($page, $data) {
        $data['controller'] = 'Gost';
        echo view('sabloni/gostHeader.php', $data);
        echo view("stranice/$page", $data);
        echo view('sabloni/footer.php');
    }

    public function prijavise($poruka = null) {
        $data = [];
        $data['akcija'] = 'prijava';
        $data['poruka'] = $poruka;
        $this->prikaz('prijavljivanje.php', $data);
    }

    public function prijava() {
        /* if(!$this->validate(['korime'=>'required', 'sifra'=>'required'])){
          return $this->prikaz('prijavljivanje',
          ['errors'=>$this->validator->getErrors(),'akcija'=>'prijava']);
          } */

        $korModel = new KorisnikModel();
        $kor = $korModel->findByUserName($this->request->getVar('korime'));

        if ($kor == null) {
            return $this->prijavise("Neispravno korisnicko ime");
        }
        if ($kor->password != $this->request->getVar('sifra')) {
            return $this->prijavise("Pogresna lozinka");
        }

        // $temp=new Cita
        //if ()
        return redirect()->to(site_url('Citalac'));
    }

    public function registrujse($poruka = null) {
        $data = [];
        $data['akcija'] = 'registracija';
        $data['poruka'] = $poruka;
        $this->prikaz('registracija.php', $data);
    }

    public function registracija() {
        if (!$this->validate([
                    'ime' => 'required',
                    'prezime' => 'required',
                    'username' => 'required',
                    'password' => 'required',
                    'confirmpass' => 'required|matches[password]',
                    'email' => 'required|valid_email',
                    'date' => 'required',
                    'pol' => 'required',
                    'tipKartice' => 'required',
                    'brojKartice' => 'required|min_length[13]|max_length[19]',
                    'mesec' => 'required',
                    'godina' => 'required',
                    'cvv' => 'required|min_length[3]|max_length[4]'
                ])) {
            return $this->prikaz('registracija',
                            ['errors' => $this->validator->getErrors(), 'akcija' => 'registracija']);
        }
        $korModel = new KorisnikModel();
        $korModel->insert([
            'Ime' => $this->request->getVar('ime'),
            'Prezime' => $this->request->getVar('prezime'),
            'username' => $this->request->getVar('username'),
            'password' => $this->request->getVar('password'),
            'email' => $this->request->getVar('email'),
            'Pol' => $this->request->getVar('pol'),
            'DatumRodjenja' => $this->request->getVar('date'),
            'idKor' => '54'
        ]);
        return $this->prijavise("assdasa lozinka");
    }
}

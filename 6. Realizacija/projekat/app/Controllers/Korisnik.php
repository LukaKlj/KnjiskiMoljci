<?php namespace App\Controllers;

abstract class Korisnik extends BaseController{
    protected function prikaz($name, $data){
        echo view('sabloni/header', $data);
        echo view("stranice/$name", $data);
        echo view('sabloni/footer');
    }
    
    public function index(){
        $this->prikaz("pocetna", ["status"=>$this->getStatus(), "controller"=>$this->getController(), "akcija"=>"pocetna"]);
    }
    
    public function objavaTeksta(){
        $this->prikaz("objavaTeksta", ["status"=>$this->getStatus(), "controller"=>$this->getController(), "akcija"=>"objava"]);
    }
    
    public function promenaPodataka(){
        $this->prikaz("promenaPodataka", ["status"=>$this->getStatus(), "controller"=>$this->getController(), "akcija"=>"podaci"]);
    }
    
    public function promenaLozinke(){
        $this->prikaz("promenaLozinke", ["status"=>$this->getStatus(), "controller"=>$this->getController(), "akcija"=>"lozinka"]);
    }
    
    abstract protected function getStatus();
    abstract protected function getController();
}


<?php namespace App\Controllers;

class Recenzent extends Korisnik{
    protected function getController() {
        return "Recenzent";
    }

    protected function getStatus() {
        return "Recenzent";
    }
    
    public function recenziranje(){
        $tekstModel=new TekstModel();
        $tektovi=$tekstModel->sivZaRecenziranje();
        $this->prikaz("recenziranje", ["akcija"=>"recenziranje"]);
    }
}
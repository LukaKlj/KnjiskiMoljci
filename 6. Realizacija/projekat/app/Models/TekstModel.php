<?php namespace App\Models;

use CodeIgniter\Model;

class TekstModel extends Model{
    protected $table      = 'tekst';
    protected $primaryKey = 'IdTeksta';

    protected $returnType     = 'object';

    protected $allowedFields = ['Naziv', 'Odobren', 'Tekst', 'IdKor', 'IdObl', 'Datum', 'Vreme'];
    
    public function najveciID(){
        $row=$this->selectMax("IdTeksta", "maxid")->get()->getRow();
        $maxId=$row->maxid;
        return $maxId;
    }
    
    public function sviZaRecenziranje(){
        $idkor=$this->session->get("korisnik")->IdKor;
        $oblastModel=new OblastModel();
    }
}


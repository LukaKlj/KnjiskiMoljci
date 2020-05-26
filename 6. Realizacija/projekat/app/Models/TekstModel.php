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
    
    public function sviZaRecenziranje($idkor){
        $recenzentModel=new RecenzentModel();
        $idobl=$recenzentModel->find($idkor)->IdObl;
        $tekstovi=$this->where("IdObl", $idobl)->where("Odobren", 0)->where("IdKor !=", $idkor)->findAll();
        return $tekstovi;
    }
    
    public function tekstoviKorisnika($idkor){
        return $this->where("IdKor", $idkor)->where("Odobren", 1)->findAll();
    }
}


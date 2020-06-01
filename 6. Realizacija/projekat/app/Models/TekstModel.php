<?php namespace App\Models;

use CodeIgniter\Model;

/*Model za tabelu Tekst*/

class TekstModel extends Model{
    protected $table      = 'tekst';
    protected $primaryKey = 'IdTeksta';

    protected $returnType     = 'object';

    protected $allowedFields = ['Naziv', 'Odobren', 'Tekst', 'IdKor', 'IdObl', 'Datum', 'Vreme'];
    
    //u tabeli tekst pronalazi najveci id
    public function najveciID(){
        $row=$this->selectMax("IdTeksta", "maxid")->get()->getRow();
        $maxId=$row->maxid;
        return $maxId;
    }
    
    //prima id recenzenta koji je ulogovan i vraca niz tekstova koje on moze da recenzira
    public function sviZaRecenziranje($idkor){
        $recenzentModel=new RecenzentModel();
        $idobl=$recenzentModel->find($idkor)->IdObl;
        $tekstovi=$this->where("IdObl", $idobl)->where("Odobren", 0)->where("IdKor !=", $idkor)->findAll();
        return $tekstovi;
    }
    
    //vraca sve odobrene tekstove odredjenog korisnika
    public function tekstoviKorisnika($idkor){
        return $this->where("IdKor", $idkor)->where("Odobren", 1)->findAll();
    }
}


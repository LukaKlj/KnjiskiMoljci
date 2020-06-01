<?php namespace App\Models;

use CodeIgniter\Model;

/*Model za tabelu Zahtev*/

class ZahtevModel extends Model{
    protected $table      = 'zahtev';
    protected $primaryKey = 'IdZah';

    protected $returnType     = 'object';

    protected $allowedFields = ['Datum', 'Vreme', 'IdKor', 'IdObl'];
    
    //proverava da li je zadati korisnik vec poslao zahtev za zadatu oblast
    public function nePostojiNeodobren($idkor, $idobl){
        $zahtevi=$this->where('IdKor', $idkor)->where('IdObl', $idobl)->findAll();
        return (count($zahtevi)==0);
    }
}


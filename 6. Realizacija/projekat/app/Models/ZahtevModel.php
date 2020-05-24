<?php namespace App\Models;

use CodeIgniter\Model;

class ZahtevModel extends Model{
    protected $table      = 'zahtev';
    protected $primaryKey = 'IdZah';

    protected $returnType     = 'object';

    protected $allowedFields = ['Datum', 'Vreme', 'IdKor', 'IdObl'];
    
    public function nePostojiNeodobren($idkor, $idobl){
        $zahtevi=$this->where('IdKor', $idkor)->where('IdObl', $idobl)->findAll();
        return (count($zahtevi)==0);
    }
}


<?php namespace App\Models;

use CodeIgniter\Model;

class PisacModel extends Model{
    protected $table      = 'pisac';
    protected $primaryKey = 'IdKor';

    protected $returnType     = 'object';

    protected $allowedFields = ['IdKor', 'PocetakKarijere'];
    
    public function pisciZaZahteve($zahtevi){
        $pisci=[];
        foreach($zahtevi as $zahtev){
            $pisci[]=$this->find($zahtev->IdKor);
        }
        return $pisci;
    }
}



<?php namespace App\Models;

use CodeIgniter\Model;

/*Model za tabelu Pisac*/

class PisacModel extends Model{
    protected $table      = 'pisac';
    protected $primaryKey = 'IdKor';

    protected $returnType     = 'object';

    protected $allowedFields = ['IdKor', 'PocetakKarijere'];
    
    //prima niz zahteva a vraca niz pisaca koji su poslali te zahteve
    public function pisciZaZahteve($zahtevi){
        $pisci=[];
        foreach($zahtevi as $zahtev){
            $pisci[]=$this->find($zahtev->IdKor);
        }
        return $pisci;
    }
}



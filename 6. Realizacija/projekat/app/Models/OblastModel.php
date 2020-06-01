<?php namespace App\Models;

use CodeIgniter\Model;

/*Model za tabelu Oblast*/

class OblastModel extends Model{
    protected $table      = 'oblast';
    protected $primaryKey = 'IdObl';

    protected $returnType     = 'object';

    protected $allowedFields = ['BrojRecenzenata'];
    
    //prima niz tekstova i vraca niz u kome su kljucevi IdTeksta, a vrednosti oblasti kojima ti tekstovi pripadaju
    public function oblastiZaTekstove($tekstovi){
        $oblasti=[];
        foreach($tekstovi as $tekst){
            $oblasti[$tekst->IdTeksta]=$this->find($tekst->IdObl);
        }
        return $oblasti;
    }
}


<?php namespace App\Models;

use CodeIgniter\Model;

class OblastModel extends Model{
    protected $table      = 'oblast';
    protected $primaryKey = 'IdObl';

    protected $returnType     = 'object';

    protected $allowedFields = ['BrojRecenzenata'];
    
    public function oblastiZaTekstove($tekstovi){
        $oblasti=[];
        foreach($tekstovi as $tekst){
            $oblasti[$tekst->IdTeksta]=$this->find($tekst->IdObl);
        }
        return $oblasti;
    }
}


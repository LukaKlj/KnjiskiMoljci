<?php namespace App\Models;

use CodeIgniter\Model;

class KorisnikModel extends Model{
    protected $table      = 'korisnik';
    protected $primaryKey = 'IdKor';

    protected $returnType     = 'object';

    protected $allowedFields = ['Ime', 'Prezime', 'email', 'username', 'password', 'DatumRodjenja', 'Pol'];
    
    public function korisniciZaTekstove($tekstovi){
        $korisnici=[];
        foreach($tekstovi as $tekst){
            $korisnici[$tekst->IdTeksta]=$this->find($tekst->IdKor);
        }
        return $korisnici;
    }
    
    public function dohvatiStatus($idkor){
        $citalacModel=new CitalacModel();
        $pisacModel=new PisacModel();
        $recenzentModel=new RecenzentModel();
        $adminModel=new AdminModel();
        $citalac=$citalacModel->find($idkor);
        if($citalac!=null){
            return 'Citalac';
        }
        $pisac=$pisacModel->find($idkor);
        if($pisac!=null){
            return 'Pisac';
        }
        $recenzent=$recenzentModel->find($idkor);
        if($recenzent!=null){
            return 'Recenzent';
        }
        $admin=$adminModel->find($idkor);
        if($admin!=null){
            return 'Administrator';
        }
        return null;
    }
}



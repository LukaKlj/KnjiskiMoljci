<?php namespace App\Models;

use CodeIgniter\Model;

/*Model za tabelu Korisnik*/

class KorisnikModel extends Model{
    protected $table      = 'korisnik';
    protected $primaryKey = 'IdKor';

    protected $returnType     = 'object';

    protected $allowedFields = ['Ime', 'Prezime', 'email', 'username', 'password', 'DatumRodjenja', 'Pol'];
    
    //prima niz tekstova i vraca niz u kome su kljucevi IdTeksta, a vrednosti korisnici koji su napisali te tekstove
    public function korisniciZaTekstove($tekstovi){
        $korisnici=[];
        foreach($tekstovi as $tekst){
            $korisnici[$tekst->IdTeksta]=$this->find($tekst->IdKor);
        }
        return $korisnici;
    }
    
    //prima niz komentara i vraca niz u kome su kljucevi IdKom, a vrednosti korisnici koji su napisali te komentare
    public function korisniciZaKomentare($komentari){
        $korisnici=[];
        foreach($komentari as $komentar){
            $korisnici[$komentar->IdKom]=$this->find($komentar->IdKor);
        }
        return $korisnici;
    }
    
    //vraca string koji govori u kom statusu je korisnik ciji id je zadat
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
            return 'Admin';
        }
        return null;
    }
}



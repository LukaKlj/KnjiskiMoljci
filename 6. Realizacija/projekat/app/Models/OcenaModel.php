<?php namespace App\Models;

use CodeIgniter\Model;

/*Model za tabelu Ocena*/

class OcenaModel extends Model{
    protected $table      = 'ocena';
    protected $primaryKey = 'IdKor, IdTeksta';

    protected $returnType     = 'object';

    protected $allowedFields = ['IdKor', 'IdTeksta', 'Ocena'];
    
    //vraca niz koji sadrzi informacije o korisnicima i njihovim sevukupnim prosecnim ocenama i to sortiran po prosecnim ocenama
    public function prosecneOceneKorisnika($pisci=null, $recenzenti=null, $admini=null){
        $korisnikModel=new KorisnikModel();
        $tekstModel=new TekstModel();
        $prosecneOcene=[];
        //spojimo nizove u jedan
        $korisnici=[];
        if($pisci!=null){
            foreach ($pisci as $pisac){
                $korisnici[]=$pisac;
            }
        }
        if($recenzenti!=null){
            foreach ($recenzenti as $recenzent){
                $korisnici[]=$recenzent;
            }
        }
        if($admini!=null){
            foreach ($admini as $admin){
                $korisnici[]=$admin;
            }
        }
        //dobijemo prosecnu ocenu
        foreach($korisnici as $korisnik){
            $tekstovi=$tekstModel->tekstoviKorisnika($korisnik->IdKor);
            $prosek=0;
            $brojac=0;
            foreach($tekstovi as $tekst){
                if($tekst->Odobren){
                    $ocene=$this->where("IdTeksta", $tekst->IdTeksta)->findAll();
                    foreach($ocene as $ocena){
                        $prosek+=$ocena->Ocena;
                        $brojac++;
                    }
                }
            }
            $korisnikUBazi=$korisnikModel->find($korisnik->IdKor);
            $username=$korisnikUBazi->username;
            $brojRecenzija=null;
            if(isset($korisnik->BrojZavrsenihRecenzija)){
                $brojRecenzija=$korisnik->BrojZavrsenihRecenzija;
            }
            if($brojac==0){
                $ocena="Nema ocena";
            }
            else{
                $ocena=$prosek/$brojac;
            }
            $prosecneOcene[]=[
                "ocena"=>$ocena,
                "username"=>$username,
                "id"=>$korisnik->IdKor,
                "brojRecenzija"=>$brojRecenzija
            ];
        }
        //sortiraj po prosecnoj oceni
        $sortiraneProsecneOcene = $this->quickSort($prosecneOcene);
        
        return $sortiraneProsecneOcene;
    }
    
    //sluzi za sortiranje po prosecnim ocenama
    private function quickSort($arr){
        if(count($arr) <= 1){
            return $arr;
        }
        else{
            $pivot = $arr[0];
            $nema=false;
            if($pivot['ocena']=="Nema ocene"){
                $nema=true;
            }
            $left = array();
            $right = array();
            for($i = 1; $i < count($arr); $i++)
            {
                if((!$nema) && ($arr[$i]['ocena']=="Nema ocena" || $arr[$i]['ocena'] < $pivot['ocena'])){
                    $right[] = $arr[$i];
                }
                else{
                    $left[] = $arr[$i];
                }
            }
            return array_merge($this->quickSort($left), array($pivot), $this->quickSort($right));
        }
    }
    
    //prima niz tekstova i vraca niz u kojem su kljucevi IdTeksta a vrednosti njihove proscene ocene
    public function prosecneOcene($tekstovi){
        $prosecneOcene=[];
        foreach($tekstovi as $tekst){
            $zbir=0;
            $brojac=0;
            if($tekst->Odobren){
                $ocene=$this->where("IdTeksta", $tekst->IdTeksta)->findAll();
                foreach($ocene as $ocena){
                    $zbir+=$ocena->Ocena;
                    $brojac++;
                }
            }
            if($brojac==0){
                $prosecneOcene[$tekst->IdTeksta]="Nema ocena";
            }
            else{
                $prosecneOcene[$tekst->IdTeksta]=$zbir/$brojac;
            }
        }
        return $prosecneOcene;
    }
}


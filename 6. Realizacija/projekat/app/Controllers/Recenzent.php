<?php namespace App\Controllers;

use App\Models\TekstModel;
use App\Models\KorisnikModel;
use App\Models\OblastModel;
use App\Models\CitalacModel;
use App\Models\RecenzijaModel;
use App\Models\RecenzentModel;
use App\Models\PisacModel;
use CodeIgniter\I18n\Time;

/*Recenzent kontroler
 * sluzi za mogucnosti svojstvene recenzentu
 * Autor: Luka Kljajic
 */

class Recenzent extends Korisnik{
    //Override
    protected function getController() {
        return "Recenzent";
    }

    //Override
    protected function getStatus() {
        return "Recenzent";
    }
    
    //prikazuje sve neodobrene tekstove iz oblasti za koju je prijavljeni recenzent zaduzen sem tekstova tog recenzenta
    public function recenziranje(){
        $tekstModel=new TekstModel();
        $korisnikModel=new KorisnikModel();
        $oblastModel=new OblastModel();
        $tekstovi=$tekstModel->sviZaRecenziranje($this->session->get("korisnik")->IdKor);
        $korisnici=$korisnikModel->korisniciZaTekstove($tekstovi);
        $oblasti=$oblastModel->oblastiZaTekstove($tekstovi);
        $poruka=$this->session->getFlashdata("poruka");
        $this->prikaz("recenziranje", ["akcija"=>"recenziranje", "tekstovi"=>$tekstovi, "korisnici"=>$korisnici, "oblasti"=>$oblasti, 
            "poruka"=>$poruka]);
    }
    
    //odobrava zadati tekst, poziva se AJAXom
    public function odobri($idteksta){
        $db=db_connect();
        $tekstModel=new TekstModel();
        $citalacModel=new CitalacModel();
        $recenzijaModel=new RecenzijaModel();
        $recenzentModel=new RecenzentModel();
        $pisacModel=new PisacModel();
        $time=new Time('now', 'Europe/Belgrade');
        $db->transStart();
        $tekst=$tekstModel->find($idteksta);
        if($tekst!=null && $tekst->Odobren==0){
            $citalac=$citalacModel->find($tekst->IdKor);
            $tekstModel->update($idteksta, ["Odobren"=>1]);
            $recenzijaModel->save([
                "IdTeksta"=>$tekst->IdTeksta,
                "IdKor"=>$this->session->get("korisnik")->IdKor
            ]);
            $recenzent=$recenzentModel->find($this->session->get("korisnik")->IdKor);
            $recenzentModel->update($this->session->get("korisnik")->IdKor, [
                "BrojZavrsenihRecenzija"=>$recenzent->BrojZavrsenihRecenzija+1
            ]);
            if($citalac!=null){
                $pisacModel->insert([
                    "IdKor"=>$citalac->IdKor,
                    "PocetakKarijere"=>$time->toDateString()
                ]);
                $citalacModel->delete($citalac->IdKor);
            }
        }
        $db->transComplete();
    }
    
    //odbacuje zadati tekst. poziva se AJAXom
    public function odbaci($idteksta){
        $db=db_connect();
        $tekstModel=new TekstModel();
        $db->transStart();
        $tekst=$tekstModel->find($idteksta);
        if($tekst!=null && $tekst->Odobren==0){
            $name=$tekst->Tekst;
            $filepath=FCPATH."texts\\".$name;
            unlink($filepath);
            $tekstModel->delete($idteksta);
        }
        $db->transComplete();
    }
    
    //osvezava stranicu sa tekstovima na neki vremenski period, poziva se AJAXom
    public function osveziTekstove(){
        $tekstModel=new TekstModel();
        $korisnikModel=new KorisnikModel();
        $oblastModel=new OblastModel();
        $tekstovi=$tekstModel->sviZaRecenziranje($this->session->get("korisnik")->IdKor);
        $korisnici=$korisnikModel->korisniciZaTekstove($tekstovi);
        $oblasti=$oblastModel->oblastiZaTekstove($tekstovi);
        $i=0;
        foreach($tekstovi as $tekst){
            echo "
            <tr>
                <td><a href='../texts/$tekst->Tekst'>$tekst->Naziv</a></td>
                <td><a class='pointer-link korisnik' data-id='{$korisnici[$tekst->IdTeksta]->IdKor}'>{$korisnici[$tekst->IdTeksta]->username}</a></td>
                <td>{$oblasti[$tekst->IdTeksta]->Naziv}</td>
                <td>{$tekst->Datum} {$tekst->Vreme}</td>
                <td><button type='button' class='btn btn-sm btn-success odobri' data-index={$i}>Odobri</button></td>
                <td><button type='button' class='btn btn-sm btn-danger odbaci' data-index={$i}>Odbaci</button></td>
            </tr>
            <script>parametri[{$i}]={$tekst->IdTeksta};</script>";
            $i++;
        }
    }
}
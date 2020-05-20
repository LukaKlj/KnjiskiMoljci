<?php namespace App\Models;

use CodeIgniter\Model;

class KorisnikModel extends Model{
    protected $table      = 'korisnik';
    protected $primaryKey = 'IdKor';

    protected $returnType     = 'object';

    protected $allowedFields = ['Ime', 'Prezime', 'email', 'username', 'password', 'DatumRodjenja', 'Pol'];
}



<?php namespace App\Models;

use CodeIgniter\Model;

class KomentarModel extends Model{
    protected $table      = 'komentar';
    protected $primaryKey = 'IdKom';

    protected $returnType     = 'object';

    protected $allowedFields = ['Tekst', 'Datum', 'Vreme', 'IdKor', 'IdTeksta'];
}
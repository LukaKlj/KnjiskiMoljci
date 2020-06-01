<?php namespace App\Models;

use CodeIgniter\Model;

/*Model za tabelu Recenzija*/

class RecenzijaModel extends Model{
    protected $table      = 'recenzija';
    protected $primaryKey = 'IdTeksta, IdKor';

    protected $returnType     = 'object';

    protected $allowedFields = ['IdTeksta', 'IdKor'];
}


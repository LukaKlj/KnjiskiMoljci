<?php namespace App\Models;

use CodeIgniter\Model;

/*Model za tabelu Recenzent*/

class RecenzentModel extends Model{
    protected $table      = 'recenzent';
    protected $primaryKey = 'IdKor';

    protected $returnType     = 'object';

    protected $allowedFields = ['IdKor', 'BrojZavrsenihRecenzija', 'IdObl'];
}



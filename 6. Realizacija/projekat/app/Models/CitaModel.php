<?php namespace App\Models;

use CodeIgniter\Model;

/*Model za tabelu Cita*/

class CitaModel extends Model{
    protected $table      = 'cita';
    protected $primaryKey = 'IdTeksta, IdKor';

    protected $returnType     = 'object';

    protected $allowedFields = ['Strana', 'IdTeksta', 'IdKor'];
}



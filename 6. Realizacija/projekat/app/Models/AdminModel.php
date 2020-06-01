<?php namespace App\Models;

use CodeIgniter\Model;

/*Model za tabelu Administrator*/

class AdminModel extends Model{
    protected $table      = 'administrator';
    protected $primaryKey = 'IdKor';

    protected $returnType     = 'object';

    protected $allowedFields = [];
}



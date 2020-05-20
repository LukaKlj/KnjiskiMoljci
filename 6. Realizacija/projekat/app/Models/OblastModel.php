<?php namespace App\Models;

use CodeIgniter\Model;

class OblastModel extends Model{
    protected $table      = 'oblast';
    protected $primaryKey = 'IdObl';

    protected $returnType     = 'object';

    protected $allowedFields = ['BrojRecenzenata'];
}


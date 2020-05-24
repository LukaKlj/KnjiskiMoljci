<?php namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model{
    protected $table      = 'administrator';
    protected $primaryKey = 'IdKor';

    protected $returnType     = 'object';

    protected $allowedFields = [];
}



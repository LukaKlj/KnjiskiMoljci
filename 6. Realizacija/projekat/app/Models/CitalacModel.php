<?php namespace App\Models;

use CodeIgniter\Model;

class CitalacModel extends Model{
    protected $table      = 'citalac';
    protected $primaryKey = 'IdKor';

    protected $returnType     = 'object';

    protected $allowedFields = ['IdKor', 'VrstaKartice', 'BrojKartice', 'MesecIsteka', 'Godinaisteka', 'CVV'];
}



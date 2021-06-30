<?php namespace App\Models;
  
use CodeIgniter\Model;
  
class UsuarioModel extends Model
{
    protected $table = 'usuario';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nome','user', 'passwd'];
    protected $validationRules    = [
        'nome'     => 'required',
        'user'         => 'required',
        'passwd'         => 'required'       
    ];
}
 
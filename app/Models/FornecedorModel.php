<?php namespace App\Models;
  
use CodeIgniter\Model;
  
class FornecedorModel extends Model
{
    protected $table = 'fornecedor';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nome', 'login', 'senha'];
    protected $validationRules    = [
        'nome'          => 'required|',
        'login'         => 'required|',
        'senha'         => 'required|'       
    ];
}
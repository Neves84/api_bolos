<?php namespace App\Models;
  
use CodeIgniter\Model;
  
class ClienteModel extends Model
{
    protected $table = 'cliente';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nome', 'telefone', 'endereco', 'email', 'cpf' ,'login' ,'senha'];
    protected $validationRules    = [
        'nome'             => 'required|',
        'telefone'         => 'required|',
        'endereco'         => 'required|',
        'email'            => 'required|',
        'cpf'              => 'required|',
        'login'            => 'required|',
        'senha'            => 'required|'       
    ];
}
<?php namespace App\Models;
  
use CodeIgniter\Model;
  
class ProdutoModel extends Model
{
    protected $table = 'produto';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nome','foto', 'preco','fk_fornecedor_id'];
    protected $validationRules    = [
        
        'nome'         => 'required|',
        'foto'         => 'required|',
        'preco'         => 'required|',
        'fk_fornecedor_id'         => 'required|' 
              
    ];
}
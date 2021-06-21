<?php namespace App\Models;
  
use CodeIgniter\Model;
  
class PedidoModel extends Model
{
    protected $table = 'pedido';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nome_bolo', 'forma_pagamento', 'data_pedido', 'fk_cliente_id'];
    protected $validationRules    = [
        'nome_bolo'     => 'required|',
        'forma_pagamento' => 'required|',
        'data_pedido' => 'required|',
        'fk_cliente_id'    => 'required|'   
    ];
}
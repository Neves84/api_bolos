<?php

namespace App\Controllers;

use Firebase\JWT\JWT;
use Exception;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ClienteModel;

class Clientes extends ResourceController
{
    use ResponseTrait;
    private function getKey()
    {
        return "minha_chave_super_secreta654987lkhj231kuh";
    }

    
    // lista todos Clientes
    public function index()
    {
        try {
            $token = $this->request->getHeader("Authorization")->getValue();
            $decoded = JWT::decode($token, $this->getKey(), array("HS256"));

            if ($decoded) {
                $model = new ClienteModel();
                $data = $model->findAll();
                return $this->respond($data);
            }
        } catch (Exception $ex) {
            return $this->failUnauthorized("Acesso negado! Exception: " . $ex);
        }
    }

    // lista um Cliente
    public function show($id = null)
    {
        $model = new ClienteModel();
        $data = $model->getWhere(['id' => $id])->getResult();

        if ($data) {
            return $this->respond($data);
        }

        return $this->failNotFound('Nenhum dado encontrado com id ' . $id);
    }

    // adiciona um Cliente
    public function create()
    {
        $model = new ClienteModel();
        $data = $this->request->getJSON();

        if ($model->insert($data)) {
            $response = [
                'status'   => 201,
                'error'    => null,
                'messages' => [
                    'success' => 'Dados salvos'
                ]
            ];
            return $this->respondCreated($response);
        }

        return $this->fail($model->errors());
    }

    // atualiza um Cliente
    public function update($id = null)
    {
        $model = new ClienteModel();
        $data = $this->request->getJSON();

        if ($model->update($id, $data)) {
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Dados atualizados'
                ]
            ];
            return $this->respond($response);
        };

        return $this->fail($model->errors());
    }

    // deleta um Cliente
    public function delete($id = null)
    {
        $model = new ClienteModel();
        $data = $model->find($id);

        if ($data) {
            $model->delete($id);
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Dados removidos'
                ]
            ];
            return $this->respondDeleted($response);
        }

        return $this->failNotFound('Nenhum dado encontrado com id ' . $id);
    }
}
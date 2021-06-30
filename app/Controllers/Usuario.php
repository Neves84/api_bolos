<?php



namespace App\Controllers;
use Firebase\JWT\JWT;
use Exception;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UsuarioModel;

class Usuario extends ResourceController
{
    use ResponseTrait;
    private function getKey()
    {
        return "minha_chave_super_secreta654987lkhj231kuh";
    }

    public function login()
    {
        $userModel = new UsuarioModel();

        $userdata = $userModel->where("user", $this->request->getVar("user"))->first();

        if (!empty($userdata)) {

            if ($this->request->getVar("passwd") == $userdata['passwd']) {

                $key = $this->getKey();

                $iat = time(); // retorna em timestamp
                $nbf = $iat + 1;
                $exp = $iat + 3600;

                $payload = array(
                    "iss" => "api_livro",
                    "aud" => "diversos_app",
                    "iat" => $iat, // issued at
                    "nbf" => $nbf, //not before in seconds
                    "exp" => $exp, // expire time in seconds
                    
                );

                $token = JWT::encode($payload, $key);

                $response = [
                    'status' => 200,
                    'error' => false,
                    'messages' => 'Usuário logado com sucesso',
                    'data' => [
                        'token' => $token
                    ]
                ];
                return $this->respondCreated($response);
            } else {

                $response = [
                    'status' => 500,
                    'error' => true,
                    'messages' => 'Login inválido',
                    'data' => []
                ];
                return $this->respondCreated($response);
            }
        } else {
            $response = [
                'status' => 500,
                'error' => true,
                'messages' => 'Login inválido',
                'data' => []
            ];
            return $this->respondCreated($response);
        }
    }
    // lista todos Usuarios
    public function index()
    {
        try {
            $token = $this->request->getHeader("Authorization")->getValue();
            $decoded = JWT::decode($token, $this->getKey(), array("HS256"));

            if ($decoded) {
                $model = new UsuarioModel();
                $data = $model->findAll();
                return $this->respond($data);
            }
        } catch (Exception $ex) {
            return $this->failUnauthorized("Acesso negado! Exception: " . $ex);
        }
    }

    // lista um Usuario 
    public function show($id = null)
    {
        $model = new UsuarioModel();
        $data = $model->getWhere(['id' => $id])->getResult();

        if ($data) {
            return $this->respond($data);
        }

        return $this->failNotFound('Nenhum dado encontrado com id ' . $id);
    }

    // adiciona um Usuario
    public function create()
    {
        $model = new UsuarioModel();
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

    // atualiza um Usuario
    public function update($id = null)
    {
        $model = new UsuarioModel();
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

    // deleta um Usuario
    public function delete($id = null)
    {
        $model = new UsuarioModel();
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

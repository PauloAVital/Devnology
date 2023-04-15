<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Exception;
use App\Models\ControleLOG_User;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    private $user;
    private $request;
    private $logUser;

    public function __construct()
    {
        $user = new User();
        $request = new Request();
        $logUser = new ControleLOG_User();

        $this->user = $user;
        $this->request = $request;
        $this->logUser = $logUser;
    }

    public function index()
    {
        try {

            if (!$this->user->find(auth()->user()->id)) {
                return response()->json(['error'=> 'Usuario não existe ! ALERTA !', 404]);
            } else {
                    $dataLogUser = [                            
                        'id_user_function' => auth()->user()->id,
                        'function' => 'get ALL',
                        'name' => 'Todos',
                        'email' => 'Todos',
                        'password' => 'Todos'
                    ];

                    $this->logUser->create($dataLogUser);
                    $data = User::all();
                      
                    return  response()->json([
                        "success" => true,
                        "id_commerce" => $data
                    ]);
            }
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "erros" => $e->getMessage(), 400
            ]);
        }
    }

   
    public function store(Request $request)
    {
        try {
            $dataUser =  $request->all();

            $retornoValida = $this->validarApi($dataUser);
    
            if ($retornoValida != '') {
                echo $retornoValida; 
            } else {

                if (!$this->user->find(auth()->user()->id)) {
                    return response()->json(['error'=> 'Usuario não existe ! ALERTA !', 404]);
                } else {
                    $dataLogUser = [                            
                        'id_user_function' => auth()->user()->id,
                        'function' => 'create',
                        'name' => $dataUser['name'],
                        'email' => $dataUser['email'],
                        'password' => bcrypt($dataUser['password'])
                    ];

                    $dataUser = [
                        'name' => $dataUser['name'],
                        'email' => $dataUser['email'],
                        'password' => bcrypt($dataUser['password'])
                    ];

                    $this->logUser->create($dataLogUser);
                    $data = $this->user->create($dataUser);

                    return  response()->json([
                        "success" => true,
                        "return" => $data
                    ]);
                }
            }
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "erros" => $e->getMessage(), 400
            ]);
        }
    }

    public function show($id)
    {
        try {
            if (!$data = $this->user->find($id)) {
                return response()->json(['error'=> 'Nada Encontrado', 404]);
            } else {
                if (!$this->user->find(auth()->user()->id)) {
                    return response()->json(['error'=> 'Usuario não existe ! ALERTA !', 404]);
                } else {
                    $dataLogUser = [                            
                        'id_user_function' => auth()->user()->id,
                        'function' => 'get - '.$id,
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'password' => $data['password']
                    ];    

                    $this->logUser->create($dataLogUser);                        
                    return  response()->json([
                        "success" => true,
                        "return" => $data
                    ]);
                }
            }
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "erros" => $e->getMessage(), 400
            ]);
        }
    }
   
    public function update(Request $request, $id)
    {
        try {
            if (!$dataUserUpdate = $this->user->find($id)) {
                return response()->json(['error'=> 'Nada Encontrado', 404]);
            } else {
               
                if (!$this->user->find(auth()->user()->id)) {
                    return response()->json(['error'=> 'Usuario não existe ! ALERTA !', 404]);
                } else {
                    $dataLogUser = [                            
                        'id_user_function' => auth()->user()->id,
                        'function' => 'update',
                        'name' => $dataUserUpdate['name'],
                        'email' => $dataUserUpdate['email'],
                        'password' => $dataUserUpdate['password']
                    ];
                    
                    $dataUser = array(
                        "name" => $request->name,
                        "email" => $request->email,
                        "password" => bcrypt($request->password)
                    );

                    $this->logUser->create($dataLogUser);
                    $dataUserUpdate->update($dataUser);
                    return  response()->json([
                        "success" => true,
                        "description" => 'Usuario '.$id.' alterado com Sucesso'
                    ]);
                }
            }
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "erros" => $e->getMessage(), 400
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            if (!$data = $this->user->find($id)){
                return response()->json(['error'=> 'Nada Encontrado', 404]);
            } else {
                if (!$this->user->find(auth()->user()->id)) {
                    return response()->json(['error'=> 'Usuario não existe ! ALERTA !', 404]);
                } else {
                    $dataLogUser = [                            
                        'id_user_function' => auth()->user()->id,
                        'function' => 'delete',
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'password' => $data['password']
                    ];
                    $this->logUser->create($dataLogUser);
                    $data->delete();
                    return  response()->json([
                        "success" => true,
                        "description" => 'Usuario '.$id.' Deletado com Sucesso'
                    ]);
                }                
            }
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "erros" => $e->getMessage(), 400
            ]);
        }
    }

    private function validarApi($dataForm, $id = null) {        

        try {
            $messages = [
                'name.required' => 'informe o nome',
                'email.required' => 'informe o email',
                'password.required' => 'informe o password'
            ];
    
            $rules = [
                'name' => 'required',
                'email' => 'required',
                'password' => 'required'
            ];
    
            $regras = ($id != null) ? $rules : $this->user->rules();

            $validator = Validator::make($dataForm, $regras, $messages);
    
            if ($validator->fails()) {
                return  response()->json([ 
                    "valida" => false,
                    "erros" => $validator->errors()
                ]);
            }
            return; 
        } catch (Exception $e) {
            return response()->json([
                "valida" => false,
                "erros" => $e->getMessage()
            ]);
        }      
    }
}

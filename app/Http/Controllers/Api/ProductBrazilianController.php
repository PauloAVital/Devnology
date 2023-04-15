<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Exception;
use App\Models\ControleLOG_ProductBrazilian;
use App\Models\ControleLOG_Shopping_Cart;
use App\Models\ControleProductBrazilian;
use Illuminate\Support\Facades\Validator;


class ProductBrazilianController extends Controller
{
    private $user;
    private $request;
    private $logProductBrazilian;
    private $logShoppingCart;
    private $productBrazilian;

    public function __construct()
    {
        $user = new User();
        $request = new Request();
        $logProductBrazilian = new ControleLOG_ProductBrazilian();
        $logShoppingCart = new ControleLOG_Shopping_Cart();
        $productBrazilian = new ControleProductBrazilian();

        $this->user = $user;
        $this->request = $request;
        $this->logProductBrazilian = $logProductBrazilian;
        $this->logShoppingCart = $logShoppingCart;
        $this->productBrazilian = $productBrazilian;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            if (!$this->user->find(auth()->user()->id)) {
                return response()->json(['error'=> 'Usuario não existe ! ALERTA !', 404]);
            } else {
                    $dataLogProductBraziliam = [                            
                        'id_user_function' => auth()->user()->id,
                        'function' => 'get ALL',
                        'id_shopping_cart' => 0,
                        'nome' => 'Todos',
                        'descricao' => 'Todos',
                        'categoria' => 'Todos',
                        'imagem' => 'Todos',
                        'preco' => 0,
                        'material' => 'Todos',
                        'departamento' => 'Todos'
                    ];

                    $this->logProductBrazilian->create($dataLogProductBraziliam);
                    $data = ControleProductBrazilian::all();
                      
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $dataProductBrazilian =  $request->all();

            $retornoValida = $this->validarApi($dataProductBrazilian);
    
            if ($retornoValida != '') {
                echo $retornoValida; 
            } else {

                if (!$this->user->find(auth()->user()->id)) {
                    return response()->json(['error'=> 'Usuario não existe ! ALERTA !', 404]);
                } else {
                    $dataLogProductBraziliam = [                            
                        'id_user_function' => auth()->user()->id,
                        'function' => 'get ALL',
                        'id_shopping_cart' => 0,
                        'nome' => 'Todos',
                        'descricao' => 'Todos',
                        'categoria' => 'Todos',
                        'imagem' => 'Todos',
                        'preco' => 0,
                        'material' => 'Todos',
                        'departamento' => 'Todos'
                    ];

                    $this->logProductBrazilian->create($dataLogProductBraziliam);

                    $data = $this->productBrazilian->create($dataProductBrazilian);

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            if (!$data = $this->productBrazilian->find($id)) {
                return response()->json(['error'=> 'Nada Encontrado', 404]);
            } else {
                if (!$this->user->find(auth()->user()->id)) {
                    return response()->json(['error'=> 'Usuario não existe ! ALERTA !', 404]);
                } else {
                    $dataLogProductBraziliam = [                            
                        'id_user_function' => auth()->user()->id,
                        'function' => 'get - '.$id,
                        'id_shopping_cart' => $data['id_shopping_cart'],
                        'nome' => $data['nome'],
                        'descricao' => $data['descricao'],
                        'categoria' => $data['categoria'],
                        'imagem' => $data['imagem'],
                        'preco' => $data['preco'],
                        'material' => $data['material'],
                        'departamento' => $data['departamento']
                    ];

                    $this->logProductBrazilian->create($dataLogProductBraziliam);                        
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            if (!$dataProductBrazilianUpdate = $this->productBrazilian->find($id)) {
                return response()->json(['error'=> 'Nada Encontrado', 404]);
            } else {
               
                if (!$this->user->find(auth()->user()->id)) {
                    return response()->json(['error'=> 'Usuario não existe ! ALERTA !', 404]);
                } else {
                    $dataLogProductBraziliam = [                            
                        'id_user_function' => auth()->user()->id,
                        'function' => 'update',
                        'id_shopping_cart' => $dataProductBrazilianUpdate['id_shopping_cart'],
                        'nome' => $dataProductBrazilianUpdate['nome'],
                        'descricao' => $dataProductBrazilianUpdate['descricao'],
                        'categoria' => $dataProductBrazilianUpdate['categoria'],
                        'imagem' => $dataProductBrazilianUpdate['imagem'],
                        'preco' => $dataProductBrazilianUpdate['preco'],
                        'material' => $dataProductBrazilianUpdate['material'],
                        'departamento' => $dataProductBrazilianUpdate['departamento']
                    ];

                    $this->logProductBrazilian->create($dataLogProductBraziliam);
                    $dataProductBrazilian = $request->all();
                    $dataProductBrazilianUpdate->update($dataProductBrazilian);
                    return  response()->json([
                        "success" => true,
                        "description" => 'ProductBrazilian '.$id.' alterado com Sucesso'
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            if (!$data = $this->productBrazilian->find($id)){
                return response()->json(['error'=> 'Nada Encontrado', 404]);
            } else {
                if (!$this->user->find(auth()->user()->id)) {
                    return response()->json(['error'=> 'Usuario não existe ! ALERTA !', 404]);
                } else {
                    $dataLogProductBraziliam = [                            
                        'id_user_function' => auth()->user()->id,
                        'function' => 'delete',
                        'id_shopping_cart' => $data['id_shopping_cart'],
                        'nome' => $data['nome'],
                        'descricao' => $data['descricao'],
                        'categoria' => $data['categoria'],
                        'imagem' => $data['imagem'],
                        'preco' => $data['preco'],
                        'material' => $data['material'],
                        'departamento' => $data['departamento']
                    ];

                    $this->logProductBrazilian->create($dataLogProductBraziliam);
                    $data->delete();
                    return  response()->json([
                        "success" => true,
                        "description" => 'ProductBrazilian '.$id.' Deletado com Sucesso'
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
                'id_shopping_cart.required' => 'Qual o id da venda',
                'nome.required' => 'informe o nome',
                'categoria.required' => 'informe o categoria',
                'preco.required' => 'informe o preco',
                'departamento.required' => 'informe o departamento'
            ];
    
            $rules = [
                'id_shopping_cart'  => 'required',
                'nome'  => 'required',
                'categoria'  => 'required',
                'preco'  => 'required',
                'departamento' => 'required'
            ];
    
            $regras = ($id != null) ? $rules : $this->productBrazilian->rules();

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

    public function relation($id) {
        try {
            if (!$data = $this->productBrazilian
                ->with('relShoppingCart')
                ->find($id)) {
                return response()->json(['error'=> 'Nada Encontrado', 404]);
            } else {
                if (!$this->user->find(auth()->user()->id)) {
                    return response()->json(['error'=> 'Usuario não existe ! ALERTA !', 404]);
                } else {
                    $dataLogProductBraziliam = [                            
                        'id_user_function' => auth()->user()->id,
                        'function' => 'relation-shopping_cart - '.$id,
                        'id_shopping_cart' => $data['id_shopping_cart'],
                        'nome' => $data['nome'],
                        'descricao' => $data['descricao'],
                        'categoria' => $data['categoria'],
                        'imagem' => $data['imagem'],
                        'preco' => $data['preco'],
                        'material' => $data['material'],
                        'departamento' => $data['departamento']
                    ];
                    $this->logProductBrazilian->create($dataLogProductBraziliam);

                    $dataLogShoppingCart = [                            
                        'id_user_function' => auth()->user()->id,
                        'function' => 'relation-product_brasilian - '.$id,
                        'id_user' => $data['relShoppingCart']['id_user'],
                        'qtd' => $data['relShoppingCart']['qtd'],
                        'partial_value' => $data['relShoppingCart']['partial_value'],
                        'amount_discount' => $data['relShoppingCart']['amount_discount'],
                        'amount' => $data['relShoppingCart']['amount']
                    ];

                    $this->logShoppingCart->create($dataLogShoppingCart);

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
}

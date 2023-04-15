<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Exception;
use App\Models\ControleLOG_Shopping_Cart;
use App\Models\ControleLOG_ProductBrazilian;
use App\Models\ControleLOG_User;
use App\Models\ControleShoppingCart;
use Illuminate\Support\Facades\Validator;

class ShoppingCartControler extends Controller
{
    private $user;
    private $request;
    private $logUser;
    private $logShoppingCart;
    private $logProductBrazilian;
    private $shoppingCart;

    public function __construct()
    {
        $user = new User();
        $request = new Request();
        $logUser = new ControleLOG_User();
        $logShoppingCart = new ControleLOG_Shopping_Cart();
        $logProductBrazilian = new ControleLOG_ProductBrazilian();
        $shoppingCart = new ControleShoppingCart();

        $this->user = $user;
        $this->request = $request;        
        $this->shoppingCart = $shoppingCart;
        $this->logUser = $logUser;
        $this->logShoppingCart = $logShoppingCart;
        $this->logProductBrazilian = $logProductBrazilian;
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
                $dataLogShoppingCart = [                            
                    'id_user_function' => auth()->user()->id,
                    'function' => 'get ALL',
                    'id_user' => 0,
                    'qtd' => 0,
                    'partial_value' => 0,
                    'amount_discount' => 0,
                    'amount' => 0
                ];

                $this->logShoppingCart->create($dataLogShoppingCart);
                $data = ControleShoppingCart::all();
                    
                return  response()->json([
                    "success" => true,
                    "return" => $data
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
            $dataShoppingCart =  $request->all();

            $retornoValida = $this->validarApi($dataShoppingCart);
    
            if ($retornoValida != '') {
                echo $retornoValida; 
            } else {

                if (!$this->user->find(auth()->user()->id)) {
                    return response()->json(['error'=> 'Usuario não existe ! ALERTA !', 404]);
                } else {
                    $dataLogShoppingCart = [                            
                        'id_user_function' => auth()->user()->id,
                        'function' => 'create',
                        'id_user' => $dataShoppingCart['id_user'],
                        'qtd' => $dataShoppingCart['qtd'],
                        'partial_value' => $dataShoppingCart['partial_value'],
                        'amount_discount' => $dataShoppingCart['amount_discount'],
                        'amount' => $dataShoppingCart['amount']
                    ];

                    $this->logShoppingCart->create($dataLogShoppingCart);

                    $data = $this->shoppingCart->create($dataShoppingCart);

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
            if (!$dataShoppingCart = $this->shoppingCart->find($id)) {
                return response()->json(['error'=> 'Nada Encontrado', 404]);
            } else {
                if (!$this->user->find(auth()->user()->id)) {
                    return response()->json(['error'=> 'Usuario não existe ! ALERTA !', 404]);
                } else {
                    $dataLogShoppingCart = [                            
                        'id_user_function' => auth()->user()->id,
                        'function' => 'get - '.$id,
                        'id_user' => $dataShoppingCart['id_user'],
                        'qtd' => $dataShoppingCart['qtd'],
                        'partial_value' => $dataShoppingCart['partial_value'],
                        'amount_discount' => $dataShoppingCart['amount_discount'],
                        'amount' => $dataShoppingCart['amount']
                    ];

                    $this->logShoppingCart->create($dataLogShoppingCart);                        
                    return  response()->json([
                        "success" => true,
                        "return" => $dataShoppingCart
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
            if (!$dataShoppingCartUpdate = $this->shoppingCart->find($id)) {
                return response()->json(['error'=> 'Nada Encontrado', 404]);
            } else {
               
                if (!$this->user->find(auth()->user()->id)) {
                    return response()->json(['error'=> 'Usuario não existe ! ALERTA !', 404]);
                } else {
                    $dataLogShoppingCart = [                            
                        'id_user_function' => auth()->user()->id,
                        'function' => 'update',
                        'id_user' => $dataShoppingCartUpdate['id_user'],
                        'qtd' => $dataShoppingCartUpdate['qtd'],
                        'partial_value' => $dataShoppingCartUpdate['partial_value'],
                        'amount_discount' => $dataShoppingCartUpdate['amount_discount'],
                        'amount' => $dataShoppingCartUpdate['amount']
                    ];

                    $this->logShoppingCart->create($dataLogShoppingCart);
                    $dataShoppingCart = $request->all();
                    $dataShoppingCartUpdate->update($dataShoppingCart);
                   
                    return  response()->json([
                        "success" => true,
                        "description" => 'ShoppingCart '.$id.' alterado com Sucesso'
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
            if (!$data = $this->shoppingCart->find($id)){
                return response()->json(['error'=> 'Nada Encontrado', 404]);
            } else {
                if (!$this->user->find(auth()->user()->id)) {
                    return response()->json(['error'=> 'Usuario não existe ! ALERTA !', 404]);
                } else {
                    $dataLogShoppingCart = [                            
                        'id_user_function' => auth()->user()->id,
                        'function' => 'delete',
                        'id_user' => $data['id_user'],
                        'qtd' => $data['qtd'],
                        'partial_value' => $data['partial_value'],
                        'amount_discount' => $data['amount_discount'],
                        'amount' => $data['amount']
                    ];

                    $this->logShoppingCart->create($dataLogShoppingCart);
                    $data->delete();
                    return  response()->json([
                        "success" => true,
                        "description" => 'ShoppingCart '.$id.' Deletado com Sucesso'
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
                'id_user.required' => 'id do usuario',
                'qtd.required' => 'informe a quantidade',
                'partial_value.required' => 'informe o valor parcial',
                'amount_discount.required' => 'informe o desconto',
                'amount.required' => 'informe o valor final'
            ];
    
            $rules = [
                'id_user'  => 'required',
                'qtd'  => 'required',
                'partial_value'  => 'required',
                'amount_discount' => 'required',
                'amount' => 'required'
            ];
    
            $regras = ($id != null) ? $rules : $this->shoppingCart->rules();

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
            if (!$data = $this->shoppingCart
                ->with('relUser')
                ->with('relProducts')
                ->with('relProductsEuropean')
                ->find($id)) {
                return response()->json(['error'=> 'Nada Encontrado', 404]);
            } else {
                if (!$this->user->find(auth()->user()->id)) {
                    return response()->json(['error'=> 'Usuario não existe ! ALERTA !', 404]);
                } else {

                    $dataLogShoppingCart = [                            
                        'id_user_function' => auth()->user()->id,
                        'function' => 'relation-shopping_cart - '.$id,
                        'id_user' => $data['id_user'],
                        'qtd' => $data['qtd'],
                        'partial_value' => $data['partial_value'],
                        'amount_discount' => $data['amount_discount'],
                        'amount' => $data['amount']
                    ];
                    $this->logShoppingCart->create($dataLogShoppingCart);

                    $dataLogUser = [                            
                        'id_user_function' => auth()->user()->id,
                        'function' => 'relation-shopping_cart - '.$id,
                        'name' => $data['relUser']['name'],
                        'email' => $data['relUser']['email'],
                        'password' => '---'
                    ];
                    $this->logUser->create($dataLogUser);

                    foreach ($data['relProducts'] as $p) {
                        $dataLogProductBraziliam = [                            
                            'id_user_function' => auth()->user()->id,
                            'function' => 'relation-shopping_cart - '.$id,
                            'id_shopping_cart' => $p->id_shopping_cart,
                            'nome' => $p->nome,
                            'descricao' => $p->descricao,
                            'categoria' => $p->categoria,
                            'imagem' => $p->imagem,
                            'preco' => $p->preco,
                            'material' => $p->material,
                            'departamento' => $p->departamento
                        ];
                        $this->logProductBrazilian->create($dataLogProductBraziliam);
                    }

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

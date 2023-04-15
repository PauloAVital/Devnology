<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Exception;
use App\Models\ControleLOG_ProductEuropean;
use App\Models\ControleLOG_Shopping_Cart;
use App\Models\ControleProductEuropean;
use App\Models\ControleProductEuropeanDetails;
use App\Models\ControleProductEuropeanGallery;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;


class ProductEuropeanController extends Controller
{
    private $user;
    private $request;
    private $logProductEuropean;
    private $logShoppingCart;
    private $productEuropean;
    private $productEuropeanDetails;
    private $productEuropeanGallery;
    
    public function __construct()
    {
        $user = new User();
        $request = new Request();
        $logProductEuropean = new ControleLOG_ProductEuropean();
        $logShoppingCart = new ControleLOG_Shopping_Cart();
        $productEuropean = new ControleProductEuropean();
        $productEuropeanDetails = new ControleProductEuropeanDetails();
        $productEuropeanGallery = new ControleProductEuropeanGallery();

        $this->user = $user;
        $this->request = $request;
        $this->logProductEuropean = $logProductEuropean;
        $this->logShoppingCart = $logShoppingCart;
        $this->productEuropean = $productEuropean;
        $this->productEuropeanDetails = $productEuropeanDetails;
        $this->productEuropeanGallery = $productEuropeanGallery;
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
                    $dataProductEuropean = [                            
                        'id_user_function' => auth()->user()->id,
                        'function' => 'get ALL',
                        'id_shopping_cart' => 0,
                        'uuid' => 0,
                        'name' => 'Todos',
                        'description' => 'Todos',
                        'price' => 0,
                        'hasDiscount' => 0,
                        'discountValue' => 0
                    ];

                    $this->logProductEuropean->create($dataProductEuropean);
                    $data = ControleProductEuropean::all();
                      
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
            $dataProductEuropean =  $request->all();
            $uuid = (string) Uuid::uuid4();

            foreach ($dataProductEuropean['gallery'] as $g) {
                $dataProductEuropeanGallery = [                            
                    'uuid'=> $uuid,
                    'url' => $g
                ];
                $this->productEuropeanGallery->create($dataProductEuropeanGallery);
            }
            
            $dataProductEuropeanDetails = [                            
                'uuid'=> $uuid,
                'adjective' => $dataProductEuropean['details']['adjective'],
                'material' => $dataProductEuropean['details']['material']
            ];
            $this->productEuropeanDetails->create($dataProductEuropeanDetails);
           

            $dataProductEuropean = [                            
                'id_shopping_cart' => $dataProductEuropean['id_shopping_cart'],
                'uuid' => $uuid,
                'name' => $dataProductEuropean['name'],
                'description' => $dataProductEuropean['description'],
                'price' => $dataProductEuropean['price'],
                'hasDiscount' => $dataProductEuropean['hasDiscount'],
                'discountValue' => $dataProductEuropean['discountValue']
            ];

            $retornoValida = $this->validarApi($dataProductEuropean);
    
            if ($retornoValida != '') {
                echo $retornoValida; 
            } else {

                if (!$this->user->find(auth()->user()->id)) {
                    return response()->json(['error'=> 'Usuario não existe ! ALERTA !', 404]);
                } else {
                    $dataLogProductEuropean = [                            
                        'id_user_function' => auth()->user()->id,
                        'function' => 'insert',
                        'id_shopping_cart' => $dataProductEuropean['id_shopping_cart'],
                        'uuid' => $uuid,
                        'name' => $dataProductEuropean['name'],
                        'description' => $dataProductEuropean['description'],
                        'price' => $dataProductEuropean['price'],
                        'hasDiscount' => $dataProductEuropean['hasDiscount'],
                        'discountValue' => $dataProductEuropean['discountValue']
                    ];
                    $this->logProductEuropean->create($dataLogProductEuropean);

                    $data = $this->productEuropean->create($dataProductEuropean);

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
            if (!$data = $this->productEuropean->find($id)) {
                return response()->json(['error'=> 'Nada Encontrado', 404]);
            } else {
                if (!$this->user->find(auth()->user()->id)) {
                    return response()->json(['error'=> 'Usuario não existe ! ALERTA !', 404]);
                } else {
                    $dataLogProductEuropean = [                            
                        'id_user_function' => auth()->user()->id,
                        'function' => 'get - id '.$id,
                        'id_shopping_cart' => $data['id_shopping_cart'],
                        'uuid' => $data['uuid'],
                        'name' => $data['name'],
                        'description' => $data['description'],
                        'price' => $data['price'],
                        'hasDiscount' => $data['hasDiscount'],
                        'discountValue' => $data['discountValue']
                    ];
                    $this->logProductEuropean->create($dataLogProductEuropean);                       
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
            if (!$dataProductEuropeanUpdate = $this->productEuropean->find($id)) {
                return response()->json(['error'=> 'Nada Encontrado', 404]);
            } else {
               
                if (!$this->user->find(auth()->user()->id)) {
                    return response()->json(['error'=> 'Usuario não existe ! ALERTA !', 404]);
                } else {
                    
                    $dataProductEuropeanGallery = $this->productEuropeanGallery::where('uuid', 'LIKE', "%{$dataProductEuropeanUpdate['uuid']}%")->get();
                    foreach ($dataProductEuropeanGallery as $key => $g) {
                        $dataProductEuropeanGalleryUp = [                            
                            'uuid'=> $g->uuid,
                            'url' => $request['gallery'][$key]
                        ];
                        $gallery = $this->productEuropeanGallery->find($g->id);
                        $gallery->update($dataProductEuropeanGalleryUp);
                    }
                    
                    $dataProductEuropeanDetails = $this->productEuropeanDetails::where('uuid', 'LIKE', "%{$dataProductEuropeanUpdate['uuid']}%")->get()[0];
                    
                    $dataProductEuropeanDetailsUp = [                            
                        'uuid'=> $dataProductEuropeanDetails['uuid'],
                        'adjective' => $request['details']['adjective'],
                        'material' => $request['details']['material']
                    ];

                    $details = $this->productEuropeanDetails->find($dataProductEuropeanDetails['id']);
                    $details->update($dataProductEuropeanDetailsUp);

                    $dataProductEuropean = [                            
                        'id_shopping_cart' => $request['id_shopping_cart'],
                        'uuid' => $dataProductEuropeanUpdate['uuid'],
                        'name' => $request['name'],
                        'description' => $request['description'],
                        'price' => $request['price'],
                        'hasDiscount' => $request['hasDiscount'],
                        'discountValue' => $request['discountValue']
                    ];

                    $dataLogProductEuropean = [                            
                        'id_user_function' => auth()->user()->id,
                        'function' => 'update',
                        'id_shopping_cart' => $request['id_shopping_cart'],
                        'uuid' => $dataProductEuropeanUpdate['uuid'],
                        'name' => $request['name'],
                        'description' => $request['description'],
                        'price' => $request['price'],
                        'hasDiscount' => $request['hasDiscount'],
                        'discountValue' => $request['discountValue']
                    ];
                    $this->logProductEuropean->create($dataLogProductEuropean);

                    $dataProductEuropeanUpdate->update($dataProductEuropean);
                    return  response()->json([
                        "success" => true,
                        "description" => 'ProductEuropean '.$id.' alterado com Sucesso'
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
            if (!$data = $this->productEuropean->find($id)){
                return response()->json(['error'=> 'Nada Encontrado', 404]);
            } else {
                if (!$this->user->find(auth()->user()->id)) {
                    return response()->json(['error'=> 'Usuario não existe ! ALERTA !', 404]);
                } else {

                    $dataProductEuropeanGallery = $this->productEuropeanGallery::where('uuid', 'LIKE', "%{$data['uuid']}%")->get();
                    foreach ($dataProductEuropeanGallery as $g) {
                        $gallery = $this->productEuropeanGallery->find($g->id);
                        $gallery->delete();
                    }
                    
                    $dataProductEuropeanDetails = $this->productEuropeanDetails::where('uuid', 'LIKE', "%{$data['uuid']}%")->get()[0];
                    $details = $this->productEuropeanDetails->find($dataProductEuropeanDetails['id']);
                    $details->delete();

                    $dataLogProductEuropean = [                            
                        'id_user_function' => auth()->user()->id,
                        'function' => 'delete',
                        'id_shopping_cart' => $data['id_shopping_cart'],
                        'uuid' => $data['uuid'],
                        'name' => $data['name'],
                        'description' => $data['description'],
                        'price' => $data['price'],
                        'hasDiscount' => $data['hasDiscount'],
                        'discountValue' => $data['discountValue']
                    ];
                    $this->logProductEuropean->create($dataLogProductEuropean);
                    $data->delete();
                    return  response()->json([
                        "success" => true,
                        "description" => 'ProductsEuropean '.$id.' Deletado com Sucesso'
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
                'price.required' => 'informe o preço',
                'hasDiscount.required' => 'informe o se possui desconto'
            ];
    
            $rules = [                
                'name'  => 'required',
                'price' => 'required',
                'hasDiscount' => 'required'
            ];
    
            $regras = ($id != null) ? $rules : $this->productEuropean->rules();

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
            if (!$data = $this->productEuropean
                ->with('relShoppingCart')
                ->find($id)) {
                return response()->json(['error'=> 'Nada Encontrado', 404]);
            } else {
                if (!$this->user->find(auth()->user()->id)) {
                    return response()->json(['error'=> 'Usuario não existe ! ALERTA !', 404]);
                } else {
                    $dataLogProductEuropean = [                            
                        'id_user_function' => auth()->user()->id,
                        'function' => 'relation-product_european - '.$id,
                        'id_shopping_cart' => $data['id_shopping_cart'],
                        'uuid' => $data['uuid'],
                        'name' => $data['name'],
                        'description' => $data['description'],
                        'price' => $data['price'],
                        'hasDiscount' => $data['hasDiscount'],
                        'discountValue' => $data['discountValue']
                    ];
                    $this->logProductEuropean->create($dataLogProductEuropean);

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


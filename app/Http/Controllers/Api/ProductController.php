<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\product;
use App\Models\tags;

class ProductController extends Controller
{
    public function __construct(product $product, 
                                tags $tags, 
                                Request $request)
    {
        $this->product = $product;
        $this->tags = $tags;
        $this->request = $request;
    }
    

    public function index()
    {
        $data = $this->product->all();
        return response()->json($data);
    }
       
    public function store(Request $request)
    { 
        try {
            if (empty($request->all())) {
                # Tratar arquivos XML
                $xmlObject = simplexml_load_string($request->getContent());
                
                $json = json_encode($xmlObject);
                $phpArray = json_decode($json, true);

                $dataProduct = array();
                $dataTag = array();
                $dataResult = array();
        
                if (!empty($phpArray)) {
                    
                    foreach ($phpArray['element'] as $product) {
                        # Verificar duplicidade 
                        $id_search = $this->product->find($product['id']);
                        if (!isset($id_search)) {
                            $dataProduct['id'] = $product['id'];
                            $dataProduct['name'] = $product['name'];
                            $data = $this->product->create($dataProduct);

                            if(!empty($product['tags']['element'])){
                                foreach ($product['tags']['element'] as $tags) {
                                    $dataTag['id_products'] = $product['id'];
                                    $dataTag['name'] = $tags;
                                    $tag = $this->tags->create($dataTag);
                                }
                            }
                            array_push($dataResult, $data); 
                        } else {
                            array_push($dataResult, ['Error' => 'Duplicado', 'id' => $product['id']]);  
                        }
                    }
                    return response()->json($dataResult, 200);
                }
            } else {
                #Tratar arquivos JSON
                $dataForm = $request->all();

                $dataProduct = array();
                $dataTag = array();
                $dataResult = array();

                if (!empty($dataForm)) {
                    foreach ($dataForm['products'] as $product) {
                        # Verificar duplicidade 
                        $id_search = $this->product->find($product['id']);
                        if (!isset($id_search)) {
                                $dataProduct['id'] = $product['id'];
                                $dataProduct['name'] = $product['name'];
                                $data = $this->product->create($dataProduct);
                                # Verificar se Tags está vazio
                                if(!empty($product['tags'])){
                                    foreach ($product['tags'] as $tags) {
                                        var_dump($tags);
                                        $dataTag['id_products'] = $product['id'];
                                        $dataTag['name'] = $tags;
                                        $tag = $this->tags->create($dataTag);
                                    }
                                }
                                array_push($dataResult, $data);  
                        } else {
                            array_push($dataResult, ['Error' => 'Duplicado', 'id' => $product['id']]);  
                        }
                    }
                    return response()->json($dataResult, 200);
                }              
            }
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 400);
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
        if (is_numeric($id)) {            
            if (!$data = $this->product->find($id)) {
                return response()->json(['error'=> 'Nada Encontrado', 404]);
            } else {
                return response()->json($data);
            }
        } else {
            $data = $this->product::where('name', 'LIKE', "%{$id}%")->get();
            if ($data->isEmpty()) {
                if (!$data = $this->tags::where('name', 'LIKE', "%{$id}%")->get()) {
                    return response()->json(['error'=> 'Nada Encontrado', 404]);   
                }else {
                    return response()->json($data);
                }
            } else {
                return response()->json($data);
            }
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function __construct(User $user,
                                Request $Request)
    {
        $this->user = $user;
        $this->request = $Request;
    }

    public function index()
    {
        $data = User::all();
        return response()->json($data);
    }

   
    public function store(Request $request)
    {
        $this->validate($request, $this->user->rules());
        
        $dataForm = array(
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password)
        );

        $data = $this->user->create($dataForm);
        
        return response()->json($data, 200);
    }

    public function show($id)
    {
        if (!$data = $this->user->find($id)) {
            return response()->json(['error'=> 'Nada Encontrado', 404]);
        } else {
            return response()->json($data);
        }
    }
   
    public function update(Request $request, $id)
    {
        if (!$data = $this->user->find($id)){
            return response()->json(['error'=> 'Nada Encontrado', 404]);
        } else {
            $this->validate($request, $this->user->rules());
        
            $dataForm = array(
                "name" => $request->name,
                "email" => $request->email,
                "password" => bcrypt($request->password)
            );

            $data->update($dataForm);
            
            return response()->json($data);
        }
    }

    public function destroy($id)
    {
        if (!$data = $this->user->find($id)){
            return response()->json(['error'=> 'Nada Encontrado', 404]);
        } else {
            $data->delete();

            return response()->json(['success'=> 'Deletado com Sucesso']);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    protected $marca;

    public function __construct(Marca $marca) {
        $this->marca = $marca;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$marcas = Marca::all();
        $marcas = $this->marca->all();
        return Response()->json($marcas, 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //$marca = Marca::create($request->all());
    

        $request->validate($this->marca->rules(), $this->marca->feedback());

        $marca = $this->marca->create($request->all());
        return Response()->json($marca, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $marca = $this->marca->find($id);
        if($marca === null){
            return Response()->json(['erro' => 'Recurso pesquisado não existe'], 404);
        }
        return Response()->json($marca, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        //$marca->update($request->all());
        $marca = $this->marca->find($id);
        if($marca === null){
            return Response()->json(['erro' => 'Impossível realizar a atualização. O recurso solicitado não existe'], 404);
        }

        if($request->method() === 'PATCH'){

            $regrasDinamicas = array();

            //percorrendo todas as regras definidas no Model
            foreach($marca->rules() as $input => $regra){

                //coletar apenas as regras aplicáveis aos parâmetros parciais da requisição
                if(array_key_exists($input, $request->all())){

                    $regrasDinamicas[$input] = $regra;

                }
            }
            $request->validate($regrasDinamicas, $marca->feedback());
        }else{
            $request->validate($marca->rules(), $marca->feedback());
        }
        
        $marca->update($request->all());
        return Response()->json($marca, 200);;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //$marca->delete();
        $marca = $this->marca->find($id);

        if($marca === null){
            return Response()->json(['erro' => 'Impossível realizar a exclusão. O recurso solicitado não existe'], 404);
        }

        $marca->delete();
        return Response()->json(['msg' => 'A marca foi removida com sucesso!'], 200);
    }
}

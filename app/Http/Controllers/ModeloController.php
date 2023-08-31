<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ModeloController extends Controller
{
    protected $modelo;

    public function __construct(Modelo $modelo) {
        $this->modelo = $modelo;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Response()->json($this->modelo->all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate($this->modelo->rules());

        
        $image = $request->file('imagem');

        $image_urn = $image->store('imagens/modelos', 'public');

        $modelo = $this->modelo->create([
            'marca_id' => $request->marca_id,
            'nome'=> $request->nome,
            'imagem' => $image_urn,
            'numero_portas' => $request->numero_portas,
            'lugares' => $request->lugares,
            'air_bag' => $request->air_bag,
            'abs' => $request->abs
        ]);
        return Response()->json($modelo, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $modelo = $this->modelo->find($id);
        if($modelo === null){
            return Response()->json(['erro' => 'Recurso pesquisado não existe'], 404);
        }
        return Response()->json($modelo, 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $modelo = $this->modelo->find($id);

        if($modelo === null){
            return Response()->json(['erro' => 'Impossível realizar a atualização. O recurso solicitado não existe'], 404);
        }

        if($request->method() === 'PATCH'){

            $regrasDinamicas = array();

            //percorrendo todas as regras definidas no Model
            foreach($modelo->rules() as $input => $regra){

                //coletar apenas as regras aplicáveis aos parâmetros parciais da requisição
                if(array_key_exists($input, $request->all())){

                    $regrasDinamicas[$input] = $regra;

                }
            }
            $request->validate($regrasDinamicas);
        }else{
            $request->validate($modelo->rules());
        }
        
        // Remove o arquivo antigo caso um novo arquivo tebha sido enviado no request
        if($request->file('imagem')){
            Storage::disk('public')->delete($modelo->imagem);
        }

        $image = $request->file('imagem');

        $image_urn = $image->store('imagens/modelos', 'public');

        $modelo->update([
            'marca_id' => $request->marca_id,
            'nome'=> $request->nome,
            'imagem' => $image_urn,
            'numero_portas' => $request->numero_portas,
            'lugares' => $request->lugares,
            'air_bag' => $request->air_bag,
            'abs' => $request->abs
        ]);
        return Response()->json($modelo, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $modelo = $this->modelo->find($id);

        if($modelo === null){
            return Response()->json(['erro' => 'Impossível realizar a exclusão. O recurso solicitado não existe'], 404);
        }


        // Remove o arquivo antigo
        Storage::disk('public')->delete($modelo->imagem);

        $modelo->delete();
        return Response()->json(['msg' => 'A marca foi removida com sucesso!'], 200);
    }
}

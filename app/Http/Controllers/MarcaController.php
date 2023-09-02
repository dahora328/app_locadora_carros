<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Repositories\MarcaRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MarcaController extends Controller
{
    protected $marca;

    public function __construct(Marca $marca) {
        $this->marca = $marca;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $marcaRepository = new MarcaRepository($this->marca);

        if ($request->has('atributos_modelos')) {
            $atributos_modelos = 'modelos:id,'.$request->atributos_modelos;
            $marcaRepository->selectAtributosRegistrosRelacionados($atributos_modelos);

        }else {
            $marcaRepository->selectAtributosRegistrosRelacionados('modelos');
        }
        if ($request->has('filtro')) {
            
            $marcaRepository->filtro($request->filtro);
        }
        if ($request->has('atributos')) {

            $marcaRepository->selectAtributos($request->atributos);

        }
        return Response()->json($marcaRepository->getResultado(), 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate($this->marca->rules(), $this->marca->feedback());


        $image = $request->file('imagem');

        $image_urn = $image->store('imagens', 'public');

        $marca = $this->marca->create([
            'nome'=> $request->nome,
            'imagem' => $image_urn
        ]);
        return Response()->json($marca, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $marca = $this->marca->with('modelos')->find($id);
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

        // Remove o arquivo antigo caso um novo arquivo tebha sido enviado no request
        if($request->file('imagem')){
            Storage::disk('public')->delete($marca->imagem);
        }

        $imagem = $request->file('imagem');

        $image_urn = $imagem->store('imagens', 'public');

        //preecher o objeto $marca com os dados do request
        $marca->fill($request->all());
        $marca->imagem = $image_urn;
        $marca->save();

        /*$marca->update([
            'nome'=> $request->nome,
            'imagem' => $image_urn
        ]);*/
        return Response()->json($marca, 200);
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


        // Remove o arquivo antigo
        Storage::disk('public')->delete($marca->imagem);

        $marca->delete();
        return Response()->json(['msg' => 'A marca foi removida com sucesso!'], 200);
    }
}

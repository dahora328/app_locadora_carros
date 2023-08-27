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

        $marca->update($request->all());
        return Response()->json($marca, 200);;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Marca $marca)
    {
        
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

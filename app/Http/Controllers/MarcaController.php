<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateMarcaRequest;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $marcas = Marca::all();
        return $marcas;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $marca = Marca::create($request->all());
        return $marca;
    }

    /**
     * Display the specified resource.
     */
    public function show(Marca $marca)
    {
        return $marca;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Marca $marca)
    {

        $marca->update($request->all());

        return $marca;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Marca $marca)
    {
        return 'Chegamos até aqui';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Marca $marca)
    {
        //
    }
}

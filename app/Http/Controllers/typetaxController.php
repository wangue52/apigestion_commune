<?php

namespace App\Http\Controllers;

use App\Models\typeTaxe;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class typetaxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $nouvelle=typeTaxe::all();
       return response()->json($nouvelle,Response::HTTP_OK);
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $validatedData=$request->validate([
        'nom'=>'required',
        'taux'=>'required',
        'description'=>'required',
        'statut'=>'required',
       ]);
       $nouvelle=typeTaxe::create($request->all($validatedData));
       $nouvelle->nom=$request->nom;
       $nouvelle->taux=$request->taux;
       $nouvelle->description=$request->description;
       $nouvelle->save();
       return response()->json($nouvelle, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show($id){
        $nouvelle = typeTaxe::find($id);
        if ($nouvelle) {
            return response()->json($nouvelle);
        } else {
            return response()->json(['message' => 'type indisponible'], 404);
        }
       }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, typeTaxe $typeTaxe)
    {
        $ValidatedData=request()->validate([]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(typeTaxe $typeTaxe)
    {
        //
    }
}

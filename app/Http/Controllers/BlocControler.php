<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Bloc;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class BlocControler extends Controller
{
  public function index()
  {
    $bloc1= Bloc::all();
    return response()->json($bloc1, Response::HTTP_OK );

  }
  public function  store(Request $request){
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'number_shop' => 'required|string|max:255'
    ]);
    if ($validator->fails()) {
        return response()->json($validator->errors());
      };

    $bloc1 = Bloc::create([
        'name' =>$request->name ,
        'number_shop'=>$request->number_shop

    ]);
    return response()->json($bloc1, Response::HTTP_OK);

  }
  public function show( $id){
    $bloc1 = Bloc::find($id);
    if (!is_null($bloc1)) {
        return response()->json($bloc1, Response::HTTP_OK);
    } else {
        return response()->json(["message" => "le bloc n'existe pas "], Response::HTTP_NOT_FOUND);
    }
  }
  public function update(Request $request){
    $bloc1 = Bloc::find($request->id);
    if (!is_null($bloc1)) {
        $bloc1->name=$request->name ;
        $bloc1->number_shop=$request->number_shop ;
        $bloc1->save() ;
        return response()->json($bloc1, Response::HTTP_OK);
    } else {
        return response()->json(["message" => "le bloc n'existe pas"], Response::HTTP_NOT_FOUND);
    }
  }
  public function destroy($id) {
    $bloc1 = Bloc::find($id);
    $bloc1->delete();
    return response()->json(['message' => 'User deleted']);
  }
}

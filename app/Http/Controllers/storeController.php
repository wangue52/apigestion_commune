<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Response;

class  StoreController extends Controller
{
    public function index()
    {
        $stores = Store::all();
        return response()->json($stores, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'number' => $this->generateMatricule(),
        'bloc_id' => 'required|integer|exists:blocs,id',
        'city' => 'required|string|max:255',
        'district' => 'required|string|max:255',
        'longitude' => 'required|numeric',
        'latitude' => 'required|numeric',
        'status' => 'required|boolean',
    ]);
       
        $store = Store::create($request->all($validatedData));
        $store->name = $request->name;
        $store->number = $request->number;
        $store->bloc_id = $request->bloc_id;
        $store->city = $request->city;
        $store->district = $request->district;
        $store->longitude = $request->longitude;
        $store->latitude = $request->latitude;
        $store->status = $request->status;
        $store->save();
        return response()->json($store, Response::HTTP_CREATED);
    }
    private function generateMatricule()
{
    
    $base = "NDEB";
    $uniqueSuffix = uniqid('', true); 
    return $base . substr($uniqueSuffix, 0, 8); 
}

    public function show(Store $store)
    {
        if (!is_null($store)) {
            return response()->json($store, Response::HTTP_OK);
        } else {
            return response()->json(["message" => "Store not found"], Response::HTTP_NOT_FOUND);
        }
    }

    public function update(Request $request, Store $store)
    {
        if (!is_null($store)) {
            $store->name = $request->has('name') ? $request->name : $store->name;
            $store->number = $request->has('number') ? $request->number : $store->number;
            $store->bloc_id = $request->has('bloc_id') ? $request->bloc_id : $store->bloc_id;
            $store->city = $request->has('city') ? $request->city : $store->city;
            $store->district = $request->has('district') ? $request->district : $store->district;
            $store->longitude = $request->has('longitude') ? $request->longitude : $store->longitude;
            $store->latitude = $request->has('latitude') ? $request->latitude : $store->latitude;
            $store->status = $request->has('status') ? $request->status : $store->status;
            $store->save();
            return response()->json(["message" => "Store updated successfully"], Response::HTTP_OK);
        } else {
            return response()->json(["message" => "Store not found"], Response::HTTP_NOT_FOUND);
        }
    }

    public function destroy(Store $store)
    {
        if (!is_null($store)) {
            $store->delete();
            return response()->json(["message" => "Store deleted successfully"], Response::HTTP_OK);
        } else {
            return response()->json(["message" => "Store not found"], Response::HTTP_NOT_FOUND);
        }
    }
}






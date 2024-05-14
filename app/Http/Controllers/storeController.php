<?php
namespace App\Http\Controllers;
use App\Http\Resources\storerRessources;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\storesRequest;
use App\Models\Store;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class  StoreController extends Controller
{
    public function index()
    {
        $store= new Store() ;
        return storerRessources::collection($store::all())  ;
    
        
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'matricule' => $this->generateMatricule(),
        'bloc_id' => 'required|integer|exists:blocs,id',
        'city' => 'required|string|max:255',
        'district' => 'required|string|max:255',
        'longitude' => 'required|numeric',
        'latitude' => 'required|numeric',
        'status' => 'required|boolean',
    ]);

    try {
        $store = new Store();

        $store->fill($validatedData) ;
        $store->matricule = $this->generateMatricule();
        $store->save();
        
        return  new  storerRessources($store);
    } catch(\Exception $exception) {
        throw new HttpException(400, "Invalid data - {'message' => {$exception->getMessage()}");
    }
    }
    private function generateMatricule()
{
    
    $base = "NDEB";
    $uniqueSuffix = uniqid('', true); 
    return $base . substr($uniqueSuffix, 0, 8); 
}

    public function show($id)
    {
        $store = Store::findOrfail($id);
        if (!is_null($store)) {
            return response()->json($store);
        } else {
            return response()->json(["message" => "Store not found"], Response::HTTP_NOT_FOUND);
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'matricule' => $this->generateMatricule(),
            'bloc_id' => 'required|integer|exists:blocs,id',
            'city' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'status' => 'required|boolean',
        ]);
        if (!$id) {
            throw new HttpException(400, "Invalid id");
        }

        try {
           $store = Store::find($id); 
           $store->fill($validatedData);
           $store->matricule = $this->generateMatricule();
           $store->save();

           return new storerRessources ($store) ;
           return response()->json(["message" => "Store updated successfully"], Response::HTTP_OK);

        } catch(\Exception $exception) {
           throw new HttpException(400, "Invalid data - {$exception->getMessage()}");
        }
            

    }

    public function destroy($id)
    {
        $store = Store::find($id); 
        if (!is_null($store)) {
            $store->delete();
            return response()->json(["message" => "Store deleted successfully"], Response::HTTP_OK);
        } else {
            return response()->json(["message" => "Store not found"], Response::HTTP_NOT_FOUND);
        }
    }
}






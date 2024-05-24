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

    public function store(storesRequest $request)
    {

    
        $store =Store::create($request->validated());
        $matricule= $this->generateMatricule($store->id);
        $store->matricule=$matricule ;
        $store->update(['matricule' =>$matricule]);
        return new storerRessources($store->fresh()) ;
    }
        
    public function generateMatricule($id)
    {
        $store = Store::findOrfail($id);
        $prefix = substr($store->name, 0, 3);
        $count = Store::whereYear('created_at', date('Y'))->count() + 1;
        $matricule = $prefix . date('y') . str_pad($count, 3, '0', STR_PAD_LEFT);

        return $matricule;
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

    public function update(storesRequest $request, Store $store)
    {
        $store->update($request->validated());
        return new storerRessources($store);        

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






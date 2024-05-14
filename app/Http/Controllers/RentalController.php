<?php

namespace App\Http\Controllers ;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rental;
use Intervention\Image\Image\ImageManager ;
use BaconQrCode\Writer;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;

class RentalController extends Controller
{
    public function index()
    {
        $rentals = Rental::all(); // Fetch all rentals
        return response()->json($rentals); // Return JSON response with all rentals
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate($request->all(), [
            'client_name' => 'required|string|max:255',
            'store_matricule' => 'required|string|unique:stores,number', // Assuming 'number' is the unique identifier in the 'stores' table
            'store_name' => 'required|string|max:255',
            'store_address' => 'required|string|max:255',
            'period_location' => 'required|integer',
            'rental_date' => 'required|date_format:Y-m-d H:i:s',
            'price_store' => 'required|numeric|between:0.01,999999.99', // Allow prices from 0.01 to 999,999.99
        ]);
        $rental = Rental::create($request->all());
        $rental->client_name=$request->client_name;
        $rental->store_matricule=$request->store_matricule;
        $rental->store_name=$request->store_name;
        $rental->store_address=$request->store_address;
        $rental->period_location=$request->period_location;
        $rental->rental_date=$request->rental_date;
        $rental->price_store=$request->price_store;
        $rental->save();
        return response()->json($rental, 201); // Return the created rental data with status code 201 (Created)
    }
   public function show($id){
    $rental = Rental::find($id);
    if ($rental) {
        return response()->json($rental);
    } else {
        return response()->json(['message' => 'Rental not found'], 404);
    }
   }
   public function update(Request $request, $id){
    $rental = Rental::find($id);
    if ($rental) {
        $rental->client_name=$request->client_name;
        $rental->store_matricule=$request->store_matricule;
        $rental->store_name=$request->store_name;
        $rental->store_address=$request->store_address;
        $rental->period_location=$request->period_location;
        $rental->rental_date=$request->rental_date;
        $rental->price_store=$request->price_store;
        $rental->update($request->all());
        $rental->save();
        return response()->json($rental);
    } else {
        return response()->json(['message' => 'Rental not found'], 404);
    }
   }
   public function destroy($id){
    $rental = Rental::find($id);
    if ($rental) {
        $rental->delete();
        return response()->json(['message' => 'Rental deleted successfully']);
    } else {
        return response()->json(['message' => 'Rental not found'], 404);
    }
   }

//    public function generateRentalContract(Request $request, $storeId)
// {
//     // Validate the request data
//     $validatedData = $request->validate([
//         'customer_name' => 'required|string',
//         'customer_email' => 'required|email',
//         'rental_duration' => 'required|integer',
//         'rental_start_date' => 'required|date',
//     ]);

//     // Find the store
//     $store = Store::findOrFail($storeId);

//     // Create a new rental contract
//     $rentalContract = new RentalContract();
//     $rentalContract->store_id = $store->id;
//     $rentalContract->customer_name = $validatedData['customer_name'];
//     $rentalContract->customer_email = $validatedData['customer_email'];
//     $rentalContract->rental_duration = $validatedData['rental_duration'];
//     $rentalContract->rental_start_date = $validatedData['rental_start_date'];
//     $rentalContract->save();

//     // Generate the rental contract PDF
//     $pdf = PDF::loadView('rental-contract', [
//         'store' => $store,
//         'rentalContract' => $rentalContract,
//     ]);

//     // Return the PDF for download
//     return $pdf->download('rental-contract.pdf');
// }
// Route::post('/stores/{storeId}/rental-contract', [StoreController::class, 'generateRentalContract'])->name('stores.rental-contract');
// public function generateMatricule()
// {
//     // Generate a unique matricule for the store
//     $lastStore = Store::orderBy('id', 'desc')->first();
//     $lastMatricule = $lastStore ? $lastStore->matricule : 0;
//     $newMatricule = $lastMatricule + 1;
//     return 'STORE-' . str_pad($newMatricule, 4, '0', STR_PAD_LEFT);
// }

}

<?php

namespace App\Http\Controllers ;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use BaconQrCode\Renderer\RendererStyle\Fill;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rental;
use BaconQrCode\Renderer\Color\Rgb;
use Spatie\LaravelPdf\Facades\Pdf;

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
   public function generateQrCode($id)
{     $rental = Rental::find($id);
    $data = [
        'store_id' => $rental->store_id,
        'rent_expiration' => $rental->rent_expiration,
        'payment_status' => $rental->payment_status,
       
    ];

    $url = route('rental.qrcode', ['data' => json_encode($data)]);

    $renderer = new ImageRenderer(
        new RendererStyle(400, 1, null, null, Fill::uniformColor(new Rgb(0, 255, 0), new Rgb(0, 0, 0) )),
        new ImagickImageBackEnd()
    );

    $writer = new Writer($renderer);
    $qrCode = $writer->writeString($url);

    $filename = 'qrcode_'. time(). '.png';
    $filepath = public_path('qrcodes/'. $filename);

    file_put_contents($filepath, $qrCode);

    return response()->json([
        'qrcode_url' => url('qrcodes/'. $filename),
        'data' => $data
    ]);
}
   public function getQrCodeData(Request $request)
{
    $data = json_decode($request->data, true);

    $rental = Rental::where('store_id', $data['store_id'])
        ->where('rent_expiration', $data['rent_expiration'])
        ->where('payment_status', $data['payment_status'])
        ->first();
    if ($rental) {
        return response()->json($rental);
    } else {
        return response()->json(['message' => 'Rental not found'], 404);
    }
}
    public function generatePdf($id)
    {
        $rental = Rental::find($id);

        if ($rental) {
            $qrCode = $this->generateQrCode($id);

            $pdf = PDF::loadView('pdf.rental', [
                'rental' => $rental,
                'qrCode' => $qrCode,
            ]);

            return $pdf->download('rental_details_'. $rental->client_name. '.pdf');
        } else {
            return response()->json(['message' => 'Rental not found'], 404);
        }
    }

    //...
}

//

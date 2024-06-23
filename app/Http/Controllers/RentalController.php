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
use Spatie\LaravelPdf\PdfBuilder;
use Barryvdh\DomPDF\Facade\Pdf ;
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
            'store_address' => 'required|string|max:255',
            'period_location' => 'required|integer',
            'rental_date' => 'required|date_format:Y-m-d H:i:s',
            'price_store' => 'required|numeric|between:0.01,999999.99', // Allow prices from 0.01 to 999,999.99
        ]);
        $rental = Rental::create([

            'client_name' =>$request->client_name ,
            'store_matricule'=> $request->store_matricule ,
            'store_address' => $request->store_address,
            'period_location' =>$request->period_location ,
            'rental_date' =>$request->rental_date ,
            'price_store' => $request->price_store,
        ]);
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
        $rental->update([

            'client_name' =>$request->client_name ,
            'store_matricule'=> $request->store_matricule ,
            'store_address' => $request->store_address,
            'period_location' =>$request->period_location ,
            'rental_date' =>$request->rental_date ,
            'price_store' => $request->price_store,
        ]);
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
        'client_name' =>$rental->client_name ,
            'store_matricule'=> $rental->store_matricule ,
            'store_address' => $rental->store_address,

    ];


    $url = route('rental.qrcode', ['id' => $rental->id]);
    $dataString = json_encode($data);
    $urlString = $url;
    $renderer = new ImageRenderer(
        new RendererStyle(200, 1, null, null, Fill::uniformColor(new Rgb(0, 255, 0), new Rgb(0, 0, 0) )),
        new ImagickImageBackEnd()
    );

    $writer = new Writer($renderer);
    $qrCode = $writer->writeString($urlString);

    $filename = 'qrcode_'. $rental->client_name. '.png';
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
        $rental = Rental::findOrFail($id);
    $qrCode = $this->generateQrCode($id);
    $qrcodeData = $qrCode->getData(true);
    $qrcodeUrl = $qrcodeData['qrcode_url'];


    $pdf = PDF::loadView('pdf.rental', [
        'rental' => $rental,
        'qrCode' => $qrcodeUrl,
    ]);

    $fileName = 'rental_details_' . $rental->client_name . '.pdf';
    return $pdf->download($fileName);
    }

}


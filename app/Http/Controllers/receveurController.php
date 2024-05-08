<?php

namespace App\Http\Controllers;

use App\Models\receveur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class receveurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $receveurs = Receveur::all();

        return response()->json($receveurs, 200);
    }
    public function store(Request $request)
    {
        try {
            // Validate request data
            $validator = Validator::make($request->all(), [
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'email' => 'required|email|unique:receveurs',
                'telephone' => 'required|string|max:20',
                'motpasse' => 'required|string|min:8|confirmed',
                'adresse' => 'required|string',
                'ville' => 'required|string|max:255',
                'speudo' => 'required|string|unique:receveurs|max:255',
                'photo' => 'nullable|image|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            // Create new receiver
            $receiver = new Receveur();
            $receiver->nom = $request->nom;
            $receiver->prenom = $request->prenom;
            $receiver->email = $request->email;
            $receiver->telephone = $request->telephone;
            $receiver->motpasse = Hash::make($request->motpasse);
            $receiver->adresse = $request->adresse;
            $receiver->ville = $request->ville;
            $receiver->speudo = $request->speudo;

            // Handle photo upload (if provided)
            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $fileName = time() . '.' . $photo->getClientOriginalExtension();
                $photo->move(public_path('images/receveurs'), $fileName);
                $receiver->photo = $fileName;
            }

            $receiver->save();

            return response()->json([
                'message' => 'Receiver created successfully',
                'receiver' => $receiver
            ], 201);
        } catch (ValidationException $e) {
            return response()->json($e->validator->errors(), 422);
        }
    }

    public function show($id)
    {
        $receiver = Receveur::find($id);

        if (!$receiver) {
            return response()->json(['message' => 'Receiver not found'], 404);
        }

        return response()->json($receiver, 200);
    }

    public function update(Request $request, $id)
    {
        try {
            // Validate request data
            $validator = Validator::make($request->all(), [
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'email' => 'required|email|unique:receveurs,id,' . $id,
                'telephone' => 'required|string|max:20',
                'adresse' => 'required|string',
                'ville' => 'required|string|max:255',
                'speudo' => 'required|string|unique:receveurs,id,' . $id . '|max:255',
                'motpasse' => 'nullable|string|min:8|confirmed', // Allow optional password update
                'photo' => 'nullable|image|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $receiver = Receveur::find($id);

            if (!$receiver) {
                return response()->json(['message' => 'Receiver not found'], 404);
            }

            $receiver->nom = $request->nom;
            $receiver->prenom = $request->prenom;
            $receiver->email = $request->email;
            $receiver->telephone = $request->telephone;
            $receiver->adresse = $request->adresse;
            $receiver->ville = $request->ville;
            $receiver->speudo = $request->speudo;

            // Handle password update (if provided)
            if ($request->has('motpasse')) {
                $receiver->motpasse = Hash::make($request->motpasse);
            }

            // Handle photo upload (if provided)
            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $fileName = time() . '.' . $photo->getClientOriginalExtension();
                $photo->move(public_path('images/receveurs'), $fileName);
                $receiver->photo = $fileName;

                // Handle deletion of old photo (optional)
                if (isset($receiver->photo) && file_exists(public_path('images/receveurs/' . $receiver->photo))) {
                    unlink(public_path('images/receveurs/' . $receiver->photo));
                }
            }

            $receiver->save();

            return response()->json([
                'message' => 'Receiver updated successfully',
                'receiver' => $receiver
            ], 200);
        } catch (ValidationException $e) {
            return response()->json($e->validator->errors(), 422);
        }
    }
    public function destroy($id)
    {
        $receiver = Receveur::find($id);

        if (!$receiver) {
            return response()->json(['message' => 'Receiver not found'], 404);
        }

        $receiver->delete();

        return response()->json(['message' => 'Receiver deleted successfully'], 204);
    }
}


        
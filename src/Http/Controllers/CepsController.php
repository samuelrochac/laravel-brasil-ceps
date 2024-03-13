<?php

namespace Samuelrochac\LaravelBrasilCeps\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Samuelrochac\LaravelBrasilCeps\Models\Address;

class CepsController extends Controller
{
    public function prepareZipcode($zipcode)
    {   
        // Deixa no formato "#####-###" exemplo 01423010 > 01423-010
        return substr_replace($zipcode, '-', 5, 0);
    }

    public function json($zipcode): JsonResponse
    {
        $zipcode = $this->prepareZipcode($zipcode);

        $search = Address::where('postal_code', $zipcode)->first();

        if (!$search) {
            return response()->json(['message' => 'CEP não encontrado'], 404);
        }

        return response()->json($search, 200);
    }
}

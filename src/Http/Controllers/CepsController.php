<?php

namespace Samuelrochac\LaravelBrasilCeps\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Samuelrochac\LaravelBrasilCeps\Http\Resources\ZipCodeResource;
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

        $search = Address::with(['district', 'city', 'state'])->where('postal_code', $zipcode)->first();

        if (!$search) {
            return response()->json(['message' => 'CEP não encontrado'], 404);
        }

        try{
            $result = new ZipCodeResource($search);
            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao processar a requisição'], 500);
        }
    }
}

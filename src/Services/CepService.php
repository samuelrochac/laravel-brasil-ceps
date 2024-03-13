<?php

namespace Samuelrochac\LaravelBrasilCeps\Services;

use Samuelrochac\LaravelBrasilCeps\Models\Address;

class CepService
{
    /**
     * Busca informações detalhadas de um CEP.
     *
     * @param  string $cep O CEP que será buscado.
     * @return Address|null O modelo Address contendo as informações do CEP, ou null se não for encontrado.
     */
    public function buscar(string $cep)
    {
        // Formata o CEP para adicionar o traco exemplo 01423010 > 01423-010
        $cepLimpo = substr_replace($cep, '-', 5, 0);

        // Tenta encontrar o CEP no banco de dados.
        $endereco = Address::where('postal_code', $cepLimpo)->first();

        return $endereco;
    }
}
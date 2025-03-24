<?php

namespace Itau\Facades;

use Illuminate\Support\Facades\Facade;
use Itau\Http\ItauClient;

/**
 * @method static string getToken()
 * @method static array registrarBoletoCobranca(array $data)
 * @see \Itau\Http\ItauClient
 */
class Itau extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ItauClient::class;
    }
} 
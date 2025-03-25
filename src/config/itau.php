<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Itaú API Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for the Itaú API.
    |
    */

    // API Base URLs
    'base_url' => env('ITAU_API_BASE_URL', 'https://sandbox.devportal.itau.com.br'),
    'boletos_url' => env('ITAU_API_BOLETOS_URL', '/itau-ep9-gtw-cash-management-ext-v2/v2'),
    
    // OAuth Credentials
    'client_id' => env('ITAU_CLIENT_ID', ''),
    'client_secret' => env('ITAU_CLIENT_SECRET', ''),
    
    // Timeout settings (in seconds)
    'timeout' => env('ITAU_API_TIMEOUT', 30),
    'connect_timeout' => env('ITAU_API_CONNECT_TIMEOUT', 10),
]; 
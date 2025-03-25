<?php

namespace Itau\Http;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Client\RequestException;

class ItauClient
{
    protected $config;
    protected $baseUrl;
    protected $token;

    /**
     * ItauClient constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $this->baseUrl = $config['base_url'];
    }

    /**
     * Get OAuth token for API authentication.
     *
     * @return string
     * @throws RequestException
     */
    public function getToken()
    {
        // Check if token is cached
        $cacheKey = 'itau_api_token';
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        // Usar application/x-www-form-urlencoded conforme esperado pelo servidor OAuth
        $response = Http::asForm()
            ->withHeaders([
                'Content-Type' => 'application/x-www-form-urlencoded',
            ])
            ->timeout($this->config['timeout'])
            ->post($this->config['base_url'] . '/api/oauth/jwt', [
                'grant_type' => 'client_credentials',
                'client_id' => $this->config['client_id'],
                'client_secret' => $this->config['client_secret'],
            ]);

        $response->throw();
        $data = $response->json();
        $token = $data['access_token'];
        $expiresIn = $data['expires_in'] - 60; // Subtract 60 seconds to be safe

        // Cache the token
        Cache::put($cacheKey, $token, $expiresIn);

        return $token;
    }

    /**
     * Register a new "Boleto de Cobrança".
     *
     * @param array $data Dados do boleto
     * @return array
     * @throws RequestException
     */
    public function registrarBoletoCobranca(array $data)
    {
        $token = $this->getToken();

        $headers = [
            'Authorization' => $token,
            'Content-Type' => 'application/json',
        ];

        $response = Http::withHeaders($headers)
            ->timeout($this->config['timeout'])
            ->post($this->config['base_url'] . $this->config['boletos_url'] . '/boletos', $data);
        
        $response->throw();
        
        return $response->json();
    }
} 

<?php

namespace Itau\Tests\Feature;

use Itau\Tests\TestCase;
use Itau\Facades\Itau;
use Illuminate\Support\Facades\Cache;

class RegistrarBoletoCobrancaTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        // Clear the cache before each test
        Cache::flush();
    }

    /** @test */
    public function it_can_register_boleto_cobranca()
    {
        // Skip this test if environment variables are not set
        if (empty(config('itau.client_id')) || 
            empty(config('itau.client_secret'))) {
            $this->markTestSkipped('API credentials not configured.');
        }

        // Prepare test data
        $data = [];

        // Call the method with specific parameters
        $response = Itau::registrarBoletoCobranca($data);

        // Assert that the response has the expected structure
        $this->assertIsArray($response);
        
        // Check if response contains expected keys
        // Note: these assertions might need to be adjusted based on the actual API response
        $this->assertArrayHasKey('numero', $response);
        // Add more assertions based on the real API response
    }
} 
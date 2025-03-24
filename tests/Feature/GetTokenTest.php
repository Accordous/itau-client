<?php

namespace Itau\Tests\Feature;

use Itau\Tests\TestCase;
use Itau\Facades\Itau;
use Illuminate\Support\Facades\Cache;
use PHPUnit\Framework\Attributes\Test;

class GetTokenTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        // Clear the cache before each test
        Cache::flush();
    }

    #[Test]
    public function it_can_get_oauth_token()
    {
        // Skip this test if environment variables are not set
        if (empty(config('itau.client_id')) || 
            empty(config('itau.client_secret'))) {
            $this->markTestSkipped('API credentials not configured.');
        }
        
        // Clear any cached tokens
        Cache::forget('itau_api_token');
        
        // Get a real token
        $token = Itau::getToken();

        // Verify the token is not empty
        $this->assertNotEmpty($token);
        $this->assertIsString($token);
    }

    /** @test */
    public function it_returns_cached_token_if_available()
    {
        // Put a test token in the cache
        $cachedToken = 'cached-token-' . time();
        Cache::put('itau_api_token', $cachedToken, 3600);

        // Call the method
        $token = Itau::getToken();

        // Assert we got the cached token
        $this->assertEquals($cachedToken, $token);
    }
} 
<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class HttpTest extends TestCase
{
    public function test_http()
    {
        Http::fake();
 
        Http::withHeaders([
            'X-First' => 'foo',
        ])->post('http://example.com/userss', [
            'name' => 'Taylor',
            'role' => 'Developer',
        ]);
        
        Http::assertSent(function (Request $request) {
            return $request->hasHeader('X-First', 'foo') &&
                $request->url() == 'http://example.com/userss' &&
                $request['name'] == 'Taylor' &&
                $request['role'] == 'Developer';
        });
    }

    public function test_http_2()
    {
        Http::fake();
 
        Http::withHeaders([
            'X-First' => 'foo',
        ])->post('test-http-2', [
            'name' => 'Taylor',
            'role' => 'Developer',
        ]);
        
        Http::assertSent(function (Request $request) {
            return $request->hasHeader('X-First', 'foo') &&
                $request->url() == 'test-http-2' &&
                $request['name'] == 'Taylor' &&
                $request['role'] == 'Developer';
        });
    }

    public function test_http_3()
    {
        $response = Http::get('http://example.com');
        $this->assertTrue($response->ok());
    }

    public function test_http_4()
    {
        Http::fake();
        $response = Http::get(env('APP_URL').'/api/test-http-4');
        Http::assertSent(function (Request $request) {
            return $request->url() == env('APP_URL').'/api/test-http-4';
        });
        Http::assertSentCount(1);
        $this->assertTrue($response->ok());
    }

    public function test_http_5()
    {
        Http::fake(function ($request) {
            return Http::response('Hello World', 200);
        });
    }
}

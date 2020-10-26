<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\ApiData;

class BasicTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testApiDataRequest()
    {
        $data = [
            'activity' => '100000',
            'activityType' => 'miles',
            'country' => 'usa',
            'fuelType' => 'motorGasoline',
            'mode' => 'petrolCar'
        ];
        $response = $this->json('GET', '/api/post', $data);
        $response->assertStatus(200);
        
    }

    public function testApiData()
    {
        
        $response = $this->json('GET', '/api');
        $response->assertStatus(200);
        
    }

    public function testApiDataShow()
    {
        //$data = ['id' => '2' ];
        $response = $this->json('GET', '/api/show/2');
        $response->assertStatus(200);
        
    }

    public function testApiDataDelete()
    {
        //$data = ['id' => '4' ];
        $response = $this->json('GET', '/api/delete/4');
        $response->assertStatus(200);
        
    }
}

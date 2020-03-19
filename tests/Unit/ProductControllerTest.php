<?php

namespace Tests\Unit;

use Tests\TestCase;



class ProductControllerTest extends TestCase
{

    public function testLogin()
    {
       $response = $this->withHeaders([
           'Accept' => 'application/json'
       ])->json('POST', '/api/v1/login', [
           'email'      => 'user@email.com',
           'password'   => 'password',
       ]);


        $token = $response->json()['token'];
        $this->assertNotEmpty($token);

        $testVars = [
            'token' => $token,
            'product' =>
                [
                    'name'      => 'nameTest',
                    'brand'     => 'brandTest',
                    'price'     => 99,
                    'amount'    => 99,
                ]
            ];

       return $testVars;
    }

    /**
     * @depends testLogin
     * @param array $testVars
     */
    public function testIndex(array $testVars)
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $testVars['token'],
            'Accept' => 'application/json'
        ])->json('GET', '/api/v1/products');

        $response->assertStatus(200);
    }


    /**
     * @depends testLogin
     * @param array $testVars
     */
    public function testStore(array $testVars)
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $testVars['token'],
            'Accept' => 'application/json'
        ])->json('POST', '/api/v1/products', $testVars['product']);

        $response
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'message' => 'Product successfully added'
                ]
            ]);
    }


    /**
     * @depends testLogin
     * @param array $testVars
     */
    public function testShow(array $testVars)
    {
        $response = $this
            ->withHeaders([
                'Authorization' => 'Bearer ' . $testVars['token'],
                'Accept' => 'application/json'
            ])->json('GET', '/api/v1/products/1');

        $response
            ->assertStatus(200)
            ->assertJsonFragment($testVars['product']);
    }


    /**
     * @depends testLogin
     * @param array $testVars
     */
    public function testQueryFilter(array $testVars)
    {

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $testVars['token'],
            'Accept' => 'application/json'
        ])->json('GET', '/api/v1/products?q='. $testVars['product']['name']);

        $response
            ->assertStatus(200)
            ->assertJsonFragment($testVars['product']);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $testVars['token'],
            'Accept' => 'application/json'
        ])->json('GET', '/api/v1/products?filter=brand:' . $testVars['product']['brand']);

        $response
            ->assertStatus(200)
            ->assertJsonFragment($testVars['product']);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $testVars['token'],
            'Accept' => 'application/json'
        ])->json('GET', '/api/v1/products?q='. $testVars['product']['name'] . '&price:' . $testVars['product']['price']);

        $response
            ->assertStatus(200)
            ->assertJsonFragment($testVars['product']);
    }

    /**
     * @depends testLogin
     * @param array $testVars
     */
    public function testUpdate(array $testVars)
    {
        $testVars['product']['name'] = 'nameTestUpdated';
        $testVars['product']['brand'] = 'brandTestUpdated';
        $testVars['product']['price'] = 11;
        $testVars['product']['brand'] = 11;

        $response = $this
            ->withHeaders([
                'Authorization' => 'Bearer ' . $testVars['token'],
                'Accept' => 'application/json'
            ])->json('PUT', '/api/v1/products/1', $testVars['product']);

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'message' => 'Product successfully changed'
                ]
            ]);
    }

    /**
     * @depends testLogin
     * @param array $testVars
     */
    public function testDestroy(array $testVars)
    {

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $testVars['token'],
            'Accept' => 'application/json'
        ])->json('DELETE', '/api/v1/products/1');

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'message' => 'Product successfully removed'
                ]
            ]);
    }


}

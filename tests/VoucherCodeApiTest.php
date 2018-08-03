<?php

/**
 * Class VoucherCodeApiTest
 */

class VoucherCodeApiTest extends TestCase
{
    public function testVerifyVoucherCodeWithoutParameters()
    {
        $response = $this->call('GET', '/api/vouchers');
        $this->assertEquals(422, $response->status());

    }

    public function testVerifyVoucherCode()
    {
        $this->json('POST', '/api/verify', ['email' => 'hoda.hussin@gmail.com'])
            ->seeJson(["status" => "OK",
                "code" => 422,
                "message" => [
                    "The code field is required."
                ]]);
    }

    public function testVerifyVoucherCodeInvalidCode()
    {
        $this->json('POST', '/api/verify',
            ['email' => 'hoda.hussin@gmail.com', 'code' => '4444'])
            ->seeJson(["status" => "OK",
                "code" => 422,
                "message" => [
                    "The code must be at least 6 characters."
                ]
            ]);
    }


    public function testVerifyVoucherCodeWithoutCode()
    {
        $this->call('GET', '/api/vouchers');
        $this->seeJsonEquals(["status" => "OK",
            "code" => 422,
            "message" => [
                "The email field is required."
            ]]);

    }



    public function testGetVoucherCodeWithoutParameters()
    {
        $response = $this->call('GET', '/api/vouchers');
        $this->assertEquals(422, $response->status());

    }

    public function testGetVoucherCodeEmailInVaild()
    {
        $response = $this->call('GET', '/api/vouchers');
        $this->assertEquals(422, $response->status());

    }

    public function testGetVoucherCodeEmailNotExist()
    {
        $response = $this->call('GET', '/api/vouchers', ['email' => 'heba@gamil.com']);
        $this->assertEquals(404, $response->status());


    }

    public function testGetVoucherCodeByEmail()
    {
        $response = $this->call('GET', '/api/vouchers', ['email' => "hoda.hussin@gmail.com"]);
        $this->assertEquals(200, $response->status());

    }


}
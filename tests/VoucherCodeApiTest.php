<?php


class VoucherCodeApiTest extends TestCase
{


    public function testVerifyVoucherCode()
    {
        $this->json('POST', '/api/verify', ['email' => 'hoda.hussin@gmail.com'])
            ->seeJson(["status" => "OK",
                "code" => 422,
                "message" => [
                    "The code field is required."
                ]]);
    }

    public function testVerifyVoucherCodeWithoutParameters()
    {
        $response = $this->call('GET', '/api/vouchers');
        $this->assertEquals(422, $response->status());

    }

    public function testVerifyVoucherCodeWithoutCode()
    {
        $this->call('GET', '/api/vouchers');
        $this->seeJsonEquals(["status" => "OK",
            "code" => 422,
            "message" => [
                "The email field is required."
            ]]);
//        $this->assertEquals(422, $response->status());

    }

    public function testVerifyVoucherCodeEmailInvalid()
    {
        $response = $this->call('GET', '/api/vouchers');
        $this->assertEquals(422, $response->status());

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
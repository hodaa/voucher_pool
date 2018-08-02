<?php


class VoucherCodeApiTest extends TestCase
{

    public function testVerifyVoucherCode()
    {
        $response = $this->call('GET', '/');
        $this->assertEquals(200, $response->status());
//
//        $this->json('POST', '/api/verify', ['email' => 'hoda.hussin@gmail.com'])
//            ->seeJson([
//                "status"=>'200',
//                "code"=>'200',
//                'created' => true,
//            ]);
    }

    public function testGetVoucherCode()
    {

        $response = $this->call('GET', '/api/vouchers');
        $this->assertEquals(422, $response->status());


    }

}
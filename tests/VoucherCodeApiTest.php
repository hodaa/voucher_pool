<?php


class VoucherCodeApiTest extends TestCase
{

    public function testVerifyVoucherCode()
    {
        $this->post('/verify', ['name' => 'Sally',])
            ->seeJsonEquals([
                'created' => true,
            ]);

        $this->get("products", []);
    }

    public function testGetVoucherCode()
    {

        $response = $this->call('GET', '/api/vouchers',['email'=>'johndoe.com']);

        $this->assertEquals(200, $response->status());


    }

}
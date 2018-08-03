<?php


class VoucherCodeTest extends TestCase{


    function testHome(){
        $response = $this->call('GET', '/');
        $this->assertEquals(200, $response->status());
    }


}
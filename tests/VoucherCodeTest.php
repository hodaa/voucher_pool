<?php


class VoucherCodeTest extends TestCase{


    function testHome(){
        $response = $this->call('GET', '/');
        $this->assertEquals(200, $response->status());
    }
    function testSearch(){
        $response = $this->call('GET', '/?q=rjf');
        $this->assertEquals(200, $response->status());

//        $response = $this->get(route('home'));
//
//        $response->assertResponseStatus(200);
////        $response->assertViewIs('index');
//
//        $response = $this->get(route('create'));
//
//        $response->assertResponseStatus(200);
//        $response->assertViewIs('offer.create');
    }

}
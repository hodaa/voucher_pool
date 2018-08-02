<?php
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('verify',  ['uses' => 'VoucherApiController@verify']);
    $router->get('vouchers',  ['uses' => 'VoucherApiController@getVouchersByRecipient']);
});


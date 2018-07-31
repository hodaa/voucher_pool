<?php
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('verify',  ['uses' => 'VoucherController@verify']);
    $router->get('vouchers',  ['uses' => 'VoucherController@getVouchersByRecipient']);
});


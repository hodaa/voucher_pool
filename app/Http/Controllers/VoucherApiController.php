<?php

namespace App\Http\Controllers;

use App\Services\VoucherService;
use App\Traits\Payload;
use Illuminate\Http\Request;

class VoucherApiController
{
    private $voucherService;
    use Payload;


    public function __construct(VoucherService $voucherService)
    {
        $this->voucherService = $voucherService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(Request $request)
    {
        return $this->voucherService->verifyVoucherCode($request);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function getVouchersByRecipient(Request $request)
    {
       return  $this->voucherService->getVoucherByEmail($request);

    }
}

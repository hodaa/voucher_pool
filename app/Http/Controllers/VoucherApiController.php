<?php

namespace App\Http\Controllers;

use App\Services\VoucherService;
use App\Traits\Payload;
use Illuminate\Http\Request;
use Validator;

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
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'code' => 'required|min:6'
        ]);
        $errors = $validator->errors();
        if (count($errors)) {
            return $this->fail(422, $errors->all());
        }

        $offer = $this->voucherService->verifyVoucherCode($request->all());
        if ($offer) {
            return $this->success(200, ["offer_discount" => $offer]);
        } else {
            return $this->fail(500, "This Voucher is Invalid");
        }

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function getVouchersByRecipient(Request $request)
    {
        return $this->voucherService->getVoucherByEmail($request);

    }
}

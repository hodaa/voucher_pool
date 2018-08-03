<?php

namespace App\Http\Controllers;

use App\Traits\Payload;
use App\Repositories\VoucherRepo;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Validator;

class VoucherApiController
{
    private $voucherRepo;
    use Payload;


    public function __construct(VoucherRepo $voucherRepo)
    {
        $this->voucherRepo = $voucherRepo;
    }


    /** verfiy that this code is still valid to this recipient
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
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

        $voucher = $this->voucherRepo->verifyVoucherCode($request);
        if ($voucher !== null) {
            $voucher->update(['used_on' => Carbon::now()]);
            $discount = $voucher->offer->discount;
            echo $this->success(200, ["offer_discount" => $discount]);
        } else {
            echo $this->fail(500, "This Voucher is not  valid");
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function getVouchersByRecipient(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        $errors = $validator->errors();
        if (count($errors)) {
            return $this->fail(422, $errors->all());
        }
        $codes = $this->voucherRepo->getVoucherByEmail($request);
        if (count($codes)) {
            return $this->success(200, $codes);
        } else {
            return $this->fail(404, "No Codes Valid for this Recipients");
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Traits\Payload;
use App\Repositories\VoucherRepo;
use Illuminate\Http\Request;

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
        $this->validateApi($request->all(), [
            'email' => 'required|email',
            'code' => 'required|min:6'
        ]);

        $voucher = $this->voucherRepo->verifyVoucherCode($request);
        if ($voucher !== null) {
            $voucher->update(['used_on' => Carbon::now()]);
            $discount = $voucher->offer->discount;
            echo $this->success(200, ["offer_discount" => $discount]);
        } else {
            echo $this->fail(500, "This Voucher is not  valid");
        }

    }

    /** get all vouchers by  for recipients  by email
     * @param Request $request
     */

    public function getVouchersByRecipient(Request $request)
    {
        $this->voucherRepo->validateApi($request->all(), [
            'email' => 'required|email',
        ]);
        $codes = $this->voucherRepo->getVoucherByEmail($request);
        if (count($codes)) {
            return $this->success(200, $codes);
        } else {
            return $this->fail(404, "No Codes Valid for this Recipients");
        }
    }

}
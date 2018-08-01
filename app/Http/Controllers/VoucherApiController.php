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
        echo $this->voucherRepo->verifyVoucherCode($request);
    }

    /** get all vouchers by  for recipients  by email
     * @param Request $request
     */
    public function getVouchersByRecipient(Request $request)
    {
        $codes = $this->voucherRepo->getVoucherByEmail($request);
        if (count($codes)) {
            return $this->success(200, $codes);
        } else {
            return $this->fail(404, "No Codes Valid for this Recipients");
        }
    }

}
<?php

namespace App\Http\Controllers;

use App\Traits\Payload;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Http\Repositories\VoucherRepo;

class VoucherController extends BaseController
{
    private $voucherRepo;
    use Payload;


    public function __construct(VoucherRepo $voucherRepo)
    {
        $this->voucherRepo = $voucherRepo;
    }


    /**get data to be viewed in home page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = $this->voucherRepo->getVoucherStatistics();
        $data['codes'] = $this->voucherRepo->getAllVouchers();

        return view('index', ["data" => $data]);
    }


    /** go to add page to add voucher codes
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $offers = $this->voucherRepo->getAllOffers();
        return view('add', ["offers" => $offers]);
    }


    /** ​ generate​ ​ for​ ​ each​ ​ Recipient​ ​ a Voucher​ ​ Code
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function save(Request $request)
    {
//
//        throw new HttpResponseException(response()->json( $this->validate($request, [
//            'expire_date' => 'required|date_format:d-m-Y',
//        ]), 422));
//        $this->validate($request, [
//            'expire_date' => 'required|date_format:d-m-Y',
//        ]);
        //$request->session()->flash('status', 'Task was successful!');

        //ensure that same voucher not created for same expire-date same product

        $created = $this->voucherRepo->createVoucherCode($request);
//
////        $request->session()->reflash();
////        $request->session()->flash('status', 'Task was successful!');
//
////        \Session::flash('flash_message', $created . ' Voucher Code Created Successfully');
//        return redirect('/');
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
            return $this->fail(200, "No Codes Valid for this Recipients");
        }
    }
}

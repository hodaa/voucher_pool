<?php

namespace App\Http\Controllers;

use App\Traits\Payload;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Repositories\VoucherRepo;
use Validator;

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


    /** ​ generate​ ​ for​ ​ each​ ​ Recipient​ ​ a Voucher​ ​ Codes
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'expire_date' => 'required|date_format:d-m-Y',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->route('create', ['errors' => $errors->all()]);
        }

        $created=$this->voucherRepo->createVoucherCode($request);
        if($created){
            return redirect()->route('home', ['created' => $created]);
        }
    }
}

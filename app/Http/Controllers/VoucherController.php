<?php

namespace App\Http\Controllers;

use App\Traits\Payload;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Validator;
use App\Services\VoucherService;

class VoucherController extends BaseController
{
    private $voucherService;
    use Payload;


    public function __construct(VoucherService $voucherService)
    {
        $this->voucherService = $voucherService;
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $search='';
        if($request->input('q')){
            $search= $request->input('q');
        }
        $data = $this->voucherService->getVoucherStatistics();
        $data['codes'] = $this->voucherService->getAllVouchers($search);

        return view('index', ["data" => $data]);
    }


    /** go to add page to add voucher codes
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $offers = $this->voucherService->getAllOffers();
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

        $created=$this->voucherService->createVoucherCode($request);
        if($created){
            return redirect()->route('home', ['created' => $created]);
        }
    }
}

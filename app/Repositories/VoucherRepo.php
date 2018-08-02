<?php

namespace App\Repositories;

use App\Models\VoucherCode;
use App\Models\Recipient;
use App\Models\Offer;
use Carbon\Carbon;
use Laravel\Lumen\Routing\ProvidesConvenienceMethods;
use App\Traits\Payload;
use Validator;


class VoucherRepo
{
    use ProvidesConvenienceMethods, Payload;

    /**
     * @return mixed
     */
    public function getVoucherStatistics()
    {
        $data['total_vouchers'] = VoucherCode::get()->count();
        $data['used_vouchers'] = VoucherCode::whereNotNull('used_on')->get()->count();
        $data['unused_vouchers'] = (int)$data['total_vouchers'] - (int)$data['used_vouchers'];

        return $data;
    }


    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllVouchers()
    {
        return VoucherCode::with('recipient')->paginate(10);
    }


    /**
     * @return mixed
     */
    public function getAllOffers()
    {
        return Offer::pluck("name", "id");
    }

    /**
     * @return bool|string
     */
    public function generateCode()
    {
        $better_token = md5(uniqid(rand(), true));
        $unique_code = substr($better_token, 24);
        return $unique_code;
    }

    /**create Voucher codes for each recipients
     * @param $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createVoucherCode($request)
    {
        $recipients = Recipient::pluck('id');

        $data = [];
        foreach ($recipients as $key => $user) {
            $data[$key]['recipient_id'] = $user;
            $data[$key]['code'] = $this->generateCode();
            $data[$key]['offer_id'] = $request['offer_id'];
            $data[$key]['expire_date'] = $request['expire_date'];

            $data[$key]['created_at'] = Carbon::now()->toDateTimeString();
            $data[$key]['updated_at'] = Carbon::now()->toDateTimeString();
        }
        $code = new VoucherCode;
        return $code->insert($data);
    }


    /**
     * @param $request
     */
    public function verifyVoucherCode($request)
    {
        $code = $request->input('code');
        $email = $request->input('email');
        $voucher = VoucherCode::with('offer')->where('code', $code)
            ->whereNull('used_on')
            ->whereHas('recipient', function ($q) use ($email) {
                $q->where('email', $email);
            })->first();

        return $voucher;

    }


    /**
     * @param $request
     * @param $rules
     */
    public function validateApi($request, $rules)
    {
        $validator = Validator::make($request, $rules);
        $errors = $validator->errors();
        $errors = $errors->all();
        if (count($errors)) {
            echo $this->fail(422, $errors);
            exit();
        }
    }

    /**
     * @param $request
     * @return VoucherCode[]|\Illuminate\Database\Eloquent\Builder[]
     * |\Illuminate\Database\Eloquent\Collection|
     * \Illuminate\Support\Collection
     */
    public function getVoucherByEmail($request)
    {

        $email = $request->input('email');
        $codes = VoucherCode::with('offer')->whereHas('recipient', function ($q) use ($email) {
            $q->where('email', $email);
        })->where('expire_date', '<', Carbon::now())->get()->map(function ($item) {
            $result['code'] = $item->code;
            $result['offer_name'] = $item->offer->name;
            return $result;
        });

        return $codes;
    }
}

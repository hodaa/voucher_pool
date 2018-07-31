<?php

namespace App\Http\Repositories;

use App\Models\VoucherCode;
use App\Models\Recipient;
use App\Models\Offer;
use Carbon\Carbon;
use Laravel\Lumen\Routing\ProvidesConvenienceMethods;
use App\Traits\Payload;
use Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Exceptions\HttpResponseException;

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

    public function createVoucherCode($request)
    {
        $request = $request->all();
        $validator = Validator::make($request, [
            'expire_date' => 'required|date_format:d-m-Y',
        ]);


        if ($validator->fails()) {
            $errors = $validator->errors();
            $errors = $errors->all();
            return redirect()->route('profile', ['errors' => $errors]);
        }

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


    public function verifyVoucherCode($data)
    {
        $validator = Validator::make($data, [
            'email' => 'required|email',
            'code' => 'required|max:12',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $code = $data->input('code');
        $email = $data->input('email');
        $voucher = VoucherCode::with('offer')->where('code', $code)->
        whereNull('used_on')->
        whereHas('recipient', function ($q) use ($email) {
            $q->where('email', $email);
        })->first();

        if ($voucher !== null) {
            $voucher->update(['usedOn' => Carbon::now()]);
            $discount = $voucher->offer->discount;


            echo $this->success(200, $discount);
        } else {
            return response()->json(['status' => 'error', 'message' => "No Vouchers for this email"], 500);
        }
    }


    public function validateApi($request, $rules)
    {
        $validator = Validator::make($request, $rules);
        $errors = $validator->errors();
        $errors = $errors->all();
        if (count($errors)) {
            echo $this->fail(400, $errors);
            exit();
        }
    }

    public function getVoucherByEmail($request)
    {
        $this->validateApi($request->all(), [
            'email' => 'required|email',
        ]);
        $email = $request->input('email');
        $codes = VoucherCode::whereHas('recipient', function ($q) use ($email) {
            $q->where('email', $email);
        })->where('expire_date', '<', Carbon::now())->pluck('code');

        return $codes;
    }
}

<?php

namespace App\Services;

use App\Repositories\VoucherRepo;

class VoucherService
{
    private $voucherRepo;

    function __construct(VoucherRepo $voucherRepo)
    {
        $this->voucherRepo = $voucherRepo;

    }

    /**
     * @return mixed
     */
    function getVoucherStatistics()
    {
        return $this->voucherRepo->getVoucherStatistics();

    }

    /**
     * @param $search
     * @return \App\Models\VoucherCode|
     * \Illuminate\Contracts\Pagination\LengthAwarePaginator|
     * \Illuminate\Database\Eloquent\Builder
     */
    function getAllVouchers($search)
    {
        return $this->voucherRepo->getAllVouchers($search);
    }

    /**
     * @return mixed
     */
    function getAllOffers()
    {
        return $this->voucherRepo->getAllOffers();
    }

    /**
     * @param $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function createVoucherCode($request)
    {
        return $this->voucherRepo->createVoucherCode($request);
    }

    /**
     * @param $request
     * @return \Illuminate\Database\Eloquent\Model|null|object|static
     */
    function verifyVoucherCode($request)
    {
        return $this->voucherRepo->verifyVoucherCode($request);
    }

    /**
     * @param $request
     * @return \App\Models\VoucherCode[]|\Illuminate\Database\Eloquent\Builder[]
     */
    function getVoucherByEmail($request)
    {
        return $this->voucherRepo->getVoucherByEmail($request);
    }

}

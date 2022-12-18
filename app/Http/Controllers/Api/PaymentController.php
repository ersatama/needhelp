<?php

namespace App\Http\Controllers\Api;

use App\Domain\Services\PaymentService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Payment\PaymentCollection;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected PaymentService $paymentService;
    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService   =   $paymentService;
    }

    /**
     * get - Payment
     *
     * @group Payment
     */
    public function get(): PaymentCollection
    {
        return new PaymentCollection($this->paymentService->paymentRepository->get());
    }
}

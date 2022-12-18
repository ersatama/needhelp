<?php

namespace App\Domain\Services;

use App\Domain\Repositories\Payment\PaymentRepositoryInterface;

class PaymentService extends Service
{
    public PaymentRepositoryInterface $paymentRepository;
    public function __construct(PaymentRepositoryInterface $paymentRepository)
    {
        $this->paymentRepository    =   $paymentRepository;
    }
}

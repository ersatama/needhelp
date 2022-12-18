<?php

namespace App\Domain\Repositories\Payment;

use App\Domain\Repositories\RepositoryEloquent;
use App\Models\Payment;

class PaymentRepositoryEloquent implements PaymentRepositoryInterface
{
    use RepositoryEloquent;
    protected Payment $model;
    public function __construct(Payment $payment)
    {
        $this->model    =   $payment;
    }
}

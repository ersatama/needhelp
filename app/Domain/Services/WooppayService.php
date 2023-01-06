<?php

namespace App\Domain\Services;

use App\Domain\Contracts\Contract;
use App\Domain\Repositories\Wooppay\WooppayRepositoryInterface;
use App\Models\Question;

class WooppayService extends Service
{
    public WooppayRepositoryInterface $wooppayRepository;
    public function __construct(WooppayRepositoryInterface $wooppayRepository)
    {
        $this->wooppayRepository    =   $wooppayRepository;
    }

    public function invoiceCreate(Question $question, array $invoice)
    {
        return $this->wooppayRepository->create([
            Contract::QUESTION_ID       =>  $question->{Contract::ID},
            Contract::OPERATION_ID      =>  $invoice[Contract::RESPONSE][Contract::OPERATION_ID],
            Contract::INVOICE_ID        =>  $invoice[Contract::RESPONSE][Contract::INVOICE_ID],
            Contract::KEY               =>  $invoice[Contract::RESPONSE][Contract::KEY],
            Contract::REPLENISHMENT_ID  =>  $invoice[Contract::RESPONSE][Contract::REPLENISHMENT_ID],
            Contract::URL               =>  $invoice[Contract::OPERATION_URL],
            Contract::STATUS            =>  true
        ]);
    }
}

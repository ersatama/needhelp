<?php

namespace App\Domain\Helpers;

use App\Domain\Contracts\Contract;
use App\Domain\Services\PaymentService;
use App\Domain\Services\TemporaryVariableService;
use App\Models\Payment;
use App\Models\Question;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class Wooppay
{
    const PAYMENT_ID    =   1;
    protected PaymentService $paymentService;
    protected TemporaryVariableService $temporaryVariableService;

    public function __construct(PaymentService $paymentService, TemporaryVariableService $temporaryVariableService)
    {
        $this->paymentService           =   $paymentService;
        $this->temporaryVariableService =   $temporaryVariableService;
    }

    public function auth(Payment $payment): bool|array
    {
        $key        =   $payment->{Contract::LOGIN}.'-'.$payment->{Contract::PASSWORD};
        $wooppay    =   $this->temporaryVariableService->temporaryVariableRepository->firstByKey($key);
        if ($wooppay && strtotime($wooppay->{Contract::EXPIRE_AT}) > time()) {
            return json_decode($wooppay->{Contract::VALUE}, true);
        } else {
            try {
                $auth   =   Curl::withOpt($this->requestBody(config('wooppay.auth'),[
                    'Content-Type: application/json'
                ],[
                    Contract::LOGIN     =>  $payment->{Contract::LOGIN},
                    Contract::PASSWORD  =>  $payment->{Contract::PASSWORD}
                ]));
                Log::info('wooppay helper auth', [$auth]);
                $auth   =   json_decode($auth, true);
                if ($auth && array_key_exists(Contract::LOGIN, $auth) && array_key_exists(Contract::TOKEN, $auth)) {
                    if ($wooppay) {
                        $this->temporaryVariableService->temporaryVariableRepository->update($wooppay->{Contract::ID},[
                            Contract::VALUE =>  json_encode([
                                Contract::LOGIN =>  $auth[Contract::LOGIN],
                                Contract::TOKEN =>  $auth[Contract::TOKEN]
                            ]),
                            Contract::EXPIRE_AT =>  Carbon::now()->addHours(12)
                        ]);
                    } else {
                        $this->temporaryVariableService->temporaryVariableRepository->create([
                            Contract::KEY   =>  $key,
                            Contract::VALUE =>  json_encode([
                                Contract::LOGIN =>  $auth[Contract::LOGIN],
                                Contract::TOKEN =>  $auth[Contract::TOKEN]
                            ]),
                            Contract::EXPIRE_AT =>  Carbon::now()->addHours(12)
                        ]);
                    }
                    return $auth;
                }

            } catch (Exception $exception) {
                Log::info('wooppay helper', [$exception->getMessage()]);
            }
        }
        return false;
    }

    public function invoice(Question $question, User $user): bool|array
    {
        if ($wooppay = $this->auth($this->paymentService->paymentRepository->firstById(self::PAYMENT_ID))) {
            try {
                $invoice    =   Curl::withOpt($this->requestBody(config('wooppay.create'),[
                    'Authorization: '.$wooppay[Contract::TOKEN],
                    'Content-Type: application/json'
                ],[
                    Contract::MERCHANT_NAME     =>  $wooppay[Contract::LOGIN],
                    Contract::REFERENCE_ID      =>  config('wooppay.prefix') . '-' . $question->{Contract::ID},
                    Contract::AMOUNT            =>  $question->{Contract::PRICE},
                    Contract::USER_PHONE        =>  $user->{Contract::PHONE},
                    Contract::CARD_FORBIDDEN    =>  config('wooppay.card_forbidden'),
                    Contract::REQUEST_URL       =>  config('wooppay.request_url') . '?' . Contract::ID . '=' . $question->{Contract::ID},
                    Contract::BACK_URL          =>  config('wooppay.back_url'),
                    Contract::DESCRIPTION       =>  config('wooppay.description'),
                    Contract::OPTION            =>  config('wooppay.option'),
                    Contract::DEATH_DATE        =>  date('Y-m-d H:i:s', strtotime("+1 day")),
                ]));
                $invoice    =   json_decode($invoice, true);
                if ($invoice && array_key_exists(Contract::OPERATION_URL, $invoice) && array_key_exists(Contract::RESPONSE, $invoice)) {
                    return $invoice;
                }
            } catch (Exception $exception) {

            }
        }
        return false;
    }

    public function status(\App\Models\Wooppay $wooppayModel)
    {
        if ($wooppay = $this->auth($this->paymentService->paymentRepository->firstById(self::PAYMENT_ID))) {
            try {
                $status =   Curl::withOpt($this->requestBody(config('wooppay.status'),[
                    'Authorization: '.$wooppay[Contract::TOKEN],
                    'Content-Type: application/json'
                ],[
                    Contract::OPERATION_IDS =>  [$wooppayModel->{Contract::OPERATION_ID}]
                ]));
                Log::info('wooppay-answer', [$status]);
                if ($status = json_decode($status, true)) {
                    if (sizeof($status) > 0) {
                        return $status[0];
                    }
                } else {

                }
            } catch (Exception $exception) {

            }
        }
        return false;
    }

    public function requestBody($url, $header, $fields): array
    {
        return [
            CURLOPT_URL             =>  $url,
            CURLOPT_RETURNTRANSFER  =>  true,
            CURLOPT_ENCODING        =>  '',
            CURLOPT_MAXREDIRS       =>  10,
            CURLOPT_TIMEOUT         =>  0,
            CURLOPT_FOLLOWLOCATION  =>  true,
            CURLOPT_HTTP_VERSION    =>  CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST   =>  'POST',
            CURLOPT_POSTFIELDS      =>  json_encode($fields),
            CURLOPT_HTTPHEADER      =>  $header,
        ];
    }
}

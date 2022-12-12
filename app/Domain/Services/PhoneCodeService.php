<?php

namespace App\Domain\Services;

use App\Domain\Contracts\Contract;
use App\Domain\Repositories\PhoneCode\PhoneCodeRepositoryInterface;

class PhoneCodeService extends Service
{
    public PhoneCodeRepositoryInterface $phoneCodeRepository;
    public function __construct(PhoneCodeRepositoryInterface $phoneCodeRepository)
    {
        $this->phoneCodeRepository  =   $phoneCodeRepository;
    }

    public function getCodeByPhone($phone)
    {
        $phoneCode  =   $this->phoneCodeRepository->firstByPhone($phone);
        return $phoneCode->{Contract::CODE};
    }
}

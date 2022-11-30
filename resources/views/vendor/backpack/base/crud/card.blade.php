@php
    use Carbon\Carbon;
@endphp
@if($question->{\App\Domain\Contracts\Contract::IS_PAID})
    @if($question->{\App\Domain\Contracts\Contract::STATUS} === 2)
        <div class="row">
            <div class="col-8">
                <div class="card text-white bg-success">
                    <div class="card-header">
                        <span class="text-muted">@if($question->{\App\Domain\Contracts\Contract::IS_IMPORTANT}) <span class="font-weight-bold"><u>Срочный вопрос</u></span> @else Вопрос @endif #{{ $question->{\App\Domain\Contracts\Contract::ID} }} • {{  Carbon::createFromTimeStamp(strtotime($question->{\App\Domain\Contracts\Contract::CREATED_AT}))->diffForHumans() }}</span> • <a href="/user/{{ $user->{\App\Domain\Contracts\Contract::ID} }}/show" class="card-link text-white"><u>{{ $user->{\App\Domain\Contracts\Contract::NAME} }} {{ $user->{\App\Domain\Contracts\Contract::SURNAME} }}</u></a> • <span class="text-muted">Отвечено</span>@if($question->{\App\Domain\Contracts\Contract::PAYMENT_ID}) • <span class="text-muted">{{ $question->{\App\Domain\Contracts\Contract::PAYMENT_ID} }}</span> @endif
                    </div>
                    <div class="card-body">
                        <h6 class="card-title">{{ $question->{\App\Domain\Contracts\Contract::DESCRIPTION} }}</h6>
                        <p class="card-text font-weight-bold">{{ $question->{\App\Domain\Contracts\Contract::ANSWER} }}</p>
                    </div>
                    <div class="card-footer text-white">
                        <span class="text-muted">{{ Carbon::createFromTimeStamp(strtotime($question->{\App\Domain\Contracts\Contract::ANSWERED_AT}))->diffForHumans() }}</span> • <a href="/lawyer/{{ $lawyer->{\App\Domain\Contracts\Contract::ID} }}/show" class="card-link text-white"><u>{{ $lawyer->{\App\Domain\Contracts\Contract::NAME} }} {{ $lawyer->{\App\Domain\Contracts\Contract::SURNAME} }}</u></a> • {{ $question->{\App\Domain\Contracts\Contract::PRICE} }} KZT
                    </div>
                </div>
            </div>
        </div>
    @elseif($question->{\App\Domain\Contracts\Contract::STATUS} === 1)
        <div class="row">
            <div class="col-8">
                <div class="card text-white bg-info">
                    <div class="card-header">
                        <span class="text-muted">@if($question->{\App\Domain\Contracts\Contract::IS_IMPORTANT}) <span class="font-weight-bold"><u>Срочный вопрос</u></span> @else Вопрос @endif #{{ $question->{\App\Domain\Contracts\Contract::ID} }} • {{  Carbon::createFromTimeStamp(strtotime($question->{\App\Domain\Contracts\Contract::CREATED_AT}))->diffForHumans() }}</span> • <a href="/user/{{ $user->{\App\Domain\Contracts\Contract::ID} }}/show" class="card-link text-white"><u>{{ $user->{\App\Domain\Contracts\Contract::NAME} }} {{ $user->{\App\Domain\Contracts\Contract::SURNAME} }}</u></a> • <span class="text-muted">Ждет ответа</span>@if($question->{\App\Domain\Contracts\Contract::PAYMENT_ID}) • <span class="text-muted">{{ $question->{\App\Domain\Contracts\Contract::PAYMENT_ID} }}</span> @endif
                    </div>
                    <div class="card-body">
                        <h6 class="card-title">{{ $question->{\App\Domain\Contracts\Contract::DESCRIPTION} }}</h6>
                    </div>
                </div>
            </div>
        </div>
    @elseif($question->{\App\Domain\Contracts\Contract::STATUS} === 0)
        <div class="row">
            <div class="col-8">
                <div class="card text-white bg-danger">
                    <div class="card-header">
                        <span class="text-muted">@if($question->{\App\Domain\Contracts\Contract::IS_IMPORTANT}) <span class="font-weight-bold"><u>Срочный вопрос</u></span> @else Вопрос @endif #{{ $question->{\App\Domain\Contracts\Contract::ID} }} • {{  Carbon::createFromTimeStamp(strtotime($question->{\App\Domain\Contracts\Contract::CREATED_AT}))->diffForHumans() }}</span> • <a href="/user/{{ $user->{\App\Domain\Contracts\Contract::ID} }}/show" class="card-link text-white"><u>{{ $user->{\App\Domain\Contracts\Contract::NAME} }} {{ $user->{\App\Domain\Contracts\Contract::SURNAME} }}</u></a> • <span class="text-muted">отменен</span>@if($question->{\App\Domain\Contracts\Contract::PAYMENT_ID}) • <span class="text-muted">{{ $question->{\App\Domain\Contracts\Contract::PAYMENT_ID} }}</span> @endif
                    </div>
                    <div class="card-body">
                        <h6 class="card-title">{{ $question->{\App\Domain\Contracts\Contract::DESCRIPTION} }}</h6>
                    </div>
                </div>
            </div>
        </div>
    @endif

@else
    <div class="row">
        <div class="col-8">
            <div class="card bg-light text-dark">
                <div class="card-header">
                    <span class="text-muted">@if($question->{\App\Domain\Contracts\Contract::IS_IMPORTANT}) <span class="font-weight-bold"><u>Срочный вопрос</u></span> @else Вопрос @endif #{{ $question->{\App\Domain\Contracts\Contract::ID} }} • {{  Carbon::createFromTimeStamp(strtotime($question->{\App\Domain\Contracts\Contract::CREATED_AT}))->diffForHumans() }}</span> • <a href="/user/{{ $user->{\App\Domain\Contracts\Contract::ID} }}/show" class="card-link text-dark"><u>{{ $user->{\App\Domain\Contracts\Contract::NAME} }} {{ $user->{\App\Domain\Contracts\Contract::SURNAME} }}</u></a> • <span class="text-muted">не оплачено</span>@if($question->{\App\Domain\Contracts\Contract::PAYMENT_ID}) • <span class="text-muted">{{ $question->{\App\Domain\Contracts\Contract::PAYMENT_ID} }}</span> @endif
                </div>
                <div class="card-body">
                    <h6 class="card-title">{{ $question->{\App\Domain\Contracts\Contract::DESCRIPTION} }}</h6>
                </div>
            </div>
        </div>
    </div>
@endif

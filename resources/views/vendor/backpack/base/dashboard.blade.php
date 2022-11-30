@extends(backpack_view('blank'))
@php
    use App\Domain\Repositories\User\UserRepositoryEloquent;
    use App\Domain\Repositories\Notification\NotificationRepositoryEloquent;
    use App\Domain\Contracts\Contract;
@endphp
@if(backpack_user()->{\App\Domain\Contracts\Contract::ROLE} === \App\Domain\Contracts\Contract::ADMIN)
    @php

        $widgets['before_content'][]    =   [
        'type'    => 'div',
        'class'   => 'row',
        'content' => [
                [
                    'type'          => 'progress_white',
                    'class'         => 'card mb-2',
                    'value'         =>  '<span class="text-primary">' . UserRepositoryEloquent::count([]) . '</span>',
                    'description'   => 'Пользователи',
                    'progress'      => 100, // integer
                    'progressClass' => 'progress-bar bg-primary',
                    'hint'          => UserRepositoryEloquent::countLastMonth() . ' пользователя за последний 30 дней',
                ],
                [
                    'type'          => 'progress_white',
                    'class'         => 'card mb-2',
                    'value'         =>  '<span class="text-primary">' . UserRepositoryEloquent::count([\App\Domain\Contracts\Contract::ROLE=>\App\Domain\Contracts\Contract::LAWYER]) . '</span>',
                    'description'   => 'Адвокаты',
                    'progress'      => 100, // integer
                    'progressClass' => 'progress-bar bg-primary',
                    'hint'          => UserRepositoryEloquent::countLastMonth([\App\Domain\Contracts\Contract::ROLE=>\App\Domain\Contracts\Contract::LAWYER]) . ' адвокат(a) за последний 30 дней',
                ],
                [
                    'type'          => 'progress_white',
                    'class'         => 'card mb-2',
                    'value'         =>  '<span class="text-primary">' . UserRepositoryEloquent::count([\App\Domain\Contracts\Contract::GENDER=>\App\Domain\Contracts\Contract::MALE]) . '</span>',
                    'description'   => 'Мужчины',
                    'progress'      => 100, // integer
                    'progressClass' => 'progress-bar bg-primary',
                    'hint'          => UserRepositoryEloquent::countLastMonth([\App\Domain\Contracts\Contract::GENDER=>\App\Domain\Contracts\Contract::MALE]) . ' мужчин за последний 30 дней',
                ],
                [
                    'type'          => 'progress_white',
                    'class'         => 'card mb-2',
                    'value'         =>  '<span class="text-primary">' . UserRepositoryEloquent::count([\App\Domain\Contracts\Contract::GENDER=>\App\Domain\Contracts\Contract::FEMALE]) . '</span>',
                    'description'   => 'Женщины',
                    'progress'      => 100, // integer
                    'progressClass' => 'progress-bar bg-primary',
                    'hint'          => UserRepositoryEloquent::countLastMonth([\App\Domain\Contracts\Contract::GENDER=>\App\Domain\Contracts\Contract::FEMALE]) . ' женщин за последний 30 дней',
                ],

            ],
        ];
        $widgets['before_content'][]    =   [
        'type'    => 'div',
        'class'   => 'row',
        'content' => [
                [
                    'type'          => 'progress_white',
                    'class'         => 'card mb-2',
                    'value'         =>  '<span class="text-danger">' . NotificationRepositoryEloquent::count([]) . '</span>',
                    'description'   => 'Запросы',
                    'progress'      => 100, // integer
                    'progressClass' => 'progress-bar bg-danger',
                    'hint'          => NotificationRepositoryEloquent::countLastMonth([]) . ' Запроса за последний 30 дней',
                ],
                [
                    'type'          => 'progress_white',
                    'class'         => 'card mb-2',
                    'value'         =>  '<span class="text-danger">' . NotificationRepositoryEloquent::count([\App\Domain\Contracts\Contract::STATUS=>1]) . '</span>',
                    'description'   => 'В обработке',
                    'progress'      => 100, // integer
                    'progressClass' => 'progress-bar bg-danger',
                    'hint'          => NotificationRepositoryEloquent::countLastMonth([\App\Domain\Contracts\Contract::STATUS=>1]) . ' запроса за последний 30 дней',
                ],
                [
                    'type'          => 'progress_white',
                    'class'         => 'card mb-2',
                    'value'         =>  '<span class="text-danger">' . NotificationRepositoryEloquent::count([\App\Domain\Contracts\Contract::STATUS=>2]) . '</span>',
                    'description'   => 'Закрыто',
                    'progress'      => 100, // integer
                    'progressClass' => 'progress-bar bg-danger',
                    'hint'          => NotificationRepositoryEloquent::countLastMonth([\App\Domain\Contracts\Contract::STATUS=>2]) . ' запроса за последний 30 дней',
                ],
                [
                    'type'          => 'progress_white',
                    'class'         => 'card mb-2',
                    'value'         =>  '<span class="text-danger">' . NotificationRepositoryEloquent::count([\App\Domain\Contracts\Contract::STATUS=>0]) . '</span>',
                    'description'   => 'Отменен',
                    'progress'      => 100, // integer
                    'progressClass' => 'progress-bar bg-danger',
                    'hint'          => NotificationRepositoryEloquent::countLastMonth([\App\Domain\Contracts\Contract::STATUS=>0]) . ' запроса за последний 30 дней',
                ],
            ],
        ];
        $widgets['before_content'][]    =   [
        'type'    => 'div',
        'class'   => 'row',
        'content' => [
                [
                    'type'          => 'progress_white',
                    'class'         => 'card mb-2',
                    'value'         =>  '<span class="text-success">' . NotificationRepositoryEloquent::sum(Contract::PRICE,[Contract::LAWYER_ID=>backpack_user()->{Contract::ID},Contract::IS_PAID=>true]) . ' KZT</span>',
                    'description'   => 'Сумма всех оплат',
                    'progress'      => 100, // integer
                    'progressClass' => 'progress-bar bg-success',
                    'hint'          => NotificationRepositoryEloquent::sumLastMonth(Contract::PRICE,[Contract::LAWYER_ID=>backpack_user()->{Contract::ID},Contract::IS_PAID=>true]) . ' KZT Сумма за последний 30 дней',
                ],
            ],
        ];
    @endphp
@else
    @php
        $widgets['before_content'][]    =   [
        'type'    => 'div',
        'class'   => 'row',
        'content' => [
                [
                    'type'          => 'progress_white',
                    'class'         => 'card mb-2',
                    'value'         =>  '<span class="text-success">' . NotificationRepositoryEloquent::sum(Contract::PRICE,[Contract::IS_PAID=>true,Contract::LAWYER_ID=>backpack_user()->{Contract::ID}]) . ' KZT</span>',
                    'description'   => 'Сумма всех оплат',
                    'progress'      => 100, // integer
                    'progressClass' => 'progress-bar bg-success',
                    'hint'          => NotificationRepositoryEloquent::sumLastMonth(Contract::PRICE,[Contract::IS_PAID=>true,Contract::LAWYER_ID=>backpack_user()->{Contract::ID}]) . ' KZT Сумма за последний 30 дней',
                ],
            ],
        ];
    @endphp
@endif

@section('content')
@endsection

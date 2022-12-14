@extends(backpack_view('blank'))
@php
    use App\Domain\Repositories\User\UserRepositoryEloquent;
    use App\Domain\Repositories\Question\QuestionRepositoryEloquent;
    use App\Domain\Contracts\Contract;
    use App\Charts\UserChart;
@endphp

@section('content')
    @if(backpack_user()->{\App\Domain\Contracts\Contract::ROLE} === \App\Domain\Contracts\Contract::ADMIN)
        @php
            $widgets['before_content'][]    =   [
            'type'    => 'div',
            'class'   => 'row',
            'content' => [
                    [
                        'type'          => 'progress_white',
                        'class'         => 'card mb-2',
                        'wrapper'       =>  ['class' => 'col-sm-3'],
                        'value'         =>  '<span class="text-primary">' . UserRepositoryEloquent::count([]) . '</span>',
                        'description'   => 'Все пользователи',
                        'progress'      => 100, // integer
                        'progressClass' => 'progress-bar bg-primary',
                    ],
                    [
                        'type'          => 'progress_white',
                        'class'         => 'card mb-2',
                        'wrapper'       =>  ['class' => 'col-sm-3'],
                        'value'         =>  '<span class="text-primary">' . UserRepositoryEloquent::count([Contract::ROLE=>Contract::LAWYER]) . '</span>',
                        'description'   => 'Все юристы',
                        'progress'      => 100, // integer
                        'progressClass' => 'progress-bar bg-primary',
                    ],
                    [
                        'type'          => 'progress_white',
                        'class'         => 'card mb-2',
                        'wrapper'       =>  ['class' => 'col-sm-3'],
                        'value'         =>  '<span class="text-danger">' . QuestionRepositoryEloquent::count([]) . '</span>',
                        'description'   => 'Все вопросы',
                        'progress'      => 100, // integer
                        'progressClass' => 'progress-bar bg-danger',
                    ],
                                        [
                        'type'          => 'progress_white',
                        'class'         => 'card mb-2',
                        'wrapper'       =>  ['class' => 'col-sm-3'],
                        'value'         =>  '<span class="text-success">' . QuestionRepositoryEloquent::sum(Contract::PRICE,[Contract::IS_PAID=>true]) . ' KZT</span>',
                        'description'   => 'Сумма всех оплат',
                        'progress'      => 100, // integer
                        'progressClass' => 'progress-bar bg-success',
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
                        'value'         =>  '<span class="text-success">' . QuestionRepositoryEloquent::sum(Contract::PRICE,[Contract::IS_PAID=>true,Contract::LAWYER_ID=>backpack_user()->{Contract::ID}]) . ' KZT</span>',
                        'description'   => 'Сумма всех оплат',
                        'progress'      => 100, // integer
                        'progressClass' => 'progress-bar bg-success',
                        'hint'          => QuestionRepositoryEloquent::sumLastMonth(Contract::PRICE,[Contract::IS_PAID=>true,Contract::LAWYER_ID=>backpack_user()->{Contract::ID}]) . ' KZT Сумма за последний 30 дней',
                    ],
                ],
            ];
        @endphp
    @endif
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
    <script src="https://cdnjs.com/libraries/Chart.js"></script>
    <div class="row">
        <div class="col-12 col-lg-3">
            <div class="card mt-4">
                <div class="card-header text-center">
                    Зарегистрировано пользователи за последний 7 дней
                </div>
                <div class="card-body">
                    @php
                        $users      =   UserRepositoryEloquent::userLastWeek();
                    @endphp
                    <canvas id="user-last-week" width="400" height="220" aria-label="Hello ARIA World"
                            role="img"></canvas>
                    <script>
                        let data = [
                                @foreach( $users as &$user)
                            {
                                day: '{{ \Carbon\Carbon::parse($user['date'])->diffForHumans() }}',
                                count: {{ $user['count'] }}
                            },
                            @endforeach
                        ];
                        new Chart(
                            document.getElementById('user-last-week'),
                            {
                                type: 'line',
                                data: {
                                    labels: data.map(row => row.day),
                                    datasets: [{
                                        label: 'Зарегистрировано за последний 7 дней',
                                        data: data.map(row => row.count),
                                        fill: false,
                                        borderColor: 'rgb(124, 105, 239)',
                                        tension: 0.1
                                    }]
                                },
                            }
                        );
                    </script>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3">
            <div class="card mt-4">
                <div class="card-header text-center">
                    Зарегистрировано пользователи за последний 30 дней
                </div>
                <div class="card-body">
                    @php
                        $userMonth  =   UserRepositoryEloquent::userLastMonth();
                    @endphp
                    <canvas id="user-last-month" width="400" height="220"></canvas>
                    <script>
                        data = [
                            @foreach( $userMonth as &$user)
                            {
                                day: '{{ \Carbon\Carbon::parse($user['date'])->diffForHumans() }}',
                                count: {{ $user['count'] }}
                            },
                            @endforeach
                        ];
                        new Chart(
                            document.getElementById('user-last-month'),
                            {
                                type: 'line',
                                data: {
                                    labels: data.map(row => row.day),
                                    datasets: [{
                                        label: 'Зарегистрировано за последний 30 дней',
                                        data: data.map(row => row.count),
                                        fill: false,
                                        borderColor: 'rgb(124, 105, 239)',
                                        tension: 0.1
                                    }]
                                },
                            }
                        );
                    </script>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3">
            <div class="card mt-4">
                <div class="card-header text-center">
                    Зарегистрировано пользователи за последний 365 дней
                </div>
                <div class="card-body">
                    @php
                        $userYear   =   UserRepositoryEloquent::userLastYear();
                    @endphp
                    <canvas id="user-last-year" width="400" height="220"></canvas>
                    <script>
                        data = [
                                @foreach( $userYear as &$user)
                            {
                                day: '{{ $user['date'] }}',
                                count: {{ $user['count'] }}
                            },
                            @endforeach
                        ];
                        new Chart(
                            document.getElementById('user-last-year'),
                            {
                                type: 'line',
                                data: {
                                    labels: data.map(row => row.day),
                                    datasets: [{
                                        label: 'Зарегистрировано за последний 365 дней',
                                        data: data.map(row => row.count),
                                        fill: false,
                                        borderColor: 'rgb(124, 105, 239)',
                                        tension: 0.1
                                    }]
                                },
                            }
                        );
                    </script>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3">
            <div class="card mt-4">
                <div class="card-header text-center">
                    @php
                        $before =   date("Y-m-d", strtotime("-10 day"));
                        $after  =   date("Y-m-d");
                    @endphp
                    <span class="mr-4">{{ $before }} - {{ $after }}</span>
                    <button class="btn btn-primary ml-auto btn-sm p-0 px-2">
                        Выбрать дату
                    </button>
                </div>
                <div class="card-body">
                    @php
                        $userBetween    =   UserRepositoryEloquent::userDateBetween($before,$after);
                    @endphp
                    <canvas id="user-date-between" width="400" height="220"></canvas>
                    <script>
                        let start   =   '{{$before}}';
                        let end     =   '{{$after}}';
                        data = [
                            @foreach( $userBetween as &$user)
                            {
                                day: '{{ $user['date'] }}',
                                count: {{ $user['count'] }}
                            },
                            @endforeach
                        ];
                        new Chart(
                            document.getElementById('user-date-between'),
                            {
                                type: 'line',
                                data: {
                                    labels: data.map(row => row.day),
                                    datasets: [{
                                        label: 'Зар-но пользователи за период {{ $before }} - {{ $after }}',
                                        data: data.map(row => row.count),
                                        fill: false,
                                        borderColor: 'rgb(124, 105, 239)',
                                        tension: 0.1
                                    }]
                                },
                            }
                        );
                    </script>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-lg-3">
            <div class="card mt-3">
                <div class="card-header text-center">
                    Общая сумма за последний 7 дней (KZT)
                </div>
                <div class="card-body">
                    @php
                        $notifications  =   QuestionRepositoryEloquent::priceLastWeek();
                    @endphp
                    <canvas id="payment-last-week" width="400" height="220"
                            aria-label="Сумма выплат за последний 7 дней"></canvas>
                    <script>
                        let notifications = [
                                @foreach( $notifications as &$notification)
                            {
                                day: '{{ \Carbon\Carbon::parse($notification['date'])->diffForHumans() }}',
                                sum: {{ $notification['sum'] }}
                            },
                            @endforeach
                        ];
                        new Chart(
                            document.getElementById('payment-last-week'),
                            {
                                type: 'line',
                                data: {
                                    labels: notifications.map(row => row.day),
                                    datasets: [{
                                        label: 'Сумма выплат за последний 7 дней (KZT)',
                                        data: notifications.map(row => row.sum),
                                        fill: false,
                                        borderColor: 'rgb(75, 192, 192)',
                                        tension: 0.1
                                    }]
                                },
                            }
                        );
                    </script>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3">
            <div class="card mt-3">
                <div class="card-header text-center">
                    Общая сумма за последний 30 дней (KZT)
                </div>
                <div class="card-body">
                    @php
                        $notificationMonth  =   QuestionRepositoryEloquent::priceLastMonth();
                    @endphp
                    <canvas id="payment-last-month" width="400" height="220"
                            aria-label="Сумма выплат за последний 30 дней"></canvas>
                    <script>
                        notifications = [
                                @foreach( $notificationMonth as &$notification)
                            {
                                day: '{{ \Carbon\Carbon::parse($notification['date'])->diffForHumans() }}',
                                sum: {{ $notification['sum'] }}
                            },
                            @endforeach
                        ];
                        new Chart(
                            document.getElementById('payment-last-month'),
                            {
                                type: 'line',
                                data: {
                                    labels: notifications.map(row => row.day),
                                    datasets: [{
                                        label: 'Сумма выплат за последний 30 дней (KZT)',
                                        data: notifications.map(row => row.sum),
                                        fill: false,
                                        borderColor: 'rgb(75, 192, 192)',
                                        tension: 0.1
                                    }]
                                },
                            }
                        );
                    </script>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3">
            <div class="card mt-3">
                <div class="card-header text-center">
                    Общая сумма за последний 365 дней (KZT)
                </div>
                <div class="card-body">
                    @php
                        $notificationYear  =   QuestionRepositoryEloquent::priceLastYear();
                    @endphp
                    <canvas id="payment-last-year" width="400" height="220"
                            aria-label="Сумма выплат за последний 365 дней"></canvas>
                    <script>
                        notifications = [
                                @foreach( $notificationYear as &$notification)
                            {
                                day: '{{ $notification['date'] }}',
                                sum: {{ $notification['sum'] }}
                            },
                            @endforeach
                        ];
                        new Chart(
                            document.getElementById('payment-last-year'),
                            {
                                type: 'line',
                                data: {
                                    labels: notifications.map(row => row.day),
                                    datasets: [{
                                        label: 'Сумма выплат за последний 365 дней (KZT)',
                                        data: notifications.map(row => row.sum),
                                        fill: false,
                                        borderColor: 'rgb(75, 192, 192)',
                                        tension: 0.1
                                    }]
                                },
                            }
                        );
                    </script>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3">
            <div class="card mt-3">
                <div class="card-header text-center">
                    @php
                        $start  =   date("Y-m-d", strtotime("-10 day"));
                        $end    =   date("Y-m-d");
                    @endphp
                    <span class="mr-4">{{ $start }} - {{ $end }}</span>
                    <button class="btn btn-primary ml-auto btn-sm p-0 px-2">
                        Выбрать дату
                    </button>
                </div>
                <div class="card-body">
                    @php
                        $notificationYear  =   QuestionRepositoryEloquent::priceDateBetween($start,$end);
                    @endphp
                    <canvas id="payment-date-between" width="400" height="220"></canvas>
                    <script>
                        let startPayment   =   '{{$before}}';
                        let endPayment     =   '{{$after}}';
                        notifications = [
                            @foreach( $notificationYear as &$notification)
                            {
                                day: '{{ $notification['date'] }}',
                                sum: {{ $notification['sum'] }}
                            },
                            @endforeach
                        ];
                        new Chart(
                            document.getElementById('payment-date-between'),
                            {
                                type: 'line',
                                data: {
                                    labels: notifications.map(row => row.day),
                                    datasets: [{
                                        label: 'Сумма выплат за период {{ $start }} - {{ $end }}',
                                        data: notifications.map(row => row.sum),
                                        fill: false,
                                        borderColor: 'rgb(75, 192, 192)',
                                        tension: 0.1
                                    }]
                                },
                            }
                        );
                    </script>
                </div>
            </div>
        </div>
    </div>

    @php

        $widgets[''][]    =   [
                'type'    => 'div',
                'class'   => 'row',
                'content' => [
                    // 'hint'          => QuestionRepositoryEloquent::countLastMonth([]) . ' Запроса за последний 30 дней',
//'hint'          => UserRepositoryEloquent::countLastMonth() . ' пользователя за последний 30 дней',
                    [
                        'type'          => 'progress_white',
                        'class'         => 'card mb-2',
                        'wrapper'       =>  ['class' => 'col-sm-4'],
                        'value'         =>  '<span class="text-success">' . QuestionRepositoryEloquent::sum(Contract::PRICE,[Contract::IS_PAID=>true]) . ' KZT</span>',
                        'description'   => 'Сумма всех оплат',
                        'progress'      => 100, // integer
                        'progressClass' => 'progress-bar bg-success',
                        'hint'          => QuestionRepositoryEloquent::sumLastMonth(Contract::PRICE,[Contract::IS_PAID=>true]) . ' KZT Сумма за последний 30 дней',
                    ],
                        [
                            'type'          => 'progress_white',
                            'class'         => 'card mb-2',
                            'value'         =>  '<span class="text-danger">' . QuestionRepositoryEloquent::count([\App\Domain\Contracts\Contract::STATUS=>1]) . '</span>',
                            'description'   => 'В обработке',
                            'progress'      => 100, // integer
                            'progressClass' => 'progress-bar bg-danger',
                            'hint'          => QuestionRepositoryEloquent::countLastMonth([\App\Domain\Contracts\Contract::STATUS=>1]) . ' запроса за последний 30 дней',
                        ],
                        [
                            'type'          => 'progress_white',
                            'class'         => 'card mb-2',
                            'value'         =>  '<span class="text-danger">' . QuestionRepositoryEloquent::count([\App\Domain\Contracts\Contract::STATUS=>2]) . '</span>',
                            'description'   => 'Закрыт',
                            'progress'      => 100, // integer
                            'progressClass' => 'progress-bar bg-danger',
                            'hint'          => QuestionRepositoryEloquent::countLastMonth([\App\Domain\Contracts\Contract::STATUS=>2]) . ' запроса за последний 30 дней',
                        ],
                    ],
                ];
    @endphp

@endsection



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
                        'wrapper'       =>  ['class' => 'col-sm-4'],
                        'value'         =>  '<span class="text-primary">' . UserRepositoryEloquent::count([]) . '</span>',
                        'description'   => 'Все пользователи',
                        'progress'      => 100, // integer
                        'progressClass' => 'progress-bar bg-primary',
                    ],
                    [
                        'type'          => 'progress_white',
                        'class'         => 'card mb-2',
                        'wrapper'       =>  ['class' => 'col-sm-4'],
                        'value'         =>  '<span class="text-primary">' . UserRepositoryEloquent::count([Contract::ROLE=>Contract::LAWYER]) . '</span>',
                        'description'   => 'Все юристы',
                        'progress'      => 100, // integer
                        'progressClass' => 'progress-bar bg-primary',
                    ],
                    [
                        'type'          => 'progress_white',
                        'class'         => 'card mb-2',
                        'wrapper'       =>  ['class' => 'col-sm-4'],
                        'value'         =>  '<span class="text-danger">' . QuestionRepositoryEloquent::count([]) . '</span>',
                        'description'   => 'Все вопросы',
                        'progress'      => 100, // integer
                        'progressClass' => 'progress-bar bg-danger',
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

    <div class="h4 font-weight-bold text-center mt-4">Пользователи</div>
    <div class="row">
        <div class="col-12 col-lg-4">
            <div class="card mt-4">
                <div class="card-header text-center">
                    Зарегистрировано за последние 7 дней
                </div>
                <div class="card-body">
                    @php
                        $users  =   UserRepositoryEloquent::userLastWeek();
                    @endphp
                    <canvas id="user-last-week" width="400" height="220" role="img"></canvas>
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
                                        label: '',
                                        data: data.map(row => row.count),
                                        fill: false,
                                        borderColor: 'rgb(124, 105, 239)',
                                        tension: 0.1
                                    }]
                                },
                                options: {
                                    legend: {
                                        display: false
                                    },
                                }
                            }
                        );
                    </script>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card mt-4">
                <div class="card-header text-center">
                    Зарегистрировано за последние 30 дней
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
                                options: {
                                    legend: {
                                        display: false
                                    },
                                }
                            }
                        );
                    </script>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card mt-4">
                @php
                    $before =   date("Y-m-d", strtotime("-365 day"));
                    $after  =   date("Y-m-d");
                    $userBetween    =   UserRepositoryEloquent::userDateBetween($before,$after);
                @endphp
                <div class="card-header text-center d-flex align-items-center justify-content-center head-date">
                    <label for="from" class="h6 m-0">От</label>
                    <input type="text" class="input-date" id="from" name="from" value="{{$before}}" readonly>
                    <label for="to" class="h6 m-0">До</label>
                    <input type="text" class="input-date" id="to" name="to" value="{{$after}}" readonly>
                </div>
                <div class="card-body">
                    <canvas id="user-date-between" width="400" height="220"></canvas>
                    <script>
                        let UserData = [
                                @foreach( $userBetween as &$user)
                            {
                                date: '{{ $user['date'] }}',
                                count: {{ $user['count'] }}
                            },
                            @endforeach
                        ];
                        new Chart(
                            document.getElementById('user-date-between'),
                            {
                                type: 'line',
                                data: {
                                    labels: UserData.map(row => row.date),
                                    datasets: [{
                                        label: 'За выбранный период',
                                        data: UserData.map(row => row.count),
                                        fill: false,
                                        borderColor: 'rgb(124, 105, 239)',
                                        tension: 0.1
                                    }]
                                },
                                options: {
                                    legend: {
                                        display: false
                                    },
                                }
                            }
                        );
                    </script>
                </div>
            </div>
        </div>
    </div>
    <div class="h4 font-weight-bold text-center">Сумма</div>
    <div class="row">
        <div class="col-12 col-lg-4">
            <div class="card mt-3">
                <div class="card-header text-center">
                    За последний 7 дней (KZT)
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
                                options: {
                                    legend: {
                                        display: false
                                    },
                                }
                            }
                        );
                    </script>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card mt-3">
                <div class="card-header text-center">
                    За последний 30 дней (KZT)
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
                                options: {
                                    legend: {
                                        display: false
                                    },
                                }
                            }
                        );
                    </script>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card mt-3">
                @php
                    $startPrice  =   date("Y-m-d", strtotime("-10 day"));
                    $endPrice    =   date("Y-m-d");
                    $priceBetween  =   QuestionRepositoryEloquent::priceDateBetween($startPrice,$endPrice);
                @endphp
                <div class="card-header text-center d-flex align-items-center justify-content-center head-date">
                    <label for="from-price" class="h6 m-0">От</label>
                    <input type="text" class="input-date" id="from_price" name="from-price" value="{{$startPrice}}" readonly>
                    <label for="to-price" class="h6 m-0">До</label>
                    <input type="text" class="input-date" id="to_price" name="to-price" value="{{$endPrice}}" readonly>
                </div>
                <div class="card-body">
                    <canvas id="payment-date-between" width="400" height="220"></canvas>
                    <script>
                        let priceDate = [
                                @foreach( $priceBetween as &$notification)
                            {
                                date: '{{ $notification['date'] }}',
                                sum: {{ $notification['sum'] }}
                            },
                            @endforeach
                        ];
                        new Chart(
                            document.getElementById('payment-date-between'),
                            {
                                type: 'line',
                                data: {
                                    labels: priceDate.map(row => row.date),
                                    datasets: [{
                                        label: 'За выбранный период',
                                        data: priceDate.map(row => row.sum),
                                        fill: false,
                                        borderColor: 'rgb(75, 192, 192)',
                                        tension: 0.1
                                    }]
                                },
                                options: {
                                    legend: {
                                        display: false
                                    },
                                }
                            }
                        );
                    </script>
                </div>
            </div>
        </div>
    </div>
    <div class="h4 font-weight-bold text-center">В обработке</div>
    <div class="row">
        <div class="col-12 col-lg-4">
            <div class="card mt-3">
                <div class="card-header text-center">
                    В обработке за последний 7 дней
                </div>
                <div class="card-body">
                    @php
                        $notifications  =   QuestionRepositoryEloquent::countWhere([
                            [Contract::CREATED_AT, '>', now()->subDays(7)->endOfDay()],
                            [Contract::IS_PAID,true],
                            [Contract::STATUS,1]]);
                    @endphp
                    <canvas id="open-question-week" width="400" height="220" aria-label="Открытые вопросы за последний 7 дней"></canvas>
                    <script>
                        notifications = [
                                @foreach( $notifications as &$notification)
                            {
                                day: '{{ \Carbon\Carbon::parse($notification['date'])->diffForHumans() }}',
                                count: {{ $notification['count'] }}
                            },
                            @endforeach
                        ];
                        new Chart(
                            document.getElementById('open-question-week'),
                            {
                                type: 'line',
                                data: {
                                    labels: notifications.map(row => row.day),
                                    datasets: [{
                                        label: 'Открытые вопросы за последний 7 дней (KZT)',
                                        data: notifications.map(row => row.count),
                                        fill: false,
                                        borderColor: 'rgb(75, 192, 192)',
                                        tension: 0.1
                                    }]
                                },
                                options: {
                                    legend: {
                                        display: false
                                    },
                                }
                            }
                        );
                    </script>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card mt-3">
                <div class="card-header text-center">
                    В обработке за последний 30 дней
                </div>
                <div class="card-body">
                    @php
                        $notificationMonth  =   QuestionRepositoryEloquent::countWhere([
                            [Contract::CREATED_AT, '>', now()->subDays(30)->endOfDay()],
                            [Contract::IS_PAID,true],
                            [Contract::STATUS,1]]);
                    @endphp
                    <canvas id="open-question-month" width="400" height="220" aria-label="Открытые вопросы за последний 30 дней"></canvas>
                    <script>
                        notifications = [
                            @foreach( $notificationMonth as &$notification)
                            {
                                day: '{{ \Carbon\Carbon::parse($notification['date'])->diffForHumans() }}',
                                count: {{ $notification['count'] }}
                            },
                            @endforeach
                        ];
                        new Chart(
                            document.getElementById('open-question-month'),
                            {
                                type: 'line',
                                data: {
                                    labels: notifications.map(row => row.day),
                                    datasets: [{
                                        label: 'Открытые вопросы за последний 30 дней',
                                        data: notifications.map(row => row.count),
                                        fill: false,
                                        borderColor: 'rgb(75, 192, 192)',
                                        tension: 1
                                    }]
                                },
                                options: {
                                    legend: {
                                        display: false
                                    },
                                }
                            }
                        );
                    </script>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card mt-3">
                @php
                    $startOpen  =   date("Y-m-d", strtotime("-10 day"));
                    $endOpen    =   date("Y-m-d");
                    $priceBetween  =   QuestionRepositoryEloquent::countDateBetween($startOpen,$endOpen);
                @endphp
                <div class="card-header text-center d-flex align-items-center justify-content-center head-date">
                    <label for="from-open" class="h6 m-0">От</label>
                    <input type="text" class="input-date" id="from_open" name="from-open" value="{{$startOpen}}" readonly>
                    <label for="to-open" class="h6 m-0">До</label>
                    <input type="text" class="input-date" id="to_open" name="to-open" value="{{$endOpen}}" readonly>
                </div>
                <div class="card-body">
                    <canvas id="open-question-between" width="400" height="220"></canvas>
                    <script>
                        let openDate = [
                                @foreach( $priceBetween as &$notification)
                            {
                                date: '{{ $notification['date'] }}',
                                count: {{ $notification['count'] }}
                            },
                            @endforeach
                        ];
                        new Chart(
                            document.getElementById('open-question-between'),
                            {
                                type: 'line',
                                data: {
                                    labels: openDate.map(row => row.date),
                                    datasets: [{
                                        label: 'За выбранный период',
                                        data: openDate.map(row => row.count),
                                        fill: false,
                                        borderColor: 'rgb(75, 192, 192)',
                                        tension: 1
                                    }]
                                },
                                options: {
                                    legend: {
                                        display: false
                                    },
                                }
                            }
                        );
                    </script>
                </div>
            </div>
        </div>
    </div>
    <div class="h4 font-weight-bold text-center">Закрытые</div>
    <div class="row">
        <div class="col-12 col-lg-4">
            <div class="card mt-3">
                <div class="card-header text-center">
                    Закрытые вопросы за последний 7 дней
                </div>
                <div class="card-body">
                    @php
                        $notifications  =   QuestionRepositoryEloquent::countWhere([
                            [Contract::CREATED_AT, '>', now()->subDays(7)->endOfDay()],
                            [Contract::IS_PAID,true],
                            [Contract::STATUS,2]]);
                    @endphp
                    <canvas id="closed-question-week" width="400" height="220" aria-label="Закрытые вопросы за последний 7 дней"></canvas>
                    <script>
                        notifications = [
                                @foreach( $notifications as &$notification)
                            {
                                day: '{{ \Carbon\Carbon::parse($notification['date'])->diffForHumans() }}',
                                count: {{ $notification['count'] }}
                            },
                            @endforeach
                        ];
                        new Chart(
                            document.getElementById('closed-question-week'),
                            {
                                type: 'line',
                                data: {
                                    labels: notifications.map(row => row.day),
                                    datasets: [{
                                        label: 'Закрытые вопросы за последний 7 дней (KZT)',
                                        data: notifications.map(row => row.count),
                                        fill: false,
                                        borderColor: 'rgb(75, 192, 192)',
                                        tension: 0.1
                                    }]
                                },
                                options: {
                                    legend: {
                                        display: false
                                    },
                                }
                            }
                        );
                    </script>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card mt-3">
                <div class="card-header text-center">
                    Закрытые вопросы за последний 30 дней
                </div>
                <div class="card-body">
                    @php
                        $notificationMonth  =   QuestionRepositoryEloquent::countWhere([
                            [Contract::CREATED_AT, '>', now()->subDays(30)->endOfDay()],
                            [Contract::IS_PAID,true],
                            [Contract::STATUS,2]]);
                    @endphp
                    <canvas id="closed-question-month" width="400" height="220" aria-label="Закрытые вопросы за последний 30 дней"></canvas>
                    <script>
                        notifications = [
                            @foreach( $notificationMonth as &$notification)
                            {
                                day: '{{ \Carbon\Carbon::parse($notification['date'])->diffForHumans() }}',
                                count: {{ $notification['count'] }}
                            },
                            @endforeach
                        ];
                        new Chart(
                            document.getElementById('closed-question-month'),
                            {
                                type: 'line',
                                data: {
                                    labels: notifications.map(row => row.day),
                                    datasets: [{
                                        label: 'Закрытые вопросы за последний 30 дней',
                                        data: notifications.map(row => row.count),
                                        fill: false,
                                        borderColor: 'rgb(75, 192, 192)',
                                        tension: 1
                                    }]
                                },
                                options: {
                                    legend: {
                                        display: false
                                    },
                                }
                            }
                        );
                    </script>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card mt-3">
                @php
                    $startClosed  =   date("Y-m-d", strtotime("-10 day"));
                    $endClosed    =   date("Y-m-d");
                    $countEndBetween  =   QuestionRepositoryEloquent::countDateBetweenClosed($startOpen,$endOpen);
                @endphp
                <div class="card-header text-center d-flex align-items-center justify-content-center head-date">
                    <label for="from_close" class="h6 m-0">От</label>
                    <input type="text" class="input-date" id="from_close" name="from-close" value="{{$startClosed}}" readonly>
                    <label for="to_close" class="h6 m-0">До</label>
                    <input type="text" class="input-date" id="to_close" name="to-close" value="{{$endClosed}}" readonly>
                </div>
                <div class="card-body">
                    <canvas id="closed-question-between" width="400" height="220"></canvas>
                    <script>
                        let closeDate = [
                                @foreach( $countEndBetween as &$notification)
                            {
                                date: '{{ $notification['date'] }}',
                                count: {{ $notification['count'] }}
                            },
                            @endforeach
                        ];
                        new Chart(
                            document.getElementById('closed-question-between'),
                            {
                                type: 'line',
                                data: {
                                    labels: closeDate.map(row => row.date),
                                    datasets: [{
                                        label: 'За выбранный период',
                                        data: closeDate.map(row => row.count),
                                        fill: false,
                                        borderColor: 'rgb(75, 192, 192)',
                                        tension: 0.1
                                    }]
                                },
                                options: {
                                    legend: {
                                        display: false
                                    },
                                }
                            }
                        );
                    </script>
                </div>
            </div>
        </div>
    </div>
    <div class="h4 font-weight-bold text-center">Общее</div>
    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="card mt-3">
                <div class="card-header text-center">
                    Статистика вопросов
                </div>
                <div class="card-body">
                    @php
                        $notificationYear  =   QuestionRepositoryEloquent::openClosedPercentage();
                        $status =   ['Отменен','В обработке','Закрыт'];
                    @endphp
                    <canvas id="open-question-year" width="400" height="220" aria-label="Открытые вопросы за последний 365 дней"></canvas>
                    <script>
                        notifications = [
                            @foreach( $notificationYear as &$notification)
                            {
                                status: '{{ $status[$notification['status']] }}',
                                count: {{ $notification['count'] }}
                            },
                            @endforeach
                        ];
                        new Chart(
                            document.getElementById('open-question-year'),
                            {
                                type: 'doughnut',
                                data: {
                                    labels: notifications.map(row => row.status),
                                    datasets: [{
                                        label: 'Открытые вопросы за последний 365 дней',
                                        data: notifications.map(row => row.count),
                                        backgroundColor: [
                                            'purple',
                                            'magenta',
                                            'darkcyan',
                                            'grey',
                                            'orange',
                                            'lime',
                                            'brown',
                                            'blue',
                                            'red',
                                            'skyblue',
                                            'green',
                                            'pink',
                                            'Gold',
                                        ],
                                        hoverOffset: 4
                                    }]
                                },
                            }
                        );
                    </script>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card mt-3">
                <div class="card-header text-center">
                    Пользователи
                </div>
                <div class="card-body">
                    @php
                        $userGlobal =   UserRepositoryEloquent::rolePercentage();
                        $roles  =   [
                            Contract::ADMIN =>  'Администратор',
                            Contract::USER  =>  'Пользователь',
                            Contract::LAWYER    =>  'Юрист'
                        ];
                    @endphp
                    <canvas id="user-global" width="400" height="220"></canvas>
                    <script>
                        notifications = [
                            @foreach( $userGlobal as &$notification)
                            {
                                role: '{{ $roles[$notification['role']] }}',
                                count: {{ $notification['count'] }}
                            },
                            @endforeach
                        ];
                        new Chart(
                            document.getElementById('user-global'),
                            {
                                type: 'doughnut',
                                data: {
                                    labels: notifications.map(row => row.role),
                                    datasets: [{
                                        label: 'Открытые вопросы за последний 365 дней',
                                        data: notifications.map(row => row.count),
                                        backgroundColor: [
                                            'purple',
                                            'magenta',
                                            'darkcyan',
                                            'grey',
                                            'orange',
                                            'lime',
                                            'brown',
                                            'blue',
                                            'red',
                                            'skyblue',
                                            'green',
                                            'pink',
                                            'Gold',
                                        ],
                                        hoverOffset: 4
                                    }]
                                },
                            }
                        );
                    </script>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('after_scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $( function() {
            let dateFormat = "yy-mm-dd";

            let from = $( "#from" )
            .datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                dateFormat: dateFormat
            })
            .on( "change", function() {
                to.datepicker( "option", "minDate", getDate( this ) );
                getUserDate()
            });

            let to = $( "#to" ).datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                dateFormat: dateFormat
            })
            .on( "change", function() {
                from.datepicker( "option", "maxDate", getDate( this ) );
                getUserDate()
            });

            let from_price = $( "#from_price" )
                .datepicker({
                    defaultDate: "+1w",
                    changeMonth: true,
                    numberOfMonths: 1,
                    dateFormat: dateFormat
                })
                .on( "change", function() {
                    to_price.datepicker( "option", "minDate", getDate( this ) );
                    getPriceDate()
                });

            let to_price = $( "#to_price" ).datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                dateFormat: dateFormat
            })
                .on( "change", function() {
                    from_price.datepicker( "option", "maxDate", getDate( this ) );
                    getPriceDate()
                });

            let from_open = $( "#from_open" )
                .datepicker({
                    defaultDate: "+1w",
                    changeMonth: true,
                    numberOfMonths: 1,
                    dateFormat: dateFormat
                })
                .on( "change", function() {
                    to_open.datepicker( "option", "minDate", getDate( this ) );
                    getOpenDate()
                });

            let to_open = $( "#to_open" ).datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                dateFormat: dateFormat
            })
                .on( "change", function() {
                    from_open.datepicker( "option", "maxDate", getDate( this ) );
                    getOpenDate()
                });

            let from_close = $( "#from_close" )
                .datepicker({
                    defaultDate: "+1w",
                    changeMonth: true,
                    numberOfMonths: 1,
                    dateFormat: dateFormat
                })
                .on( "change", function() {
                    to_close.datepicker( "option", "minDate", getDate( this ) );
                    getCloseDate()
                });

            let to_close = $( "#to_close" ).datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                dateFormat: dateFormat
            })
                .on( "change", function() {
                    from_close.datepicker( "option", "maxDate", getDate( this ) );
                    getCloseDate()
                });

            function getDate( element ) {
                let date;
                try {
                    date = $.datepicker.parseDate(dateFormat, element.value );
                } catch( error ) {
                    date = null;
                }
                return date;
            }
        } );
        function getUserDate() {
            let userStart   =   $( "#from" ).val();
            let userEnd     =   $( "#to" ).val();
            if (userStart !== '' && userEnd !== '') {
                $.get( "/api/v1/user/userDateBetween/"+userStart+"/"+userEnd, function( data ) {
                    UserData = data;
                    new Chart(
                        document.getElementById('user-date-between'),
                        {
                            type: 'line',
                            data: {
                                labels: UserData.map(row => row.date),
                                datasets: [{
                                    label: 'За выбранный период',
                                    data: UserData.map(row => row.count),
                                    fill: false,
                                    borderColor: 'rgb(124, 105, 239)',
                                    tension: 0.1
                                }]
                            },
                        }
                    );
                });
            }
        }
        function getPriceDate() {
            let priceStart   =   $( "#from_price" ).val();
            let priceEnd     =   $( "#to_price" ).val();
            if (priceStart !== '' && priceEnd !== '') {
                $.get( "/api/v1/question/priceDateBetween/"+priceStart+"/"+priceEnd, function( data ) {
                    priceDate = data;
                    new Chart(
                        document.getElementById('payment-date-between'),
                        {
                            type: 'line',
                            data: {
                                labels: priceDate.map(row => row.date),
                                datasets: [{
                                    label: 'За выбранный период',
                                    data: priceDate.map(row => row.sum),
                                    fill: false,
                                    borderColor: 'rgb(75, 192, 192)',
                                    tension: 0.1
                                }]
                            },
                        }
                    );
                });
            }
        }
        function getOpenDate() {
            let openStart   =   $( "#from_open" ).val();
            let openEnd     =   $( "#to_open" ).val();
            if (openStart !== '' && openEnd !== '') {
                $.get( "/api/v1/question/countDateBetween/"+openStart+"/"+openEnd, function( data ) {
                    openDate = data;
                    new Chart(
                        document.getElementById('open-question-between'),
                        {
                            type: 'line',
                            data: {
                                labels: openDate.map(row => row.date),
                                datasets: [{
                                    label: 'За выбранный период',
                                    data: openDate.map(row => row.count),
                                    fill: false,
                                    borderColor: 'rgb(75, 192, 192)',
                                    tension: 1
                                }]
                            },
                        }
                    );
                });
            }
        }
        function getCloseDate() {
            let closeStart   =   $( "#from_close" ).val();
            let closeEnd     =   $( "#to_close" ).val();
            if (closeStart !== '' && closeEnd !== '') {
                $.get( "/api/v1/question/countDateBetweenClosed/"+closeStart+"/"+closeEnd, function( data ) {
                    closeDate = data;
                    new Chart(
                        document.getElementById('closed-question-between'),
                        {
                            type: 'line',
                            data: {
                                labels: closeDate.map(row => row.date),
                                datasets: [{
                                    label: 'За выбранный период',
                                    data: closeDate.map(row => row.count),
                                    fill: false,
                                    borderColor: 'rgb(75, 192, 192)',
                                    tension: 1
                                }]
                            },
                        }
                    );
                });
            }
        }
    </script>
@endsection


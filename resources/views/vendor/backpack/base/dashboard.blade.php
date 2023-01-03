@extends(backpack_view('blank'))
@php
    use App\Domain\Repositories\User\UserRepositoryEloquent;
    use App\Domain\Repositories\Question\QuestionRepositoryEloquent;
    use App\Domain\Contracts\Contract;
    use App\Charts\UserChart;
@endphp

@section('content')
    @if(backpack_user()->{Contract::ROLE} === Contract::ADMIN)
        @php
            $widgets['before_content'][]    =   [
            'type'    => 'div',
            'class'   => 'row',
            'content' => [
                    [
                        'type'          => 'progress_white',
                        'class'         => 'card mb-2',
                        'wrapper'       =>  ['class' => 'col-sm-4'],
                        'value'         =>  '<span class="text-primary">' . UserRepositoryEloquent::count([
                            Contract::ROLE  =>  Contract::USER
]) . '</span>',
                        'description'   => 'Пользователей в системе',
                        'progress'      => 100, // integer
                        'progressClass' => 'progress-bar bg-primary',
                    ],
                    [
                        'type'          => 'progress_white',
                        'class'         => 'card mb-2',
                        'wrapper'       =>  ['class' => 'col-sm-4'],
                        'value'         =>  '<span class="text-primary">' . UserRepositoryEloquent::count([Contract::ROLE=>Contract::LAWYER]) . '</span>',
                        'description'   => 'Юристов в системе',
                        'progress'      => 100, // integer
                        'progressClass' => 'progress-bar bg-primary',
                    ],
                    [
                        'type'          => 'progress_white',
                        'class'         => 'card mb-2',
                        'wrapper'       =>  ['class' => 'col-sm-4'],
                        'value'         =>  '<span class="text-danger">' . QuestionRepositoryEloquent::count([
                            Contract::IS_PAID   =>  true
]) . '</span>',
                        'description'   => 'Вопросов за все время',
                        'progress'      => 100, // integer
                        'progressClass' => 'progress-bar bg-danger',
                    ],
                ],
            ];

        @endphp
    @else
        @php
            $widgets['after_content'][]    =   [
            'type'    => 'div',
            'class'   => 'row',
            'content' => [
                    [
                        'type'          => 'progress_white',
                        'class'         => 'card mb-2',
                        'value'         =>  '<span class="text-success">' . QuestionRepositoryEloquent::lawyerCountToday([Contract::LAWYER_ID=>backpack_user()->{Contract::ID},Contract::CREATED_AT=>\Carbon\Carbon::today()]) . '</span>',
                        'description'   => 'Отвечено на вопросы сегодня',
                        'progress'      => 100, // integer
                        'progressClass' => 'progress-bar bg-success',
                    ],
                ],
            ];
        @endphp
    @endif
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
    <script src="https://cdnjs.com/libraries/Chart.js"></script>

    @if(backpack_user()->{Contract::ROLE} === Contract::ADMIN)
        <div class="h4 font-weight-bold text-center mt-4">Пользователей в системе</div>
        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="card mt-4">
                    <div class="card-header text-center">
                        За последние 7 дней
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
                        За последние 30 дней
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
                                            label: 'Зарегистрировано за последние 30 дней',
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
        <div class="h4 font-weight-bold text-center">Сумма всех оплат</div>
        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="card mt-3">
                    <div class="card-header text-center">
                        За последние 7 дней (KZT)
                    </div>
                    <div class="card-body">
                        @php
                            $notifications  =   QuestionRepositoryEloquent::priceLastWeek();
                        @endphp
                        <canvas id="payment-last-week" width="400" height="220"
                                aria-label="Сумма выплат за последние 7 дней"></canvas>
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
                                            label: 'Сумма выплат за последние 7 дней (KZT)',
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
                        За последние 30 дней (KZT)
                    </div>
                    <div class="card-body">
                        @php
                            $notificationMonth  =   QuestionRepositoryEloquent::priceLastMonth();
                        @endphp
                        <canvas id="payment-last-month" width="400" height="220"
                                aria-label="Сумма выплат за последние 30 дней"></canvas>
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
                                            label: 'Сумма выплат за последние 30 дней (KZT)',
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
                        $startPrice  =   date("Y-m-d", strtotime("-365 day"));
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
        <div class="h4 font-weight-bold text-center">Вопросы со статусом “В обработке”</div>
        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="card mt-3">
                    <div class="card-header text-center">
                        За последние 7 дней
                    </div>
                    <div class="card-body">
                        @php
                            $notifications  =   QuestionRepositoryEloquent::countWhere([
                                [Contract::CREATED_AT, '>', now()->subDays(7)->endOfDay()],
                                [Contract::IS_PAID,true],
                                [Contract::STATUS,1]]);
                        @endphp
                        <canvas id="open-question-week" width="400" height="220" aria-label="Открытые вопросы за последние 7 дней"></canvas>
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
                                            label: 'Открытые вопросы за последние 7 дней (KZT)',
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
                        За последние 30 дней
                    </div>
                    <div class="card-body">
                        @php
                            $notificationMonth  =   QuestionRepositoryEloquent::countWhere([
                                [Contract::CREATED_AT, '>', now()->subDays(30)->endOfDay()],
                                [Contract::IS_PAID,true],
                                [Contract::STATUS,1]]);
                        @endphp
                        <canvas id="open-question-month" width="400" height="220" aria-label="Открытые вопросы за последние 30 дней"></canvas>
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
                                            label: 'Открытые вопросы за последние 30 дней',
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
                        $startOpen  =   date("Y-m-d", strtotime("-365 day"));
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
        <div class="h4 font-weight-bold text-center">Вопросы со статусом “Закрыт”</div>
        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="card mt-3">
                    <div class="card-header text-center">
                        За последние 7 дней
                    </div>
                    <div class="card-body">
                        @php
                            $notifications  =   QuestionRepositoryEloquent::countWhere([
                                [Contract::CREATED_AT, '>', now()->subDays(7)->endOfDay()],
                                [Contract::IS_PAID,true],
                                [Contract::STATUS,2]]);
                        @endphp
                        <canvas id="closed-question-week" width="400" height="220" aria-label="Закрытые вопросы за последние 7 дней"></canvas>
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
                                            label: 'Закрытые вопросы за последние 7 дней (KZT)',
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
                        За последние 30 дней
                    </div>
                    <div class="card-body">
                        @php
                            $notificationMonth  =   QuestionRepositoryEloquent::countWhere([
                                [Contract::CREATED_AT, '>', now()->subDays(30)->endOfDay()],
                                [Contract::IS_PAID,true],
                                [Contract::STATUS,2]]);
                        @endphp
                        <canvas id="closed-question-month" width="400" height="220" aria-label="Закрытые вопросы за последние 30 дней"></canvas>
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
                                            label: 'Закрытые вопросы за последние 30 дней',
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
                        $startClosed  =   date("Y-m-d", strtotime("-365 day"));
                        $endClosed    =   date("Y-m-d");
                        $countEndBetween  =   QuestionRepositoryEloquent::countDateBetweenClosed($startClosed,$endClosed);
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
        <div class="h4 font-weight-bold text-center">Среднее время на ответ</div>
        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="card mt-3">
                    <div class="card-header text-center">
                        Среднее время на ответ за последние 7 дней
                    </div>
                    <div class="card-body">
                        @php
                            $notifications  =   QuestionRepositoryEloquent::averageTime([
                                [Contract::CREATED_AT, '>', now()->subDays(7)->endOfDay()],
                                [Contract::IS_PAID,true],
                                [Contract::STATUS,2]
                                ]);
                        @endphp
                        <canvas id="average-week" width="400" height="220" aria-label="Среднее время на ответ 7 дней"></canvas>
                        <script>
                            notifications = [
                                    @foreach( $notifications as &$value)
                                {
                                    day: '{{ \Carbon\Carbon::parse($value['date'])->diffForHumans() }} • {{ $value['average'] }}',
                                    count: {{ $value['count'] }}
                                },
                                @endforeach
                            ];
                            new Chart(
                                document.getElementById('average-week'),
                                {
                                    type: 'line',
                                    data: {
                                        labels: notifications.map(row => row.day),
                                        datasets: [{
                                            label: 'Среднее время на ответ',
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
                    <div class="card-header text-center">
                        Среднее время на ответ за последние 30 дней
                    </div>
                    <div class="card-body">
                        @php
                            $notifications  =   QuestionRepositoryEloquent::averageTime([
                                [Contract::CREATED_AT, '>', now()->subDays(30)->endOfDay()],
                                [Contract::IS_PAID,true],
                                [Contract::STATUS,2]
                                ]);
                        @endphp
                        <canvas id="average-month" width="400" height="220" aria-label="Среднее время на ответ 7 дней"></canvas>
                        <script>
                            notifications = [
                                    @foreach( $notifications as &$value)
                                {
                                    day: '{{ \Carbon\Carbon::parse($value['date'])->diffForHumans() }} • {{ $value['average'] }}',
                                    count: {{ $value['count'] }}
                                },
                                @endforeach
                            ];
                            new Chart(
                                document.getElementById('average-month'),
                                {
                                    type: 'line',
                                    data: {
                                        labels: notifications.map(row => row.day),
                                        datasets: [{
                                            label: 'Среднее время на ответ',
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
                        $startClosed  =   date("Y-m-d", strtotime("-365 day"));
                        $endClosed    =   date("Y-m-d");
                        $averageEndBetween  =   QuestionRepositoryEloquent::averageTimeBetweenClosedWhere($startClosed,$endClosed,[
                            [Contract::IS_PAID,true],
                            [Contract::STATUS,2]
                        ]);
                    @endphp
                    <div class="card-header text-center d-flex align-items-center justify-content-center head-date">
                        <label for="from-average" class="h6 m-0">От</label>
                        <input type="text" class="input-date" id="from-average" name="from-lawyer-average" value="{{$startClosed}}" readonly>
                        <label for="to-average" class="h6 m-0">До</label>
                        <input type="text" class="input-date" id="to-average" name="to-lawyer-average" value="{{$endClosed}}" readonly>
                    </div>
                    <div class="card-body">
                        <canvas id="average-between" width="400" height="220"></canvas>
                        <script>
                            let averageDate = [
                                    @foreach( $averageEndBetween as &$value)
                                {
                                    date: '{{ $value['date'] }} • {{ $value['average'] }}',
                                    count: {{ $value['count'] }}
                                },
                                @endforeach
                            ];
                            new Chart(
                                document.getElementById('average-between'),
                                {
                                    type: 'line',
                                    data: {
                                        labels: averageDate.map(row => row.date),
                                        datasets: [{
                                            label: 'За выбранный период',
                                            data: averageDate.map(row => row.count),
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
        <div class="h4 font-weight-bold text-center">Процент обычных и срочных вопросов</div>
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card mt-3">
                    <div class="card-header text-center">
                        За последние 7 дней
                    </div>
                    <div class="card-body">
                        @php
                            $notificationWeek  =   QuestionRepositoryEloquent::openClosedPercentage([
                                [Contract::IS_PAID,true],
                                [Contract::CREATED_AT, '>', now()->subDays(7)->endOfDay()]
                            ]);
                            $status =   [
                                1    =>  'Срочные вопросы',
                                0   =>  'Обычные вопросы'
                            ];
                        @endphp
                        <canvas id="doughnut-week" width="400" height="220"></canvas>
                        <script>
                            notifications = [
                                @foreach( $notificationWeek as &$notification)
                                {
                                    is_important: '{{ $status[$notification['is_important']] }}',
                                    count: {{ $notification['count'] }}
                                },
                                @endforeach
                            ];
                            new Chart(
                                document.getElementById('doughnut-week'),
                                {
                                    type: 'doughnut',
                                    data: {
                                        labels: notifications.map(row => row.is_important),
                                        datasets: [{
                                            label: 'За последние 7 дней',
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
                        За последние 30 дней
                    </div>
                    <div class="card-body">
                        @php
                            $notificationMonth  =   QuestionRepositoryEloquent::openClosedPercentage([
                                [Contract::IS_PAID,true],
                                [Contract::CREATED_AT, '>', now()->subDays(30)->endOfDay()]
                            ]);
                        @endphp
                        <canvas id="doughnut-month" width="400" height="220"></canvas>
                        <script>
                            notifications = [
                                    @foreach( $notificationMonth as &$notification)
                                {
                                    is_important: '{{ $status[$notification['is_important']] }}',
                                    count: {{ $notification['count'] }}
                                },
                                @endforeach
                            ];
                            new Chart(
                                document.getElementById('doughnut-month'),
                                {
                                    type: 'doughnut',
                                    data: {
                                        labels: notifications.map(row => row.is_important),
                                        datasets: [{
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
    @else
        <div class="h4 font-weight-bold text-center">Вопросы со статусом “Закрыт”</div>
        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="card mt-3">
                    <div class="card-header text-center">
                        Закрытые вопросы за последние 7 дней
                    </div>
                    <div class="card-body">
                        @php
                            $notifications  =   QuestionRepositoryEloquent::countWhere([
                                [Contract::LAWYER_ID, backpack_user()->{Contract::ID}],
                                [Contract::CREATED_AT, '>', now()->subDays(7)->endOfDay()],
                                [Contract::IS_PAID,true],
                                [Contract::STATUS,2]
                                ]);
                        @endphp
                        <canvas id="closed-question-week" width="400" height="220" aria-label="Закрытые вопросы за последние 7 дней"></canvas>
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
                                            label: 'Закрытые вопросы за последние 7 дней (KZT)',
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
                        Закрытые вопросы за последние 30 дней
                    </div>
                    <div class="card-body">
                        @php
                            $notificationMonth  =   QuestionRepositoryEloquent::countWhere([
                                [Contract::LAWYER_ID, backpack_user()->{Contract::ID}],
                                [Contract::CREATED_AT, '>', now()->subDays(30)->endOfDay()],
                                [Contract::IS_PAID,true],
                                [Contract::STATUS,2]]);
                        @endphp
                        <canvas id="closed-question-month" width="400" height="220" aria-label="Закрытые вопросы за последние 30 дней"></canvas>
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
                                            label: 'Закрытые вопросы за последние 30 дней',
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
                        $startClosed  =   date("Y-m-d", strtotime("-365 day"));
                        $endClosed    =   date("Y-m-d");
                        $countEndBetween  =   QuestionRepositoryEloquent::countDateBetweenClosedWhere($startClosed,$endClosed,[
                            [Contract::LAWYER_ID, backpack_user()->{Contract::ID}],
                            [Contract::IS_PAID,true],
                            [Contract::STATUS,2]
                        ]);
                    @endphp
                    <div class="card-header text-center d-flex align-items-center justify-content-center head-date">
                        <label for="from-lawyer-close" class="h6 m-0">От</label>
                        <input type="text" class="input-date" id="from-lawyer-close" name="from-lawyer-close" value="{{$startClosed}}" readonly>
                        <label for="to-lawyer-close" class="h6 m-0">До</label>
                        <input type="text" class="input-date" id="to-lawyer-close" name="to-lawyer-close" value="{{$endClosed}}" readonly>
                    </div>
                    <div class="card-body">
                        <canvas id="closed-question-between-lawyer" width="400" height="220"></canvas>
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
                                document.getElementById('closed-question-between-lawyer'),
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
        <div class="h4 font-weight-bold text-center">Среднее время на ответ</div>
        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="card mt-3">
                    <div class="card-header text-center">
                        Среднее время на ответ за последние 7 дней
                    </div>
                    <div class="card-body">
                        @php
                            $notifications  =   QuestionRepositoryEloquent::averageTime([
                                [Contract::LAWYER_ID, backpack_user()->{Contract::ID}],
                                [Contract::CREATED_AT, '>', now()->subDays(7)->endOfDay()],
                                [Contract::IS_PAID,true],
                                [Contract::STATUS,2]
                                ]);
                        @endphp
                        <canvas id="average-week-lawyer" width="400" height="220" aria-label="Среднее время на ответ 7 дней"></canvas>
                        <script>
                            notifications = [
                                @foreach( $notifications as &$value)
                                {
                                    day: '{{ \Carbon\Carbon::parse($value['date'])->diffForHumans() }} • {{ $value['average'] }}',
                                    count: {{ $value['count'] }}
                                },
                                @endforeach
                            ];
                            new Chart(
                                document.getElementById('average-week-lawyer'),
                                {
                                    type: 'line',
                                    data: {
                                        labels: notifications.map(row => row.day),
                                        datasets: [{
                                            text: 'sdasd',
                                            label: 'Среднее время на ответ',
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
                    <div class="card-header text-center">
                        Среднее время на ответ за последние 30 дней
                    </div>
                    <div class="card-body">
                        @php
                            $notifications  =   QuestionRepositoryEloquent::averageTime([
                                [Contract::LAWYER_ID, backpack_user()->{Contract::ID}],
                                [Contract::CREATED_AT, '>', now()->subDays(30)->endOfDay()],
                                [Contract::IS_PAID,true],
                                [Contract::STATUS,2]
                                ]);
                        @endphp
                        <canvas id="average-month-lawyer" width="400" height="220" aria-label="Среднее время на ответ 7 дней"></canvas>
                        <script>
                            notifications = [
                                    @foreach( $notifications as &$value)
                                {
                                    day: '{{ \Carbon\Carbon::parse($value['date'])->diffForHumans() }} • {{ $value['average'] }}',
                                    count: {{ $value['count'] }}
                                },
                                @endforeach
                            ];
                            new Chart(
                                document.getElementById('average-month-lawyer'),
                                {
                                    type: 'line',
                                    data: {
                                        labels: notifications.map(row => row.day),
                                        datasets: [{
                                            text: 'sdasd',
                                            label: 'Среднее время на ответ',
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
                        $startClosed  =   date("Y-m-d", strtotime("-365 day"));
                        $endClosed    =   date("Y-m-d");
                        $averageEndBetween  =   QuestionRepositoryEloquent::averageTimeBetweenClosedWhere($startClosed,$endClosed,[
                            [Contract::LAWYER_ID, backpack_user()->{Contract::ID}],
                            [Contract::IS_PAID,true],
                            [Contract::STATUS,2]
                        ]);
                    @endphp
                    <div class="card-header text-center d-flex align-items-center justify-content-center head-date">
                        <label for="from-lawyer-average" class="h6 m-0">От</label>
                        <input type="text" class="input-date" id="from-lawyer-average" name="from-lawyer-average" value="{{$startClosed}}" readonly>
                        <label for="to-lawyer-average" class="h6 m-0">До</label>
                        <input type="text" class="input-date" id="to-lawyer-average" name="to-lawyer-average" value="{{$endClosed}}" readonly>
                    </div>
                    <div class="card-body">
                        <canvas id="average-lawyer-between" width="400" height="220"></canvas>
                        <script>
                            let averageDate = [
                                    @foreach( $averageEndBetween as &$value)
                                {
                                    date: '{{ $value['date'] }} • {{ $value['average'] }}',
                                    count: {{ $value['count'] }}
                                },
                                @endforeach
                            ];
                            new Chart(
                                document.getElementById('average-lawyer-between'),
                                {
                                    type: 'line',
                                    data: {
                                        labels: averageDate.map(row => row.date),
                                        datasets: [{
                                            label: 'За выбранный период',
                                            data: averageDate.map(row => row.count),
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
    @endif
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

            let from_lawyer_close = $("#from-lawyer-close").datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                dateFormat: dateFormat
            })
                .on( "change", function() {
                    from_close.datepicker( "option", "maxDate", getDate( this ) );
                    getCloseLawyerDate()
                });

            let to_lawyer_close = $("#to-lawyer-close").datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                dateFormat: dateFormat
            })
                .on( "change", function() {
                    from_close.datepicker( "option", "maxDate", getDate( this ) );
                    getCloseLawyerDate()
                });

            let from_lawyer_average = $("#from-lawyer-average").datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                dateFormat: dateFormat
            })
                .on( "change", function() {
                    from_close.datepicker( "option", "maxDate", getDate( this ) );
                    getAverageLawyerDate()
                });

            let to_lawyer_average = $("#to-lawyer-average").datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                dateFormat: dateFormat
            })
                .on( "change", function() {
                    from_close.datepicker( "option", "maxDate", getDate( this ) );
                    getAverageLawyerDate()
                });

            let from_average = $("#from-average").datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                dateFormat: dateFormat
            })
                .on( "change", function() {
                    from_close.datepicker( "option", "maxDate", getDate( this ) );
                    getAverageDate()
                });

            let to_average = $("#to-average").datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                dateFormat: dateFormat
            })
                .on( "change", function() {
                    from_close.datepicker( "option", "maxDate", getDate( this ) );
                    getAverageDate()
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
                            options: {
                                legend: {
                                    display: false
                                },
                            }
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
                            options: {
                                legend: {
                                    display: false
                                },
                            }
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
                            options: {
                                legend: {
                                    display: false
                                },
                            }
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
                            options: {
                                legend: {
                                    display: false
                                },
                            }
                        }
                    );
                });
            }
        }
        function getCloseLawyerDate() {
            let closeStart   =   $( "#from-lawyer-close" ).val();
            let closeEnd     =   $( "#to-lawyer-close" ).val();
            let lawyer       =   '{{ backpack_user()->{Contract::ID} }}';
            if (closeStart !== '' && closeEnd !== '') {
                $.get( "/api/v1/question/countDateLawyerBetweenClosed/"+lawyer+"/"+closeStart+"/"+closeEnd, function( data ) {
                    closeDate = data;
                    new Chart(
                        document.getElementById('closed-question-between-lawyer'),
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
                            options: {
                                legend: {
                                    display: false
                                },
                            }
                        }
                    );
                });
            }
        }

        function getAverageLawyerDate() {
            let closeStart   =   $( "#from-lawyer-average" ).val();
            let closeEnd     =   $( "#to-lawyer-average" ).val();
            let lawyer       =   '{{ backpack_user()->{Contract::ID} }}';
            if (closeStart !== '' && closeEnd !== '') {
                $.get( "/api/v1/question/countDateAverageBetweenClosed/"+lawyer+"/"+closeStart+"/"+closeEnd, function( data ) {
                    let averageLawyer = data;
                    let arr =   [];
                    for (const [key, value] of Object.entries(averageLawyer)) {
                        arr.push(value);
                    }
                    new Chart(
                        document.getElementById('average-lawyer-between'),
                        {
                            type: 'line',
                            data: {
                                labels: arr.map(row => row.date + ' • ' + row.average),
                                datasets: [{
                                    label: 'За выбранный период',
                                    data: arr.map(row => row.count),
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
                });
            }
        }

        function getAverageDate() {
            let closeStart   =   $( "#from-average" ).val();
            let closeEnd     =   $( "#to-average" ).val();
            if (closeStart !== '' && closeEnd !== '') {
                $.get( "/api/v1/question/averageBetweenClosed/"+closeStart+"/"+closeEnd, function( data ) {
                    let averageLawyer = data;
                    let arr =   [];
                    for (const [key, value] of Object.entries(averageLawyer)) {
                        arr.push(value);
                    }
                    new Chart(
                        document.getElementById('average-between'),
                        {
                            type: 'line',
                            data: {
                                labels: arr.map(row => row.date + ' • ' + row.average),
                                datasets: [{
                                    label: 'За выбранный период',
                                    data: arr.map(row => row.count),
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
                });
            }
        }

    </script>
@endsection


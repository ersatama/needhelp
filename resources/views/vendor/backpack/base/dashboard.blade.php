@extends(backpack_view('blank'))
@php
    use App\Domain\Repositories\User\UserRepositoryEloquent;
    use App\Domain\Repositories\Question\QuestionRepositoryEloquent;
    use App\Domain\Contracts\Contract;
    use App\Charts\UserChart;
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
                    'wrapper'       =>  ['class' => 'col-sm-4'],
                    'value'         =>  '<span class="text-primary">' . UserRepositoryEloquent::count([]) . '</span>',
                    'description'   => 'Пользователи',
                    'progress'      => 100, // integer
                    'progressClass' => 'progress-bar bg-primary',
                    'hint'          => UserRepositoryEloquent::countLastMonth() . ' пользователя за последний 30 дней',
                ],
                [
                    'type'          => 'progress_white',
                    'class'         => 'card mb-2',
                    'wrapper'       =>  ['class' => 'col-sm-4'],
                    'value'         =>  '<span class="text-primary">' . UserRepositoryEloquent::count([\App\Domain\Contracts\Contract::ROLE=>\App\Domain\Contracts\Contract::LAWYER]) . '</span>',
                    'description'   => 'Юристы',
                    'progress'      => 100, // integer
                    'progressClass' => 'progress-bar bg-primary',
                    'hint'          => UserRepositoryEloquent::countLastMonth([\App\Domain\Contracts\Contract::ROLE=>\App\Domain\Contracts\Contract::LAWYER]) . ' адвокат(a) за последний 30 дней',
                ],
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
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
    <script src="https://cdnjs.com/libraries/Chart.js"></script>
    <div class="row">
        <div class="col-6">
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
                        const data = [
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
        <div class="col-6">
            <div class="card mt-4">
                <div class="card-header text-center">
                    Сумма выплат за последний 7 дней (KZT)
                </div>
                <div class="card-body">
                    @php
                        $notifications  =   QuestionRepositoryEloquent::priceLastWeek();
                    @endphp
                    <canvas id="payment-last-week" width="400" height="220"
                            aria-label="Сумма выплат за последний 7 дней"></canvas>
                    <script>
                        const notifications = [
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
    </div>
@endsection

@php
    $widgets['after_content'][]    =   [
            'type'    => 'div',
            'class'   => 'row',
            'content' => [
                    [
                        'type'          => 'progress_white',
                        'class'         => 'card mb-2',
                        'value'         =>  '<span class="text-danger">' . QuestionRepositoryEloquent::count([]) . '</span>',
                        'description'   => 'Вопросы',
                        'progress'      => 100, // integer
                        'progressClass' => 'progress-bar bg-danger',
                        'hint'          => QuestionRepositoryEloquent::countLastMonth([]) . ' Запроса за последний 30 дней',
                    ],
                    [
                        'type'          => 'progress_white',
                        'class'         => 'card mb-2',
                        'value'         =>  '<span class="text-danger">' . QuestionRepositoryEloquent::count([\App\Domain\Contracts\Contract::STATUS=>1]) . '</span>',
                        'description'   => 'Новый',
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
                    [
                        'type'          => 'progress_white',
                        'class'         => 'card mb-2',
                        'value'         =>  '<span class="text-danger">' . QuestionRepositoryEloquent::count([\App\Domain\Contracts\Contract::STATUS=>0]) . '</span>',
                        'description'   => 'Отменен',
                        'progress'      => 100, // integer
                        'progressClass' => 'progress-bar bg-danger',
                        'hint'          => QuestionRepositoryEloquent::countLastMonth([\App\Domain\Contracts\Contract::STATUS=>0]) . ' запроса за последний 30 дней',
                    ],
                ],
            ];
@endphp

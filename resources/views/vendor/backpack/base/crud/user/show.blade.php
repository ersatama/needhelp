@extends(backpack_view('blank'))

@php
    $defaultBreadcrumbs = [
      trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
      $crud->entity_name_plural => url($crud->route),
      trans('backpack::crud.preview') => false,
    ];

    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <section class="container-fluid d-print-none">
        <a href="javascript: window.print();" class="btn float-right"><i class="la la-print"></i></a>
        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small>{!! $crud->getSubheading() ?? mb_ucfirst(trans('backpack::crud.preview')).' '.$crud->entity_name !!}
                .</small>
            @if ($crud->hasAccess('list'))
                <small class=""><a href="{{ url($crud->route) }}" class="font-sm"><i
                            class="la la-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }}
                        <span>{{ $crud->entity_name_plural }}</span></a></small>
            @endif
        </h2>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="{{ $crud->getShowContentClass() }}">

            {{-- Default box --}}
            <div class="">
                @if ($crud->model->translationEnabled())
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            {{-- Change translation button group --}}
                            <div class="btn-group float-right">
                                <button type="button" class="btn btn-sm btn-primary dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{trans('backpack::crud.language')}}
                                    : {{ $crud->model->getAvailableLocales()[request()->input('_locale')?request()->input('_locale'):App::getLocale()] }}
                                    &nbsp; <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    @foreach ($crud->model->getAvailableLocales() as $key => $locale)
                                        <a class="dropdown-item"
                                           href="{{ url($crud->route.'/'.$entry->getKey().'/show') }}?_locale={{ $key }}">{{ $locale }}</a>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="card no-padding no-border">
                    <table class="table table-striped mb-0">
                        <tbody>
                        @foreach ($crud->columns() as $column)
                            <tr>
                                <td>
                                    <strong>{!! $column['label'] !!}:</strong>
                                </td>
                                <td>
                                    @php
                                        // create a list of paths to column blade views
                                        // including the configured view_namespaces
                                        $columnPaths = array_map(function($item) use ($column) {
                                            return $item.'.'.$column['type'];
                                        }, \Backpack\CRUD\ViewNamespaces::getFor('columns'));

                                        // but always fall back to the stock 'text' column
                                        // if a view doesn't exist
                                        if (!in_array('crud::columns.text', $columnPaths)) {
                                            $columnPaths[] = 'crud::columns.text';
                                        }
                                    @endphp
                                    @includeFirst($columnPaths)
                                </td>
                            </tr>
                        @endforeach
                        @if ($crud->buttons()->where('stack', 'line')->count())
                            <tr>
                                <td><strong>{{ trans('backpack::crud.actions') }}</strong></td>
                                <td>
                                    @include('crud::inc.button_stack', ['stack' => 'line'])
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>{{-- /.box-body --}}
            </div>{{-- /.box --}}

        </div>
    </div>

    @php
        use App\Domain\Repositories\Question\QuestionRepositoryEloquent;
        use App\Domain\Repositories\User\UserRepositoryEloquent;
        use Carbon\Carbon;
        use App\Domain\Contracts\Contract;
        $url    =   explode('/',$_SERVER['REQUEST_URI']);
        $questions  =   QuestionRepositoryEloquent::_getByUserId($url[2]);
    @endphp
    <h4>Вопросы ({{ sizeof($questions) }})</h4>
    @php
        $user   =   UserRepositoryEloquent::_getById($url[2]);
        $status =   [
            'отменен',
            'Ждет ответа',
            'Отвечено'
        ];
    @endphp
    <div class="row">
        <div class="col-8">
            <table class="table bg-white table-bordered text-small">
                <thead>
                <tr>
                    <th scope="col" class="fsize">ID</th>
                    <th scope="col" class="fsize">Статус</th>
                    <th scope="col" class="fsize">Вопрос</th>
                    <th scope="col" class="fsize">Ответ</th>
                    <th scope="col" class="fsize">Юрист</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($questions as &$question)
                    @php
                        $lawyer =   UserRepositoryEloquent::_getById($question->{Contract::LAWYER_ID});
                    @endphp
                    <tr>
                        <th scope="row" class="fsize">{{ $question->{Contract::ID} }}</th>
                        <td class="fsize">
                            @if($question->{Contract::IS_IMPORTANT})
                                <div class="text-danger">Срочный</div>
                            @endif
                            @if($question->{Contract::IS_PAID})
                                <div
                                    class="@if($question->{Contract::STATUS} === 2) bg-success @elseif($question->{Contract::STATUS} === 1) bg-info @else bg-danger @endif rounded text-center mb-2">{{ $status[$question->{Contract::STATUS}] }}</div>
                                @if($question->{Contract::WOOPPAY})
                                    <div class="font-weight-bold">{{ $question->{Contract::WOOPPAY}->{Contract::OPERATION_ID} }}</div>
                                @endif
                            @else
                                <div class="bg-secondary rounded text-center mb-2">Не оплачено</div>
                            @endif
                            @if($question->{Contract::PRICE} > 0)
                                <div class="font-weight-bold text-success">{{ $question->{Contract::PRICE} }} kzt</div>
                            @endif
                        </td>
                        <td class="fsize" width="33%">
                            <div
                                class="text-info font-weight-bold border-bottom pb-2 mb-2">{{  Carbon::createFromTimeStamp(strtotime($question->{Contract::CREATED_AT}))->diffForHumans() }}</div>
                            {{ $question->{Contract::DESCRIPTION} }}
                        </td>
                        <td class="fsize" width="33%">
                            @if($question->{Contract::STATUS} === 2)
                                <div
                                    class="text-info font-weight-bold border-bottom pb-2 mb-2">{{  Carbon::createFromTimeStamp(strtotime($question->{Contract::ANSWERED_AT}))->diffForHumans() }}</div>
                            @endif
                            {{ $question->{Contract::ANSWER} }}
                        </td>
                        <td class="fsize">
                            @if($lawyer)
                                @if ($lawyer->{Contract::ROLE} === Contract::LAWYER)
                                    <a href="/lawyer/{{ $lawyer->{Contract::ID} }}/show"
                                       class="text-info"><u>{{ $lawyer->{Contract::NAME} }} {{ $lawyer->{Contract::SURNAME} }}</u></a>
                                @elseif ($lawyer->{Contract::ROLE} === Contract::ADMIN)
                                    <a href="/admin/{{ $lawyer->{Contract::ID} }}/show"
                                       class="text-info"><u>{{ $lawyer->{Contract::NAME} }} {{ $lawyer->{Contract::SURNAME} }}</u></a>
                                @elseif ($lawyer->{Contract::ROLE} === Contract::USER)
                                    <a href="/user/{{ $lawyer->{Contract::ID} }}/show"
                                       class="text-info"><u>{{ $lawyer->{Contract::NAME} }} {{ $lawyer->{Contract::SURNAME} }}</u></a>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <style>
        .fsize {
            font-size: 12px;
        }
    </style>

@endsection

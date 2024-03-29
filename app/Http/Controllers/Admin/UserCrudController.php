<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Contracts\Contract;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class UserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup(): void
    {
        CRUD::setModel(User::class);

        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('Пользователь', 'Пользователи');
        $this->crud->addClause('where', Contract::ROLE, Contract::USER);
        $this->crud->setShowView('vendor.backpack.base.crud.user.show');
        $this->crud->enableExportButtons();
    }

    protected function extracted()
    {
        CRUD::column(Contract::ID)->label('ID');
        CRUD::column(Contract::LANGUAGE_ID)->label('Язык');
        CRUD::column(Contract::REGION_ID)->label('Область');
        CRUD::column(Contract::ROLE)->label('Роль')
            ->type(Contract::SELECT_FROM_ARRAY)
            ->options([
                Contract::ADMIN     =>  'Администратор',
                Contract::MODERATOR =>  'Модератор',
                Contract::LAWYER    =>  'Юрист',
                Contract::USER      =>  'Пользователь'
            ]);
        CRUD::column(Contract::NAME)->label('Имя');
        CRUD::column(Contract::SURNAME)->label('Фамилия');
        CRUD::column(Contract::LAST_NAME)->label('Отчество');
        CRUD::column(Contract::BIRTHDATE)->label('Дата рождения')->type('date');
        CRUD::column(Contract::PHONE)->label('Телефон номер');
        CRUD::column(Contract::BLOCKED_AT)->label('Дата блокирования');
        CRUD::column(Contract::CREATED_AT)->label('Дата регистрация')->type('date');
        CRUD::column(Contract::LAST_AUTH)->label('Дата последней авторизации')->type('date');
    }

    protected function autoSetupShowOperation()
    {
        $this->extracted();
    }

    protected function setupListOperation(): void
    {
        $this->extracted();
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(UserRequest::class);

        CRUD::field(Contract::LANGUAGE_ID)->label('Язык')->default(1);
        CRUD::field(Contract::REGION_ID)->label('Область');
        CRUD::field(Contract::CITY_ID)->label('Город');
        CRUD::field(Contract::ROLE)->label('Роль')
            ->type(Contract::SELECT_FROM_ARRAY)
            ->options([
                Contract::ADMIN     =>  'Администратор',
                Contract::MODERATOR =>  'Модератор',
                Contract::LAWYER    =>  'Юрист',
                Contract::USER      =>  'Пользователь'
            ])
            ->default(Contract::USER);
        CRUD::field(Contract::NAME)->label('Имя');
        CRUD::field(Contract::SURNAME)->label('Фамилия');
        CRUD::field(Contract::LAST_NAME)->label('Отчество');
        CRUD::field(Contract::GENDER)
            ->label('Пол')
            ->type(Contract::SELECT_FROM_ARRAY)
            ->options([
                Contract::MALE      =>  'Муж',
                Contract::FEMALE    =>  'Жен',
            ]);
        CRUD::field(Contract::BIRTHDATE)->label('Дата рождения')->type('date');
        CRUD::field(Contract::PHONE)->label('Телефон номер');
        CRUD::field(Contract::EMAIL)->label('Эл. почта');
        CRUD::field(Contract::PASSWORD)->label('Пароль')->type('password');
        CRUD::field(Contract::PUSH_NOTIFICATION)
            ->label('Пуш уведомление')
            ->type(Contract::SELECT_FROM_ARRAY)
            ->options([
                true    =>  'Включить',
                false   =>  'Отключить',
            ])
            ->default(false);
        CRUD::field(Contract::BLOCKED_AT)
            ->label('Статус блокирования')
            ->type(Contract::SELECT_FROM_ARRAY)
            ->options([
                true    =>  'Заблокирован',
                false   =>  'Активный',
            ])
            ->default(false);
    }

    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }
}

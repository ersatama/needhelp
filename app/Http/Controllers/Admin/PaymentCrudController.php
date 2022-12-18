<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Contracts\Contract;
use App\Http\Requests\PaymentRequest;
use App\Models\Payment;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class PaymentCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup(): void
    {
        CRUD::setModel(Payment::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/payment');
        CRUD::setEntityNameStrings('Платеж', 'Платежи');
    }

    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }

    protected function setupListOperation(): void
    {
        CRUD::column(Contract::ID)->label('ID');
        CRUD::column(Contract::TITLE)->label('Название');
        CRUD::column(Contract::LOGIN)->label('Логин');
        CRUD::column(Contract::PASSWORD)->label('Пароль');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(PaymentRequest::class);

        CRUD::field(Contract::TITLE)->label('Название')->type('text');
        CRUD::field(Contract::LOGIN)->label('Логин')->type('text');
        CRUD::field(Contract::PASSWORD)->label('Пароль')->type('text');
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}

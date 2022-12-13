<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Contracts\Contract;
use App\Http\Requests\IpRequest;
use App\Models\Ip;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class IpCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup(): void
    {
        CRUD::setModel(Ip::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/ip');
        CRUD::setEntityNameStrings('IP адрес', 'IP адреса');
    }

    protected function setupShowOperation() {
        $this->setupListOperation();
    }

    protected function setupListOperation(): void
    {
        CRUD::column(Contract::IP)->label('IP адрес');
        CRUD::column(Contract::TITLE)->label('Название');
        CRUD::column(Contract::STATUS)
            ->type(Contract::SELECT_FROM_ARRAY)
            ->label('Доступ')
            ->options([
                true    =>  'Доступ открыт',
                false   =>  'Доступ закрыт',
            ]);
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(IpRequest::class);

        CRUD::field(Contract::IP)->label('IP адрес');
        CRUD::field(Contract::TITLE)->label('Название');
        CRUD::field(Contract::STATUS)
            ->type(Contract::SELECT_FROM_ARRAY)
            ->label('Доступ')
            ->options([
                true    =>  'Доступ открыт',
                false   =>  'Доступ закрыт',
            ])
        ->default(true);
    }


    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }
}

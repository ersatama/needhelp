<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Contracts\Contract;
use App\Http\Requests\CountryRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class CountryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Country::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/country');
        CRUD::setEntityNameStrings('Страна', 'Страны');
    }

    protected function setupListOperation(): void
    {
        CRUD::column(Contract::TITLE)->label('Название');
        CRUD::column(Contract::TITLE_KZ)->label('Название (Каз)');
        CRUD::column(Contract::TITLE_EN)->label('Название (Анг)');
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(CountryRequest::class);

        CRUD::field(Contract::TITLE)->label('Название');
        CRUD::field(Contract::TITLE_KZ)->label('Название (Каз)');
        CRUD::field(Contract::TITLE_EN)->label('Название (Анг)');
    }

    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }
}

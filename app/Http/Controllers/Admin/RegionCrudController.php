<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Contracts\Contract;
use App\Http\Requests\RegionRequest;
use App\Models\Region;
use Backpack\CRUD\app\Exceptions\BackpackProRequiredException;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class RegionCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup(): void
    {
        CRUD::setModel(Region::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/region');
        CRUD::setEntityNameStrings('Область', 'Области');
        $this->crud->enableExportButtons();
    }

    protected function setupShowOperation(): void
    {
        $this->setupListOperation();
    }

    protected function setupListOperation(): void
    {
        CRUD::column(Contract::COUNTRY_ID)->labe('Страна');
        CRUD::column(Contract::TITLE)->label('Название');
        CRUD::column(Contract::TITLE_KZ)->label('Название (Каз)');
        CRUD::column(Contract::TITLE_EN)->label('Название (Анг)');
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(RegionRequest::class);

        CRUD::field(Contract::COUNTRY_ID)->labe('Страна');
        CRUD::field(Contract::TITLE)->label('Название');
        CRUD::field(Contract::TITLE_KZ)->label('Название (Каз)');
        CRUD::field(Contract::TITLE_EN)->label('Название (Анг)');
    }

    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }
}

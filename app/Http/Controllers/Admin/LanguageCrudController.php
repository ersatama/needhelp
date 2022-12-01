<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Contracts\Contract;
use App\Http\Requests\LanguageRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class LanguageCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup(): void
    {
        CRUD::setModel(\App\Models\Language::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/language');
        CRUD::setEntityNameStrings('Язык', 'Языки');
    }

    protected function setupShowOperation(): void
    {
        $this->setupListOperation();
    }

    protected function setupListOperation(): void
    {
        CRUD::column(Contract::TITLE)->label('Название');
        CRUD::column(Contract::TITLE_KZ)->label('Название (Каз)');
        CRUD::column(Contract::TITLE_EN)->label('Название (Анг)');
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(LanguageRequest::class);

        CRUD::field(Contract::TITLE)->label('Название');
        CRUD::field(Contract::TITLE_KZ)->label('Название (Каз)');
        CRUD::field(Contract::TITLE_EN)->label('Название (Анг)');
    }

    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }
}

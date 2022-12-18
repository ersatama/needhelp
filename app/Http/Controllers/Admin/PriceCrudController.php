<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Contracts\Contract;
use App\Http\Requests\PriceRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class PriceCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup(): void
    {
        CRUD::setModel(\App\Models\Price::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/price');
        CRUD::setEntityNameStrings('Цена', 'Цены');
    }

    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }

    protected function setupListOperation()
    {
        //CRUD::column('currency_id');
        CRUD::column(Contract::ID)->label('ID');
        CRUD::column(Contract::PRICE)->label('Цена');
        CRUD::column(Contract::IMPORTANT_PRICE)->label('Цена срочного вопроса');
    }
    protected function setupCreateOperation()
    {
        CRUD::setValidation(PriceRequest::class);

        CRUD::field('currency_id');
        CRUD::field('price');
        CRUD::field('important_price');
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}

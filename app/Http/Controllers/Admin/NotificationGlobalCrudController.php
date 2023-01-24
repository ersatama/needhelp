<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Contracts\Contract;
use App\Http\Requests\NotificationGlobalRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class NotificationGlobalCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup(): void
    {
        CRUD::setModel(\App\Models\NotificationGlobal::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/notification-global');
        CRUD::setEntityNameStrings('Уведомление', 'Уведомлении');
    }

    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }

    protected function setupListOperation()
    {
        CRUD::column(Contract::ID)->label('ID');
        CRUD::column(Contract::TEXT)->type('textarea')->label('Текст уведомления');
        CRUD::column(Contract::TEXT_KZ)->type('textarea')->label('Текст уведомления (на казахском)');
        CRUD::column(Contract::TEXT_EN)->type('textarea')->label('Текст уведомления (на английском)');
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(NotificationGlobalRequest::class);
        CRUD::field(Contract::ROLE)->label('Кому отправить уведомление')
            ->type(Contract::HIDDEN)
            ->value(Contract::ALL);
        CRUD::field(Contract::TEXT)->type('textarea')->label('Текст уведомления');
        CRUD::field(Contract::TEXT_KZ)->type('textarea')->label('Текст уведомления (на казахском)');
        CRUD::field(Contract::TEXT_EN)->type('textarea')->label('Текст уведомления (на английском)');
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}

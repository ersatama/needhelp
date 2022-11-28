<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Contracts\Contract;
use App\Http\Requests\NotificationRequest;
use App\Models\Notification;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class NotificationCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup(): void
    {
        CRUD::setModel(Notification::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/notification');
        CRUD::setEntityNameStrings('Уведомление', 'Уведомлении');
    }

    protected function setupShowOperation(): void
    {
        $this->extracted();
    }


    protected function setupListOperation(): void
    {

        $this->extracted();
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(NotificationRequest::class);
        CRUD::field(Contract::USER_ID)->label('ID пользователя');
        CRUD::field(Contract::TITLE)->label('Заголовок');
        CRUD::field(Contract::DESCRIPTION)->label('Описание');
        CRUD::field(Contract::IS_IMPORTANT)
            ->type('select_from_array')
            ->label('Срочный вопрос')
            ->options([
                false   =>  'Нет',
                true    =>  'Да'
            ])
            ->default(false);
        CRUD::field(Contract::STATUS)
            ->type('select_from_array')
            ->label('Статус')
            ->options([
                0   =>  'Отменен',
                1   =>  'В обработке',
                2   =>  'Закрыть'
            ])
            ->default(1);
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }

    /**
     * @return void
     */
    protected function extracted(): void
    {
        CRUD::column(Contract::ID)
            ->label('ID');
        CRUD::column(Contract::USER_ID)
            ->label('ID пользователя');
        CRUD::column(Contract::TITLE)
            ->label('Заголовок');
        CRUD::column(Contract::DESCRIPTION)
            ->label('Описание');
        CRUD::column(Contract::IS_IMPORTANT)
            ->type('select_from_array')
            ->label('Срочный вопрос')->options([
                false => 'Нет',
                true => 'Да'
            ]);
        CRUD::column(Contract::IS_PAID)
            ->type('select_from_array')
            ->label('Оплачено')
            ->options([
                false => 'Нет',
                true => 'Да'
            ]);
        CRUD::column(Contract::STATUS)
            ->type('select_from_array')
            ->label('Статус')
            ->options([
                0   =>  'Отменен',
                1   =>  'В обработке',
                2   =>  'Закрыть'
            ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Contracts\Contract;
use App\Http\Requests\NotificationRequest;
use App\Models\Question;
use Backpack\CRUD\app\Exceptions\BackpackProRequiredException;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class QuestionCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     * @throws BackpackProRequiredException
     */
    public function setup(): void
    {
        CRUD::setModel(Question::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/question');
        CRUD::setEntityNameStrings('Вопрос', 'Вопросы');

        if (backpack_user()->{Contract::ROLE} === Contract::LAWYER) {
            $this->crud->addClause('where', Contract::IS_PAID, true);
            $this->crud->addClause('where', Contract::STATUS, 1);
        } else {
            $this->crud->enableExportButtons();
        }
        $this->crud->orderBy(Contract::IS_IMPORTANT, Contract::DESC);
        $this->crud->orderBy(Contract::CREATED_AT, Contract::DESC);
    }

    public function update(): array|\Illuminate\Http\RedirectResponse
    {
        // do something before validation, before save, before everything; for example:
        // $this->crud->addField(['type' => 'hidden', 'name' => 'author_id']);
        // $this->crud->removeField('password_confirmation');

        // Note: By default Backpack ONLY saves the inputs that were added on page using Backpack fields.
        // This is done by stripping the request of all inputs that do NOT match Backpack fields for this
        // particular operation. This is an added security layer, to protect your database from malicious
        // users who could theoretically add inputs using DeveloperTools or JavaScript. If you're not properly
        // using $guarded or $fillable on your model, malicious inputs could get you into trouble.

        // However, if you know you have proper $guarded or $fillable on your model, and you want to manipulate
        // the request directly to add or remove request parameters, you can also do that.
        // We have a config value you can set, either inside your operation in `config/backpack/crud.php` if
        // you want it to apply to all CRUDs, or inside a particular CrudController:
        // $this->crud->setOperationSetting('saveAllInputsExcept', ['_token', '_method', 'http_referrer', 'current_tab', 'save_action']);
        // The above will make Backpack store all inputs EXCEPT for the ones it uses for various features.
        // So you can manipulate the request and add any request variable you'd like.
        // $this->crud->getRequest()->request->add(['author_id'=> backpack_user()->id]);
        // $this->crud->getRequest()->request->remove('password_confirmation');
        // $this->crud->getRequest()->request->add(['author_id'=> backpack_user()->id]);
        // $this->crud->getRequest()->request->remove('password_confirmation');
        if (backpack_user()->{Contract::ROLE} === Contract::LAWYER) {
            $this->crud->getRequest()->request->remove(Contract::LAWYER_ID);
            $this->crud->getRequest()->request->remove(Contract::STATUS);
            $this->crud->getRequest()->request->remove(Contract::ANSWERED_AT);
            $this->crud->getRequest()->request->add([Contract::LAWYER_ID=>backpack_user()->id]);

            $this->crud->getRequest()->request->add([Contract::STATUS=>2]);
        }

        $response = $this->traitUpdate();
        // do something after save
        return $response;
    }

    protected function setupShowOperation(): void
    {
        $this->extracted();
    }


    protected function setupListOperation(): void
    {

        $this->extracted();
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(NotificationRequest::class);
        if (backpack_user()->{Contract::ROLE} === Contract::ADMIN) {
            $this->crud->addField([
                Contract::NAME  =>  Contract::USER_ID,
                Contract::LABEL =>  'Пользователь',
                Contract::TYPE  =>  Contract::SELECT2_FROM_AJAX,
                Contract::ENTITY    =>  Contract::USER,
                Contract::PLACEHOLDER   => 'ID или Ф.И.О пользователя',
                Contract::MINIMUM_INPUT_LENGTH  =>  '',
                Contract::ATTRIBUTE =>  Contract::FULLNAME,
                Contract::DATA_SOURCE   =>  url('api/v1/user/search')
            ]);

            CRUD::field(Contract::DESCRIPTION)->label('Вопросы');
            CRUD::field(Contract::PRICE)->label('Цена')->type('number');
            CRUD::field(Contract::IS_IMPORTANT)
                ->type('select_from_array')
                ->label('Срочный вопрос')
                ->options([
                    false   =>  'Нет',
                    true    =>  'Да'
                ])
                ->default(false);
            CRUD::field(Contract::IS_PAID)
                ->type('select_from_array')
                ->label('Оплачено')
                ->options([
                    false => 'Нет',
                    true => 'Да'
                ])->default(true);
            CRUD::field(Contract::STATUS)
                ->type('select_from_array')
                ->label('Статус')
                ->options([
                    0   =>  'Отменен',
                    1   =>  'В обработке',
                    2   =>  'Закрыть'
                ])
                ->default(1);
        } else {
            CRUD::field(Contract::LAWYER_ID)->type('hidden');
            CRUD::field(Contract::STATUS)->type('hidden');
            CRUD::field(Contract::ANSWERED_AT)->type('hidden');
            CRUD::field(Contract::CREATED_AT)->label('Создано')->type('date')->attributes([
                Contract::READONLY  =>  Contract::READONLY
            ]);

            CRUD::field(Contract::IS_IMPORTANT)
                ->type('select_from_array')
                ->label('Срочный вопрос')
                ->options([
                    false   =>  'Нет',
                    true    =>  'Да'
                ])->attributes([
                    Contract::READONLY  =>  Contract::READONLY,
                    'disabled'    => 'disabled',
                ]);
            CRUD::field(Contract::PRICE)->label('Цена')->attributes([
                Contract::READONLY  =>  Contract::READONLY
            ]);
            CRUD::field(Contract::USER_ID)
                ->label('ID Пользователя')
                ->type('text')
                ->attributes([
                    Contract::READONLY  =>  Contract::READONLY
                ]);
            CRUD::field(Contract::DESCRIPTION)->label('Вопрос')->attributes([
                Contract::READONLY  =>  Contract::READONLY
            ]);
            CRUD::field(Contract::ANSWER)->label('Ответ')->attributes([

            ]);
        }
    }

    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }

    protected function extracted(): void
    {
        CRUD::column(Contract::ID)
            ->label('ID');
        CRUD::column(Contract::USER)
            ->label('Пользователь')->attribute(Contract::FULLNAME);
        CRUD::column(Contract::LAWYER)
            ->label('Юрист')->attribute(Contract::FULLNAME);
        CRUD::column(Contract::PRICE)
            ->label('Цена');
        CRUD::column(Contract::DESCRIPTION)
            ->label('Вопрос')->limit(1000000);
        CRUD::column(Contract::ANSWER)
            ->label('Ответ')->limit(1000000);
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
                2   =>  'Закрыт'
            ]);
        CRUD::column(Contract::STATUS)
            ->type('date')
            ->label('Отвечено');

    }
}

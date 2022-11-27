<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Contracts\Contract;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup(): void
    {
        CRUD::setModel(User::class);
        Log::info('route',[Route::currentRouteName()]);
        if (Route::currentRouteName() === 'lawyer.index' || Route::currentRouteName() === 'lawyer.search') {

            CRUD::setRoute(config('backpack.base.route_prefix') . '/lawyer');
            CRUD::setEntityNameStrings('Юрист', 'Юристы');
            CRUD::denyAccess('create');
            $this->crud->addClause('where', 'role', 'lawyer');

        } else {
            CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
            CRUD::setEntityNameStrings('user', 'users');
        }


    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation(): void
    {
        CRUD::column('language_id');
        CRUD::column('city_id');
        CRUD::column('name');
        CRUD::column('surname');
        CRUD::column('last_name');
        CRUD::column('gender');
        CRUD::column('birthdate');
        CRUD::column('phone');
        CRUD::column('phone_code');
        CRUD::column('phone_verified_at');
        CRUD::column('email');
        CRUD::column('email_code');
        CRUD::column('email_verified_at');
        CRUD::column('password');
        CRUD::column('remember_token');
        CRUD::column('push_notification');
        CRUD::column('blocked_at');
        CRUD::column('blocked_reason');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(UserRequest::class);

        CRUD::field('language_id');
        CRUD::field('city_id');
        CRUD::field('name');
        CRUD::field('surname');
        CRUD::field('last_name');
        CRUD::field('gender');
        CRUD::field('birthdate');
        CRUD::field('phone');
        CRUD::field('phone_code');
        CRUD::field('phone_verified_at');
        CRUD::field('email');
        CRUD::field('email_code');
        CRUD::field('email_verified_at');
        CRUD::field('password');
        CRUD::field('remember_token');
        CRUD::field('push_notification');
        CRUD::field('blocked_at');
        CRUD::field('blocked_reason');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}

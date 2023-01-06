<?php

use Alexboo\Wooppay\Options;
use Alexboo\Wooppay\Reference;
use Alexboo\Wooppay\Request\CashCreateInvoiceRequest;
use Alexboo\Wooppay\Wooppay;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Middleware\IpAddressMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $wooppay =  new Wooppay();
    $options = new Options('test_merch', 'A12345678a', null, null, true);
    $wooppay->connect($options);
    $request = new CashCreateInvoiceRequest([
        'amount' => 1000,
        'deathDate' => 1000,
        'description' => 'test payment',
        'referenceId' => 1,
        'backUrl' => '/back',
        'requestUrl' => '/request',
    ]);
    $data = $wooppay->cash_createInvoice($request);
    if ($data->error_code == Reference::ERROR_NO_ERRORS) {
        $operationId = $data->response->operationId;
        echo 'ok';
    } else {
        print_r($data);
        echo '<br>';
        echo 'empty';
    }

    return 'hello world!';
    return view('welcome');
});

Route::controller(AuthController::class)->group(function() {
    Route::post('login','login')->name('backpack.auth.login');
});

Route::get('/terms', function () {
    return Response::make(file_get_contents('docs/terms.pdf'), 200, [
        'content-type'=>'application/pdf',
    ]);
});

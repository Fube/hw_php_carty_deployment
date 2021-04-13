<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PHPUnit\TextUI\XmlConfiguration\Group;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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

Route::get('/register', 'App\Http\Controllers\Auth\RegisterController@index')->name('register');
Route::post('/register', 'App\Http\Controllers\Auth\RegisterController@store'); // Note that name is inherited

Route::get('/login', 'App\Http\Controllers\Auth\LoginController@index')->name('login');
Route::post('/login', 'App\Http\Controllers\Auth\LoginController@store'); // Note that name is inherited

Route::post('/logout', 'App\Http\Controllers\Auth\LogoutController@store')->name('logout'); // Note that name is inherited

Route::prefix('admin')->group(function () {

    Route::get('/', 'App\Http\Controllers\Admin\CRUDController@index')->name('admin');

    Route::get('/insert', 'App\Http\Controllers\Admin\CRUDController@getInsert')->name('admin/insert');
    Route::post('/insert', 'App\Http\Controllers\Admin\CRUDController@postInsert');

    Route::get('/update', 'App\Http\Controllers\Admin\CRUDController@getUpdate')->name('admin/update');
    Route::get('/update/{id}', 'App\Http\Controllers\Admin\CRUDController@getFilledUpdate')->name('admin/update/id');
    Route::post('/update/{id}', 'App\Http\Controllers\Admin\CRUDController@postUpdate')->name('admin/update/id');


    Route::get('/delete', 'App\Http\Controllers\Admin\CRUDController@getDelete')->name('admin/delete');
    Route::post('/delete/{id}', 'App\Http\Controllers\Admin\CRUDController@postDelete')->name('admin/delete/id');
});

Route::prefix('item')->group(function() {

    Route::post('/{id}', 'App\Http\Controllers\ItemController@addItem')->name('item');
    Route::delete('/{id}', 'App\Http\Controllers\ItemController@deleteItem');
    Route::put('/{id}', 'App\Http\Controllers\ItemController@decrementItem'); // Used for decrement
});

Route::get('/cart', function(Request $request) {

    $items = Session::get('items');

    if(!$items) {
        return view('posts.cart');
    }

    $toRet = array();
    $total = 0;

    foreach($items as $id => $quantity) {

        $item = DB::table('items')
        ->where('id', $id)
        ->first();

        $item->quantity = $quantity;
        $total += $quantity * $item->price;

        array_push($toRet, $item);
    }

    return view('posts.cart', [
        'items' => $toRet,
        'total' => $total,
    ]);
})
->name('cart');



Route::middleware(['auth'])->group(function () {

    Route::get('/', function () {

        return view('posts.index', [
            'items' => DB::table('items')->paginate(15),
        ]);
    });

    // Route::get('search', function(Request $request) {

    // })
    

    Route::post('search', function(Request $request) {

        $search = $request->input('search');

        return view('posts.index', [
            'items' => DB::table('items')
            ->where('name', $search)
            ->orWhere('name', 'like', '%' . $search . '%')
            ->paginate(15),
        ]);
    })
    ->name('search');
});

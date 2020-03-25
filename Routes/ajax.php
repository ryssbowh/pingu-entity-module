<?php
/*
|--------------------------------------------------------------------------
| Ajax Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register ajax web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group prefixed with ajax which
| contains the "ajax" middleware group.
|
*/

/**
 * Form layout
 */
Route::get('form-layout-options/{field}', ['uses' => 'AjaxFormLayoutController@view'])
    ->name('entity.ajax.viewFormLayoutOptions')
    ->middleware('permission:manage form layouts');
Route::get('form-layout-options/{field}/edit', ['uses' => 'AjaxFormLayoutController@edit'])
    ->name('entity.ajax.editFormLayoutOptions')
    ->middleware('permission:manage form layouts');
Route::post('form-layout-options/{field}', ['uses' => 'AjaxFormLayoutController@validateOptions'])
    ->name('entity.ajax.validateFormLayoutOptions')
    ->middleware('permission:manage form layouts');

/**
 * Field display
 */
Route::get('entity-display-options/{displayer}', ['uses' => 'AjaxDisplayController@view'])
    ->name('entity.ajax.viewDisplayOptions')
    ->middleware('permission:manage display');
Route::get('entity-display-options/{displayer}/edit', ['uses' => 'AjaxDisplayController@edit'])
    ->name('entity.ajax.editDisplayOptions')
    ->middleware('permission:manage display');
Route::post('entity-display-options/{displayer}', ['uses' => 'AjaxDisplayController@validateOptions'])
    ->name('entity.ajax.validateDisplayOptions')
    ->middleware('permission:manage display');
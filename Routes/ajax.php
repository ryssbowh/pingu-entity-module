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
Route::get('field-layout-options/{field}', ['uses' => 'AjaxFieldLayoutController@view'])
    ->name('entity.ajax.viewFieldLayoutOptions')
    ->middleware('permission:manage layout');
Route::get('field-layout-options/{field}/edit', ['uses' => 'AjaxFieldLayoutController@edit'])
    ->name('entity.ajax.editFieldLayoutOptions')
    ->middleware('permission:manage layout');
Route::post('field-layout-options/{field}', ['uses' => 'AjaxFieldLayoutController@validateOptions'])
    ->name('entity.ajax.validateFieldLayoutOptions')
    ->middleware('permission:manage layout');

/**
 * Field display
 */
Route::get('field-display-options/{field_displayer}', ['uses' => 'AjaxFieldDisplayController@view'])
    ->name('entity.ajax.viewFieldDisplayOptions')
    ->middleware('permission:manage display');
Route::get('field-display-options/{field_displayer}/edit', ['uses' => 'AjaxFieldDisplayController@edit'])
    ->name('entity.ajax.editFieldDisplayOptions')
    ->middleware('permission:manage display');
Route::post('field-display-options/{field_displayer}', ['uses' => 'AjaxFieldDisplayController@validateOptions'])
    ->name('entity.ajax.validateFieldDisplayOptions')
    ->middleware('permission:manage display');
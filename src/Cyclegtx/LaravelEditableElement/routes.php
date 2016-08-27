<?php
Route::group(['prefix' => 'cyclegtx'],function(){
    Route::post('/editable','Cyclegtx\LaravelEditableElement\EditableController@index');
});
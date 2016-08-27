<?php

Route::group(['prefix' => 'cyclegtx'],function(){
    Route::post('/editable','cyclegtx\Editable\EditableController@index');
});
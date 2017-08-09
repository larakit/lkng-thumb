<?php
/**
 * Created by Larakit.
 * Link: http://github.com/larakit
 * User: Alexey Berdnikov
 * Date: 19.06.17
 * Time: 11:24
 */

//################################################################################
//      получение превьюшек
//################################################################################
Route::any('!/thumb/{model}/{id}', function () {
    $model = \Larakit\NgAdminlte\LkNgThumb::model();
    if($model) {
        return [
            'result' => 'success',
            'model'  => $model->toArray(),
        ];
    }
    
    return [
        'result'  => 'error',
        'message' => 'Изображение не загружено',
    ];
})->name('thumb-data');
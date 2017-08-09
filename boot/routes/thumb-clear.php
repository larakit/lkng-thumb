<?php
/**
 * Created by Larakit.
 * Link: http://github.com/larakit
 * User: Alexey Berdnikov
 * Date: 09.08.17
 * Time: 14:29
 */
//################################################################################
//      очистка превьюшки
//################################################################################
Route::post('!/thumb/{model}/{id}/{type}/clear', function () {
    $model = \Larakit\NgAdminlte\LkNgThumb::model();
    if($model) {
        $type = Request::route('type');
        if($model->thumbClear($type)) {
            return [
                'result'  => 'success',
                'message' => 'Миниатюры очищены',
                'type'    => $type,
                'model'   => $model->toArray(),
            ];
        } else {
            return [
                'result'  => 'error',
                'message' => 'Изображение не найдено',
                'type'    => $type,
                'model'   => $model->toArray(),
            ];
        }
        
    }
})->name('thumb-clear');
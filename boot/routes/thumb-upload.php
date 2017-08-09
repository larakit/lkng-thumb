<?php
/**
 * Created by Larakit.
 * Link: http://github.com/larakit
 * User: Alexey Berdnikov
 * Date: 09.08.17
 * Time: 14:28
 */
//################################################################################
//      загрузка превьюшки
//################################################################################
Route::post('!/thumb/{model}/{id}/{type}/upload', function () {
    $model = \Larakit\NgAdminlte\LkNgThumb::model();
    if($model) {
        $type = Request::route('type');
        $model->thumbHashed();
        if($model->thumbUpload($type)) {
            return [
                'result'  => 'success',
                'message' => 'Изображение успешно загружено',
                'type'    => $type,
                'model'   => $model->toArray(),
            ];
        } else {
            return [
                'result'  => 'error',
                'message' => 'Изображение не загружено',
                'type'    => $type,
                'model'   => $model->toArray(),
            ];
        }
        
    }
})->name('thumb-upload');
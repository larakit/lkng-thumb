<?php
/**
 * Created by Larakit.
 * Link: http://github.com/larakit
 * User: Alexey Berdnikov
 * Date: 09.08.17
 * Time: 14:29
 */
//################################################################################
//      загрузка превьюшки
//################################################################################
Route::post('!/thumb/{model}/{id}/{type}/{size}/crop', function () {
    $model       = \Larakit\NgAdminlte\LkNgThumb::model();
    $model_class = \Larakit\NgAdminlte\LkNgThumb::modelClass();
    if($model) {
        $type        = \Request::route('type');
        $size        = \Request::route('size');
        $thumb_class = \Illuminate\Support\Arr::get($model_class::thumbsConfig(), $type);
        if(class_exists($thumb_class)) {
            /** @var \Larakit\Thumb\Thumb $thumb */
            $thumb         = new $thumb_class($model->id);
            $file_original = $thumb->makePath();
            $crop          = \Image::make($file_original);
            $file_thumb    = $thumb->makePath($size);
            $x             = (int) Request::input('x');
            $y             = (int) Request::input('y');
            $crop_w        = (int) Request::input('width');
            $crop_h        = (int) Request::input('height');
            $rotate        = (int) Request::input('rotate');
            $crop_x_left   = ($x < 0) ? 0 : $x;
            $crop_y_top    = ($y < 0) ? 0 : $y;
            $crop_x_right  = min($crop->width(), $crop_w + $x);
            $crop_y_bottom = min($crop->height(), $crop_h + $y);
            $thumb_w       = $crop_x_right - $crop_x_left;
            $thumb_h       = $crop_y_bottom - $crop_y_top;
            $crop
                ->rotate(0 - $rotate)
                ->crop($thumb_w, $thumb_h, $crop_x_left, $crop_y_top);
            
            $bg       = \Image::canvas($crop_w, $crop_h, null);
            $offset_x = ($x < 0) ? abs($x) : 0;
            $offset_y = ($y < 0) ? abs($y) : 0;
            $bg->insert($crop, 'top-left', $offset_x, $offset_y);
            $bg->save($file_thumb);
            
            if($thumb->processingSize($file_thumb, $size)) {
                return [
                    'result'  => 'success',
                    'message' => 'Изображение успешно загружено',
                    'model'   => $model->toArray(),
                ];
            }
        }
    }
    
    return [
        'result'  => 'error',
        'message' => 'Изображение не загружено',
    ];
})->name('thumb-crop');
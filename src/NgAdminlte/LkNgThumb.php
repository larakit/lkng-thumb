<?php
/**
 * Created by Larakit.
 * Link: http://github.com/larakit
 * User: Alexey Berdnikov
 * Date: 22.05.17
 * Time: 13:27
 */

namespace Larakit\NgAdminlte;

use Illuminate\Support\Arr;

class LkNgThumb {
    
    protected static $models = [];
    
    static function modelRegister($model_class) {
        self::$models[$model_class::getThumbKey()] = $model_class;
    }
    
    static function models() {
        return self::$models;
    }
    
    static function modelClass() {
        $key = \Request::route('model');
        
        return Arr::get(self::$models, $key);
    }
    
    static function getKey($model_class) {
        return array_search($model_class, self::$models);
    }
    
    static function model() {
        $model_class = self::modelClass();
        
        if(!class_exists($model_class)) {
            return null;
        }
        $id = (int) \Request::route('id');
        if(!is_callable($model_class . '::getThumbKey')) {
            return null;
        }
        
        return $model_class::find($id);
    }
}
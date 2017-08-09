<?php
/**
 * Created by Larakit.
 * Link: http://github.com/larakit
 * User: Alexey Berdnikov
 * Date: 26.06.17
 * Time: 14:29
 */
\Larakit\Boot::register_boot(__DIR__ . '/boot');

//##################################################
//      Регистрация компонента страницы
//##################################################
$components_directory = '/packages/larakit/lkng-thumb/components/';
\Larakit\NgAdminlte\LkNgComponent::register('adminlte-thumb-step1', $components_directory);
\Larakit\NgAdminlte\LkNgComponent::register('adminlte-thumb-step2', $components_directory);
\Larakit\NgAdminlte\LkNgComponent::register('adminlte-thumb-step3', $components_directory);

\Larakit\StaticFiles\Manager::package('larakit/lkng-thumb')
    ->usePackage('larakit/ng-adminlte')
    ->setSourceDir('public')
    ->jsPackage('services/lk-thumb.js');
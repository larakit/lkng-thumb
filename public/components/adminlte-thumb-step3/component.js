(function () {

    angular
        .module('larakit')
        .component('adminlteThumbStep3', {
            templateUrl: '/packages/larakit/lkng-thumb/components/adminlte-thumb-step3/component.html',
            bindings: {
                resolve: '<',
                close: '&',
                dismiss: '&'
            },
            controller: Controller
        });

    Controller.$inject = ['$http', '$scope', '$timeout', 'hotkeys', 'safeApply', 'LkThumb'];

    function Controller($http, $scope, $timeout, hotkeys, safeApply, LkThumb) {
        var data,
            $crop_img_final = $('#crop_img_final'),
            $crop_img_original = $('#crop_img_original'),
            $ctrl = this;
        $ctrl.thumb = {};

        $ctrl.$onInit = function () {
            $ctrl.size = $ctrl.resolve.size;
            $ctrl.thumber = $ctrl.resolve.thumber;
            $ctrl.w = $ctrl.thumber.sizes[$ctrl.size].w;
            $ctrl.h = $ctrl.thumber.sizes[$ctrl.size].h;
            $ctrl.is_round = $ctrl.thumber.sizes[$ctrl.size].is_round;
            if ($ctrl.w) {
                $crop_img_final.attr('width', $ctrl.w);
                $crop_img_original.css('width', $ctrl.w);
            }
            if ($ctrl.h) {
                $crop_img_final.attr('height', $ctrl.h);
                $crop_img_original.css('height', $ctrl.h);
            }
        };
        $ctrl.buttonRotateRight = function () {
            $crop_img_original.cropper('rotate', 5);
        };
        $ctrl.buttonRotateLeft = function () {
            $crop_img_original.cropper('rotate', -5);
        };
        hotkeys.add({
            combo: 'right',
            description: 'По часовой',
            callback: function (event, hotkey) {
                $ctrl.buttonRotateRight();
            }
        });

        hotkeys.add({
            combo: 'left',
            description: 'Против часовой',
            callback: function (event, hotkey) {
                $ctrl.buttonRotateLeft();
            }
        });

        $ctrl.$postLink = function () {
            $timeout(function () {
                $crop_img_original.attr('src', LkThumb.refreshHash($ctrl.thumber.original));
                console.log($crop_img_final.attr('width'), $crop_img_final.attr('height'));
                console.log('$ctrl',$ctrl.w, $ctrl.h);
                if ($ctrl.w) {
                    $crop_img_final.attr('width', $ctrl.w);
                    $crop_img_original.css('width', $ctrl.w);
                }
                if ($ctrl.h) {
                    $crop_img_final.attr('height', $ctrl.h);
                    $crop_img_original.css('height', $ctrl.h);
                }
                var k, options = {
                    autoCrop: true,
                    background: false,
                    preview: '#crop_img_final',
                    minContainerHeight: 600,
                    crop: function (dataNew) {
                        $scope.dataScopped = $crop_img_original.cropper('getCroppedCanvas').toDataURL('image/png');
                        $scope.data = {
                            x: dataNew.x,
                            y: dataNew.y,
                            rotate: dataNew.rotate,
                            width: dataNew.width,
                            height: dataNew.height
                        };
                        if (!$ctrl.thumber.sizes[$ctrl.size].h) {
                            k = $ctrl.thumber.sizes[$ctrl.size].w / dataNew.width;
                            $ctrl.h = parseInt(k * dataNew.height);
                        }
                        $crop_img_final.attr('width', $ctrl.w);
                        $crop_img_final.attr('height', $ctrl.h);
                        safeApply($scope);
                    }
                };
                if ($ctrl.w && $ctrl.h) {
                    options.aspectRatio = $ctrl.w / $ctrl.h;
                } else {
                    options.aspectRatio = NaN;
                }
                $crop_img_original.cropper(options);
            }, 500);
        };

        $ctrl.cancel = function () {
            $ctrl.dismiss({$value: 'cancel'});
        };
        $ctrl.ok = function () {
            $http.post($ctrl.thumber.sizes[$ctrl.size].url_crop, $scope.data)
                .then(function (response) {
                    larakit_toastr(response.data);
                    $ctrl.close();
                });
        };
    }
})();
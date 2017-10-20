(function () {

    angular
        .module('lkng-thumb')
        .component('adminlteThumbStep1', {
            templateUrl: '/packages/larakit/lkng-thumb/components/adminlte-thumb-step1/component.html',
            bindings: {
                model: '=',
                isRound: '=?'
            },
            controller: Controller
        });

    Controller.$inject = ['$uibModal', '$http', 'LkThumb'];

    function Controller($uibModal, $http, LkThumb) {
        var $ctrl = this;

        $ctrl.load = function (type) {
            $http
                .get($ctrl.model.thumbs[type].url_thumb)
                .then(function (response) {
                    $ctrl.model = LkThumb.refreshHashModel(response.data.model);
                });
        };

        $ctrl.gotoStep2 = function (type) {
            var modalInstance = $uibModal.open({
                animation: true,
                ariaLabelledBy: 'modal-title-bottom',
                ariaDescribedBy: 'modal-body-bottom',
                component: 'adminlteThumbStep2',
                size: 'lg',
                resolve: {
                    model: function () {
                        return $ctrl.model;
                    },
                    type: function () {
                        return type;
                    }
                }
            });
            modalInstance.result.then(function (o) {
                $ctrl.load(type);
            }, function () {
                $ctrl.load(type);
            });
        };

    }
})();
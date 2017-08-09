(function () {

    angular
        .module('larakit')
        .factory('LkThumb', Factory);

    Factory.$inject = [];

    function Factory() {
        var self = this;

        return {
            refreshHash: refreshHash,
            refreshHashModel: refreshHashModel
        };

        function refreshHash(url) {
            var _url = url.split('?', 2);
            return _url[0] + '?' + Math.random();
        }

        function refreshHashModel(model) {
            if (!model.thumbs) {
                return model;
            }
            var url;
            angular.forEach(model.thumbs, function (thumber, type) {
                angular.forEach(thumber.sizes, function (thumb, size) {
                    if (thumb.url) {
                        model.thumbs[type].sizes[size].url = refreshHash(thumb.url);
                    }
                });
            });
            return model;
        }

    }

})();
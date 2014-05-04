'use strict';

angular
    .module('adminApp')
    .controller('listInspectionsCtrl', ['$scope', '$inspectionsRepository', function ($scope, $inspectionsRepository) {
        $scope.inspectionIds = [];

        $inspectionsRepository.getInspectionIds().then(function (data) {
            $scope.inspectionIds = data;
        });
    }]);

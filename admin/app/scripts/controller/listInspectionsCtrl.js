'use strict';

angular
    .module('RoaveDeveloperToolsAdmin')
    .controller('listInspectionsCtrl', ['$scope', '$inspectionsRepository', function ($scope, $inspectionsRepository) {
        $scope.inspectionIds = [];

        $inspectionsRepository.getInspectionIds().then(function (data) {
            $scope.inspectionIds = data;
        });
    }]);

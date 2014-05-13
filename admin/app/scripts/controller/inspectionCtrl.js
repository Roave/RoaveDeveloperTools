'use strict';

angular
    .module('adminApp')
    .controller('inspectionCtrl', ['$scope', '$routeParams', '$inspectionsRepository', function ($scope, $routeParams, $inspectionsRepository) {
        $scope.inspection = null;

        $inspectionsRepository.getInspectionById($routeParams.inspectionId).then(function (inspection) {
            $scope.inspection = inspection;
        });
    }]);

'use strict';

angular
    .module('adminApp')
    .controller('inspectionCtrl', ['$scope', '$routeParams', '$inspectionsRepository', function ($scope, $routeParams, $inspectionsRepository) {
        $scope.inspection = null;
        $scope.composer = null;

        $inspectionsRepository.getInspectionById($routeParams.inspectionId).then(function (inspection) {
            $scope.inspection = inspection;

            var idx, inspections = inspection.data.inspectionData;

            // could need some underscore.js here:
            for (idx in inspections) {
                if (inspections.hasOwnProperty(idx)
                    && inspections[idx].inspectionType === 'Roave\\DeveloperTools\\Inspection\\ComposerInspection'
                ) {
                    $scope.composer = inspections[idx].inspectionData;
                }
            }
        });
    }]);

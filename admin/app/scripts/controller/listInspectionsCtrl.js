'use strict';

angular
    .module('adminApp')
    .controller('listInspectionsCtrl', function ($scope, $inspectionsRepository) {
        $scope.inspectionIds = $inspectionsRepository.getInspectionIds();
    });

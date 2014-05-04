'use strict';

angular.module('adminApp')
    .controller('MainCtrl', function ($scope, $inspectionsRepository) {
        console.log($inspectionsRepository);
        $scope.awesomeThings = [
            'HTML5 Boilerplate',
            'AngularJS',
            'Karma'
        ];

        $scope.inspectionIds = $inspectionsRepository.getInspectionIds();
    });

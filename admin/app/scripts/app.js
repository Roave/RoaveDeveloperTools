'use strict';

angular
    .module('RoaveDeveloperToolsAdmin', [
        'ngResource',
        'ngRoute',
        'ngPrettyJson'
    ])
    .config(['$routeProvider', '$provide', function ($routeProvider, $provide) {
        $routeProvider
            .when('/', {
                templateUrl: 'views/main.html',
                controller: 'MainCtrl'
            })
            .when('/list-inspections', {
                templateUrl: 'views/list-inspections.html',
                controller: 'listInspectionsCtrl'
            })
            .when('/inspection/:inspectionId', {
                templateUrl: 'views/inspection.html',
                controller: 'inspectionCtrl'
            })
            .otherwise({
                redirectTo: '/'
            });

        $provide.constant(
            'RDT_REPORTS',
            {
                'base-report': 'views/report/base-report.html',
                'config-report': 'views/report/config-report.html'
            }
        );
    }]);

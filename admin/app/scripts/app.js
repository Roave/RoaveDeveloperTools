'use strict';

angular
    .module('adminApp', [
        'ngResource',
        'ngRoute'
    ])
    .config(function ($routeProvider, $locationProvider) {
        $locationProvider.html5Mode(true).hashPrefix('!');

        $routeProvider
            .when('/', {
                templateUrl: 'views/main.html',
                controller: 'MainCtrl'
            })
            .when('/inspections', {
                templateUrl: '/views/inspections/index.html',
                controller: 'listInspectionsCtrl'
            })
            .when('/inspections/:inspectionId', {
                templateUrl: '/views/inspections/show.html',
                controller: 'inspectionCtrl'
            })
            .otherwise({
                redirectTo: '/'
            });
    });

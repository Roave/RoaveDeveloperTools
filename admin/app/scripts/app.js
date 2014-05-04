'use strict';

angular
    .module('adminApp', [
        'ngResource',
        'ngRoute'
    ])
    .config(function ($routeProvider) {
        $routeProvider
            .when('/', {
                templateUrl: 'views/main.html',
                controller: 'MainCtrl'
            })
            .when('/list-inspections', {
                templateUrl: 'views/list-inspections.html',
                controller: 'listInspectionsCtrl'
            })
            .otherwise({
                redirectTo: '/'
            });
    });

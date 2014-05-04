'use strict';

var InspectionsRepository = InspectionsRepository || function Inspection () {};

angular
    .module('adminApp')
    .factory('$inspectionsRepository', ['$http', function ($http) {
        return new InspectionsRepository($http);
    }]);

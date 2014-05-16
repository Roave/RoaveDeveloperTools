'use strict';

var InspectionsRepository = InspectionsRepository || function Inspection () {};

angular
    .module('RoaveDeveloperToolsAdmin')
    .factory('$inspectionsRepository', ['$http', function ($http) {
        return new InspectionsRepository($http);
    }]);

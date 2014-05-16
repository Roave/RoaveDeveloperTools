'use strict';

describe('Controller: listInspectionsCtrl', function () {

    // load the controller's module
    beforeEach(module('RoaveDeveloperToolsAdmin'));

    var listInspectionsCtrl,
        scope;

    // Initialize the controller and a mock scope
    beforeEach(inject(function ($controller, $rootScope) {
        scope = $rootScope.$new();

        // mocking the repository
        var $inspectionsRepository = {
            getInspectionIds: function () {
                // mocking a promise
                return {
                    then: function (cb) {
                        cb(['aa', 'bb', 'cc']);
                    }
                };
            }
        };

        listInspectionsCtrl = $controller('listInspectionsCtrl', {
            $scope: scope,
            $inspectionsRepository: $inspectionsRepository
        });
    }));

    it('should put the inspections identifiers in the current view', function () {
        expect(scope.inspectionIds).toEqual(['aa', 'bb', 'cc']);
    });
});

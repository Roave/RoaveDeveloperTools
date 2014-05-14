'use strict';

describe('Controller: inspectionCtrl', function () {

    // load the controller's module
    beforeEach(module('RoaveDeveloperToolsAdmin'));

    var inspectionCtrl,
        scope;

    // Initialize the controller and a mock scope
    beforeEach(inject(function ($controller, $rootScope) {
        scope = $rootScope.$new();

        // mocking the repository
        var $inspectionsRepository = {
            getInspectionById: function (id) {
                // mocking a promise
                return {
                    then: function (cb) {
                        cb(new Inspection(id, {'foo': 'bar'}));
                    }
                }
            }
        };

        inspectionCtrl = $controller('inspectionCtrl', {
            $scope: scope,
            $routeParams: {inspectionId: 123},
            $inspectionsRepository: $inspectionsRepository
        });
    }));

    it('should load the current inspection in the scope', function () {
        expect(scope.inspection instanceof Inspection).toBeTruthy();
        expect(scope.inspection.id).toBe(123);
        expect(scope.inspection.data.foo).toBe('bar');
    });
});

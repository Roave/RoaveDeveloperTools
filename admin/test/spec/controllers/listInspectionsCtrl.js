'use strict';

describe('Controller: listInspectionsCtrl', function () {

    // load the controller's module
    beforeEach(module('adminApp'));

    var listInspectionsCtrl,
        scope;

    // Initialize the controller and a mock scope
    beforeEach(inject(function ($controller, $rootScope) {
        scope = $rootScope.$new();

        var $inspectionsRepository = {
            getInspectionIds: function () {
                return ['aa', 'bb', 'cc'];
            }
        };

        listInspectionsCtrl = $controller('listInspectionsCtrl', {
            $scope: scope,
            $inspectionsRepository: $inspectionsRepository
        });
    }));

    it('should put the inspections identifiers in the current view', function () {
        expect(scope.inspectionIds.length).toBe(3);
        expect(scope.inspectionIds[0]).toBe('aa');
        expect(scope.inspectionIds[1]).toBe('bb');
        expect(scope.inspectionIds[2]).toBe('cc');
    });
});

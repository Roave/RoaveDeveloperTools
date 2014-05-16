'use strict';

describe('Entity: Inspection', function () {
    it('should have a set identifier', function () {
        expect((new Inspection(123, {})).id).toBe(123);
    });

    it('should have a set string identifier', function () {
        expect((new Inspection('abc', {})).id).toBe('abc');
    });

    it('should have a inspection data', function () {
        expect((new Inspection(123, {inspectionData: {foo: 'bar'}})).getData()).toEqual({foo: 'bar'});
    });

    it('should always have sub-inspections', function () {
        expect((new Inspection(123, {})).getSubInspections()).toEqual([]);
    });

    it('should have sub-inspections if they are an array', function () {
        expect((new Inspection(123, {inspectionData: ['a', 'b', 'c']}))
            .getSubInspections())
            .toEqual([
                new Inspection('123-1', 'a'),
                new Inspection('123-2', 'b'),
                new Inspection('123-3', 'c')
            ]);
    });

    it('should have sub-inspections if they are an array', function () {
        expect((new Inspection(123, {inspectionData: {foo: 'bar'}})).getSubInspections()).toEqual([]);
    });
});

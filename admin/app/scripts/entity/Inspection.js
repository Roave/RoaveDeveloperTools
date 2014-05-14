'use strict';

(function (exports) {
    function Inspection (id, data) {
        this.id   = id;
        this.data = data;
    }

    Inspection.prototype = {
        getType: function () {
            return this.data.inspectionType;
        },

        getSubInspections: function () {
            var inspectionData = this.data.inspectionData,
                idx = 0,
                id = this.id;

            if (!Array.isArray(inspectionData)) {
                return [];
            }

            return inspectionData.map(function (inspection) {
                return new Inspection(id + '-' + (idx += 1), inspection);
            });
        },

        getData: function () {
            return this.data.inspectionData;
        }
    };

    exports.Inspection = Inspection;
}(window));

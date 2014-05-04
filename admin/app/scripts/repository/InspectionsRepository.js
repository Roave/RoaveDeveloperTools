'use strict';

var Inspection = Inspection || function Inspection () {};

(function (exports) {
    function InspectionsRepository ($http) {
        this.$http = $http;
    }

    InspectionsRepository.prototype = {
        getInspectionIds: function () {
            // @todo inject URI base path here?
            return this
                .$http
                .get('/roave-developer-tools/inspections')
                .then(function (data) {
                    var ids = [];

                    for (var idx in data.inspections) {
                        ids.push(idx);
                    }

                    return ids;
                });
        },

        getInspectionById: function (id) {
            // @todo inject URI base path here?
            return this
                .$http
                .get('/roave-developer-tools/inspections')
                .then(function (data) {
                    return new Inspection(id, data);
                });
        }
    };

    exports.InspectionsRepository = InspectionsRepository;
}(window));

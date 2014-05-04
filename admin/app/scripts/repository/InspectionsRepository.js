'use strict';

var Inspection = Inspection || function Inspection () {};

(function (exports) {
    function InspectionsRepository ($http) {
        this.$http = $http;
    }

    InspectionsRepository.prototype = {
        /**
         * Retrieve the list of existing inspection identifiers
         *
         * @returns $q.defer a promise to be resolved with a list of identifiers
         */
        getInspectionIds: function () {
            // @todo inject URI base path here?
            return this
                .$http
                .get('http://localhost:8888/roave-developer-tools/inspections')
                .then(function (data) {
                    if (! data.data.inspections) {
                        return [];
                    }

                    var ids = [];

                    for (var idx in data.data.inspections) {
                        if (data.data.inspections.hasOwnProperty(idx)) {
                            ids.push(idx);
                        }
                    }

                    return ids;
                });
        },

        /**
         * Retrieve an inspection by ID
         *
         * @param {String} id
         *
         * @returns $q.defer a promise to be resolved with the {Inspection} instance
         */
        getInspectionById: function (id) {
            // @todo inject URI base path here?
            return this
                .$http
                .get('http://localhost:8888/roave-developer-tools/inspections')
                .then(function (data) {
                    return new Inspection(id, data);
                });
        }
    };

    exports.InspectionsRepository = InspectionsRepository;
}(window));

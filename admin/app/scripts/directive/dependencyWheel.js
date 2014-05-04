'use strict';

d3.chart = d3.chart || {};

angular
    .module('adminApp')
    .directive('dependencyWheel', function () {
        return {
            scope: {
                composer: '='
            },
            template: '<div></div>',
            restrict: 'E',
            link: function postLink(scope, element, attrs) {
                scope.$watchCollection('[composer]', function (newVal, oldVal) {
                    if (! newVal[0]) {
                        return;
                    }

                    var graphEl = element.find("div:first");
                    graphEl.html('');

                    var chart = d3
                        .chart
                        .dependencyWheel()
                        .width(700)
                        .margin(150)
                        .padding(.02);

                    d3
                        .select(graphEl[0])
                        .datum(buildMatrixFromComposerJsonAndLock(
                            newVal[0]['composer.json'],
                            newVal[0]['composer.lock']
                        ))
                        .call(chart)
                        .render();
                });
                //element.text('some content');
            }
        };
    });

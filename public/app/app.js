var app = angular.module('principalBase', ['ngMaterial', 'ui.bootstrap'], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});
var ruta=window.location.origin + '/';
app.constant('API_URL', ruta);


    app.filter('startFrom', function () {
        return function (input, start) {
            if (input) {
                start = +start;
                return input.slice(start);
            }
            return [];
        };
    }); 


var app = angular.module('principalBase', ['ngMaterial', 'ui.bootstrap'], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});
app.constant('API_URL', 'http://localhost/garciaelectricidad2017/public/');

    app.filter('startFrom', function () {
        return function (input, start) {
            if (input) {
                start = +start;
                return input.slice(start);
            }
            return [];
        };
    }); 

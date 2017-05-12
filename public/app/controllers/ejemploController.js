app.controller('ejemploController', function($scope, $http, API_URL, filterFilter) { 

    $scope.cargaInicial = function() {
        console.log('Funciona Ejemplo Controller');
        console.log('Modifica la carga inicial');
        // $http.get(API_URL + "RUTA_API")
        //     .success(function(response) {
        //         $scope.datos = response.datos;
        // }).
        // error(function(response) {
        //      sweetAlert("Ups...", "¡Ocurrió un error!", "Error");
        // });
    }
});

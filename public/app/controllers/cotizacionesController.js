app.controller('cotizacionesController', function($scope, $http, API_URL, filterFilter) { 
    
    $scope.search="";
    $scope.search2="";
    $scope.searchMats="";
    $scope.pageSize= 10;
    //Mandar la hora del server
    var hoy=moment().format("YYYY-MM-DD");

    $scope.cargaInicial = function() {
        $http.get(API_URL + "obtenerCotizaciones")
            .success(function(response) {
                $scope.cotizaciones = response.cotizaciones;
                $scope.clientes = response.clientes;
                $scope.formRegister={'fecha': hoy, 'fecha_impresion': hoy};
                //$scope.formRegister.fecha=moment().format("YYYY-MM-DD");
                //console.log($scope.tipos);
                //console.log($scope.grupos);
                $scope.$watch('search', function (term) {
                    $scope.filteredcotizaciones = filterFilter($scope.cotizaciones, term);
                    $scope.currentPage = 1;
                });
        }).
        error(function(response) {
             sweetAlert("Ups...", "¡Ocurrió un error!", "Error");
        });
    }

    $scope.borrar=function (id) {
        swal({  title: "¿Está seguro de eliminar esta cotización?",   
                text: "No se podrá recuperar",   
                type: "warning",   
                showCancelButton: true, 
                cancelButtonText: "Cancelar",  
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: "¡Si, Borrar!",   
                closeOnConfirm: false 
                }, function(){
                    $scope.datos={"id":id};
                    $http({
                        method: 'POST',
                        data: $.param($scope.datos),
                        url: API_URL + 'removerCotizacion',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).
                    success(function(response) {
                        swal("¡Éxito!", "La cotización fue eliminada con éxito.", "success");
                            $scope.cotizaciones = response;

                            $scope.$watch('search', function (term) {
                            $scope.filteredcotizaciones = filterFilter($scope.cotizaciones, term);
                            $scope.currentPage = 1;
                            });            
                    }).
                    error(function(response) {
                        sweetAlert("Oops...", "Ocurrió un error!", "error");
                    }); 
           });
        }

    $scope.submitRegisterCotizacion = function() { 
        $http({
            method: 'POST',
            data: $.param($scope.formRegister),
            url: API_URL + 'registrarCotizacion',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).
        success(function(response) { //Modificar para registrar grupo con modal
                angular.element('#dataRegister').modal('hide');
                swal("¡Éxito!", "La cotización fue registrada con éxito.", "success");
                $scope.cotizaciones = response.cotizaciones;
                $scope.clientes = response.clientes;
                $scope.$watch('search', function (term) {
                    $scope.filteredcotizaciones = filterFilter($scope.cotizaciones, term);
                    $scope.currentPage = 1;
                });
                //Reiniciando modal
                $scope.formRegister.descripcion="";
                $scope.formRegister.cliente="";
                $scope.formRegister.fecha=moment().format("YYYY-MM-DD");;
                $scope.formRegister.fecha_impresion=moment().format("YYYY-MM-DD");;

        }).
        error(function(response) {
            sweetAlert("Oops...", "Ocurrió un error!", "error");
        });
    };

    $scope.submitUpdateCotizacion = function() {
        $scope.formUpdate={"id":angular.element('#id').val(), "descripcion":angular.element('#descripcion1').val(),"id_cliente":angular.element('#cliente1').val(),"fecha":angular.element('#datepicker3').val(), "fecha_impresion":angular.element('#datepicker4').val()};
        $http({
            method: 'POST',
            data: $.param($scope.formUpdate),
            url: API_URL + 'actualizarCotizacion',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).
        success(function(response) {
            angular.element('#dataUpdate').modal('hide');
            swal("¡Éxito!", "La cotización fue actualizada con éxito.", "success");
                $scope.cotizaciones = response;
                $scope.$watch('search', function (term) {
                    $scope.filteredcotizaciones = filterFilter($scope.cotizaciones, term);
                    $scope.currentPage = 1;
                });
              
        }).
            error(function(response) {
                sweetAlert("Oops...", "Ocurrió un error!", "error");
        }); 
    };

    $scope.gruposCotizacion = function(id) {
        $scope.datos={"id":id};
        $http({
            method: 'POST',
            data: $.param($scope.datos),
            url: API_URL + 'gruposCotizacion',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).
            success(function(response) {
                $scope.gruposCotizacion = response;
                console.log($scope.gruposCotizacion);           
        }).
        error(function(response) {
            sweetAlert("Oops...", "Ocurrió un error!", "error");
        }); 
    }

    $scope.eliminarGrupoCotizacion=function (id_cot, id_grupo) {
        swal({  title: "¿Está seguro de eliminar este grupo?",   
                text: "No se podrá recuperar",   
                type: "warning",   
                showCancelButton: true, 
                cancelButtonText: "Cancelar",  
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: "¡Si, Borrar!",   
                closeOnConfirm: false 
                }, function(){
                    $scope.datos={"id_cot":id_cot, "id_grupo":id_grupo};
                    $http({
                        method: 'POST',
                        data: $.param($scope.datos),
                        url: API_URL + 'removerGrupoCotizacion',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).
                    success(function(response) {
                        swal("¡Éxito!", "La cotización fue eliminada con éxito.", "success");
                            $scope.gruposCotizacion = response;         
                    }).
                    error(function(response) {
                        sweetAlert("Oops...", "Ocurrió un error!", "error");
                    }); 
           });
        }
});

app.controller('clientesController', function($scope, $http, API_URL, filterFilter) { 
    
    $scope.search="";
    $scope.search2="";
    $scope.searchMats="";
    $scope.pageSize= 10;
    
    $scope.cargaInicial = function() {
        $http.get(API_URL + "obtenerClientes")
            .success(function(response) {
                $scope.clientes = response.clientes;
                $scope.$watch('search', function (term) {
                    $scope.filteredclientes = filterFilter($scope.clientes, term);
                    $scope.currentPage = 1;
                });
        }).
        error(function(response) {
             sweetAlert("Ups...", "¡Ocurrió un error!", "Error");
        });
    }

    $scope.borrar=function (id) {
        swal({  title: "¿Está seguro de eliminar este Cliente?",   
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
                        url: API_URL + 'removerCliente',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).
                    success(function(response) {
                        swal("¡Éxito!", "El cliente fue eliminado con éxito.", "success");
                            $scope.clientes = response.clientes;

                            $scope.$watch('search', function (term) {
                            $scope.filteredclientes = filterFilter($scope.clientes, term);
                            $scope.currentPage = 1;
                            });            
                    }).
                    error(function(response) {
                        sweetAlert("Oops...", "Ocurrió un error!", "error");
                    }); 
           });
        }

    $scope.submitRegisterCliente = function() { 
        $http({
            method: 'POST',
            data: $.param($scope.formRegister),
            url: API_URL + 'registrarCliente',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).
        success(function(response) { //Modificar para registrar grupo con modal
                angular.element('#dataRegister').modal('hide');
                swal("¡Éxito!", "El cliente fue registrado con éxito.", "success");
                $scope.clientes = response.clientes;
                $scope.$watch('search', function (term) {
                $scope.filteredclientes = filterFilter($scope.clientes, term);
                $scope.currentPage = 1;
                });
                //Reiniciando modal
                $scope.formRegister.nombre="";
                $scope.formRegister.telefono="";
                $scope.formRegister.correo="";


        }).
        error(function(response) {
            sweetAlert("Oops...", "Ocurrió un error!", "error");
        });
    };

    $scope.submitUpdateCliente = function() {
        $scope.formUpdate={"nombre1":angular.element('#nombre1').val(),"email1":angular.element('#correo1').val(),"id":angular.element('#id').val(), "telefono1":angular.element('#telefono1').val()};
        $http({
            method: 'POST',
            data: $.param($scope.formUpdate),
            url: API_URL + 'actualizarCliente',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).
        success(function(response) {
            swal("¡Éxito!", "El cliente fue actualizado con éxito.", "success");
            angular.element('#dataUpdate').modal('hide');
                $scope.clientes = response.clientes;
                $scope.$watch('search', function (term) {
                $scope.filteredclientes = filterFilter($scope.clientes, term);
                $scope.currentPage = 1;
            });
              
        }).
            error(function(response) {
                sweetAlert("Oops...", "Ocurrió un error!", "error");
        }); 
    };
});

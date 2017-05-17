app.controller('materialesController', function($scope, $http, API_URL, filterFilter) { 
    
    $scope.search="";
    $scope.pageSize= 20;
    
    $scope.cargaInicial = function() {
        $http.get(API_URL + "obtenerMateriales")
            .success(function(response) {
                $scope.materiales = response;
                //console.log($scope.materiales);
                $scope.$watch('search', function (term) {
                    $scope.filteredmateriales = filterFilter($scope.materiales, term);
                    $scope.currentPage = 1;
                });
        }).
        error(function(response) {
             sweetAlert("Ups...", "¡Ocurrió un error!", "Error");
        });
    }

     $scope.submitRegister = function() { 
        $http({
            method: 'POST',
            data: $.param($scope.formRegister),
            url: API_URL + 'registrarMaterial',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).
        success(function(response) {
            if(response==0){
                angular.element('#lastcode').html("");
                angular.element('#errorCodigo').html("Error Código Repetido");
                angular.element('#errorCodigo').css({'color': 'red'});
            }
            else{
                angular.element('#dataRegister').modal('hide');
                angular.element('#lastcode').html("");

                swal("¡Éxito!", "El material fue registrado con éxito.", "success");
                $scope.materiales = response;

                $scope.$watch('search.todo', function (term) {
                $scope.filteredmateriales = filterFilter($scope.materiales, term);
                $scope.currentPage = 1;
                });
                //Reiniciando modal
                $scope.formRegister.descripcion="";
                $scope.formRegister.clasificacion="";
                $scope.formRegister.codigoMaterial="";
                $scope.formRegister.cantidad="";
                $scope.formRegister.precio="";
                $scope.formRegister.unidad="";
            }

        }).
        error(function(response) {
            sweetAlert("Oops...", "Ocurrió un error!", "error");
        });
    };

    $scope.submitUpdate = function() {
        $scope.formUpdate={"descripcion1":angular.element('#descripcion1').val(),"clasificacion1":angular.element('#clasificacion1').val(),"id":angular.element('#id').val(),
        "codigo1":angular.element('#codigo1').val(),"cantidad1":angular.element('#cantidad1').val(),"precio1":angular.element('#precio1').val(),"unidad1":angular.element('#unidad1').val()};
        $http({
            method: 'POST',
            data: $.param($scope.formUpdate),
            url: API_URL + 'actualizarMaterial',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).
        success(function(response) {
            angular.element('#dataUpdate').modal('hide');

            swal("¡Éxito!", "El material fue actualizado con éxito.", "success");
            $scope.materiales = response;

            $scope.$watch('search.todo', function (term) {
            $scope.filteredmateriales = filterFilter($scope.materiales, term);
            $scope.currentPage = 1;
            });
              
        }).
            error(function(response) {
                sweetAlert("Oops...", "Ocurrió un error!", "error");
        }); 
    };

    $scope.borrar=function (id) {
        swal({  title: "¿Está seguro de eliminar este material?",   
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
                        url: API_URL + 'removerMaterial',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).
                    success(function(response) {
                        swal("¡Éxito!", "El material fue eliminado con éxito.", "success");
                            $scope.materiales = response;

                            $scope.$watch('search.todo', function (term) {
                            $scope.filteredmateriales = filterFilter($scope.materiales, term);
                            $scope.currentPage = 1;
                            });            
                    }).
                    error(function(response) {
                        sweetAlert("Oops...", "Ocurrió un error!", "error");
                    }); 
           });
        }

});

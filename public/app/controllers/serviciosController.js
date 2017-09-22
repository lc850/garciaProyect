app.controller('serviciosController', function($scope, $http, API_URL, filterFilter) { 
    
    $scope.search="";
    $scope.search2="";
    $scope.searchMats="";
    $scope.pageSize= 10;
    
    $scope.cargaInicial = function() {
        $http.get(API_URL + "obtenerServicios")
            .success(function(response) {
                $scope.servicios = response;
                //$scope.tipos = response.tipos;
                //console.log($scope.tipos);
                $scope.$watch('search', function (term) {
                    $scope.filteredservicios = filterFilter($scope.servicios, term);
                    $scope.currentPage = 1;
                });
        }).
        error(function(response) {
             sweetAlert("Ups...", "¡Ocurrió un error!", "Error");
        });
    }

    $scope.borrar=function (id) {
        swal({  title: "¿Está seguro de eliminar este servicio?",   
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
                        url: API_URL + 'removerServicio',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).
                    success(function(response) {
                        swal("¡Éxito!", "El servicio fue eliminado con éxito.", "success");
                            $scope.servicios = response;

                            $scope.$watch('search.todo', function (term) {
                            $scope.filteredservicios = filterFilter($scope.servicios, term);
                            $scope.currentPage = 1;
                            });            
                    }).
                    error(function(response) {
                        sweetAlert("Oops...", "Ocurrió un error!", "error");
                    }); 
           });
        }

    $scope.submitRegisterServicio = function() { 
        console.log($scope.formServicios);
        $http({
            method: 'POST',
            data: $.param($scope.formServicios),
            url: API_URL + 'registrarServicio',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).
        success(function(response) { //Modificar para registrar grupo con modal
                angular.element('#dataRegister').modal('hide');
                swal("¡Éxito!", "El grupo fue registrado con éxito.", "success");
                $scope.servicios = response;
                $scope.$watch('search.todo', function (term) {
                $scope.filteredservicios = filterFilter($scope.servicios, term);
                $scope.currentPage = 1;
                });
                //Reiniciando modal
                $scope.formServicios.nombre="";
                $scope.formServicios.codigoServicio="";
                $scope.formServicios.unidad="";
                $scope.formServicios.precio="";

        }).
        error(function(response) {
            sweetAlert("Oops...", "Ocurrió un error!", "error");
        });
    };

    $scope.submitUpdateServicio = function() {
        $scope.formUpdate={"nombre":angular.element('#nombre1').val(),"id":angular.element('#ids').val(),"unidad":angular.element('#unidad1').val(), "precio":angular.element('#precio1').val(), "codigo":angular.element('#codigoServicio1').val()};
        $http({
            method: 'POST',
            data: $.param($scope.formUpdate),
            url: API_URL + 'actualizarServicio',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).
        success(function(response) {
            angular.element('#dataUpdate').modal('hide');
                $scope.servicios = response;
                $scope.$watch('search.todo', function (term) {
                $scope.filteredservicios = filterFilter($scope.servicios, term);
                $scope.currentPage = 1;
            });
              
        }).
            error(function(response) {
                sweetAlert("Oops...", "Ocurrió un error!", "error");
        }); 
    };

    $scope.borrarMaterial=function (id, id_gpo) {
        swal({  title: "¿Está seguro de eliminar este material?",   
                text: "No se podrá recuperar",   
                type: "warning",   
                showCancelButton: true, 
                cancelButtonText: "Cancelar",  
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: "¡Si, Borrar!",   
                closeOnConfirm: false 
                }, function(){
                    $scope.datos={"id":id, "id_gpo":id_gpo};
                    $http({
                        method: 'POST',
                        data: $.param($scope.datos),
                        url: API_URL + 'removerMaterialGrupo',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).
                    success(function(response) {
                        swal("¡Éxito!", "El grupo fue eliminado con éxito.", "success");
                            $scope.mats_gpo = response.materiales_grupo;
                            $scope.materiales = response.materiales;
                            $scope.$watch('searchMats', function (term) {
                            $scope.filteredmateriales = filterFilter($scope.materiales, term);
                            $scope.currentPage = 1;
                        });           
                    }).
                    error(function(response) {
                        sweetAlert("Oops...", "Ocurrió un error!", "error");
                    }); 
           });
        }
    $scope.agregarMaterialGrupo = function(id_mat, id_gpo, gpo_nom, unidad) {
        $cantidad=0;
        $scope.datos="";
        swal({
            title: "Cantidad:",
            text: gpo_nom+" ("+unidad+")",
            type: "input",
            showCancelButton: true,
            closeOnConfirm: false,
            animation: "slide-from-top",
            inputPlaceholder: "Teclea la cantidad"
            },
            function(inputValue){
                if (inputValue === false) 
                return false;      
                if (inputValue === "") {     
                    swal.showInputError("Teclea una cantidad");     
                    return false;   
                } 
                if(isNaN(inputValue)){
                    swal.showInputError("Teclea un número");
                    return false;    
                }
                if (inputValue <= 0) {     
                    swal.showInputError("Teclea un número mayor que 0");     
                    return false;
                }
                cantidad=inputValue;
                $scope.datos={"id_mat":id_mat, "id_gpo":id_gpo, "cantidad":cantidad};
                $http({
                        method: 'POST',
                        data: $.param($scope.datos),
                        url: API_URL + 'agregarMaterialGrupo',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).
                    success(function(response) {
                        swal("Correcto!", "Cantidad: " + inputValue, "success");
                            $scope.mats_gpo = response.materiales_grupo;
                            $scope.materiales = response.materiales;
                            $scope.$watch('searchMats', function (term) {
                            $scope.filteredmateriales = filterFilter($scope.materiales, term);
                            $scope.currentPage = 1;
                        });           
                    }).
                    error(function(response) {
                        sweetAlert("Oops...", "Ocurrió un error!", "error");
                    }); 
            });
    }

    $scope.validaDescripcion = function(){
        $scope.datos={"nombre": $scope.formServicios.nombre};
        $http({
                method: 'POST',
                data: $.param($scope.datos),
                url: API_URL + 'existeNombreServicio',  
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).
                success(function(response) {
                    if(response==0){
                        document.getElementById("submit").disabled = false; 
                        document.getElementById("error").innerHTML = "";
                    }
                    else{
                        document.getElementById("submit").disabled = true; 
                        document.getElementById("error").innerHTML = "El nombre del servicio ya existe, teclea otro."; 
                    }          
                }).
                error(function(response) {
                    sweetAlert("Oops...", "Ocurrió un error!", "error");
                }); 
    }

});

app.controller('gruposController', function($scope, $http, API_URL, filterFilter) { 
    
    $scope.search="";
    $scope.search2="";
    $scope.searchMats="";
    $scope.pageSize= 10;
    
    $scope.cargaInicial = function() {
        $http.get(API_URL + "obtenerGrupos")
            .success(function(response) {
                $scope.grupos = response.grupos;
                $scope.tipos = response.tipos;
                //console.log($scope.tipos);
                $scope.$watch('search', function (term) {
                    $scope.filteredgrupos = filterFilter($scope.grupos, term);
                    $scope.currentPage = 1;
                });
        }).
        error(function(response) {
             sweetAlert("Ups...", "¡Ocurrió un error!", "Error");
        });
    }

    $scope.borrar=function (id) {
        swal({  title: "¿Está seguro de eliminar este grupo?",   
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
                        url: API_URL + 'removerGrupo',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).
                    success(function(response) {
                        swal("¡Éxito!", "El grupo fue eliminado con éxito.", "success");
                            $scope.grupos = response;

                            $scope.$watch('search.todo', function (term) {
                            $scope.filteredgrupos = filterFilter($scope.grupos, term);
                            $scope.currentPage = 1;
                            });            
                    }).
                    error(function(response) {
                        sweetAlert("Oops...", "Ocurrió un error!", "error");
                    }); 
           });
        }

    $scope.submitRegisterGrupo = function() { 
        $http({
            method: 'POST',
            data: $.param($scope.formRegister),
            url: API_URL + 'registrarGrupo',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).
        success(function(response) { //Modificar para registrar grupo con modal
                angular.element('#dataRegister').modal('hide');
                swal("¡Éxito!", "El grupo fue registrado con éxito.", "success");
                $scope.grupos = response.grupos;
                $scope.tipos = response.tipos;
                $scope.$watch('search.todo', function (term) {
                $scope.filteredgrupos = filterFilter($scope.grupos, term);
                $scope.currentPage = 1;
                });
                //Reiniciando modal
                $scope.formRegister.descripcion="";
                $scope.formRegister.tipo="";

        }).
        error(function(response) {
            sweetAlert("Oops...", "Ocurrió un error!", "error");
        });
    };

    $scope.submitUpdateGrupo = function() {
        $scope.formUpdate={"descripcion1":angular.element('#descripcion1').val(),"tipo1":angular.element('#tipo1').val(),"id":angular.element('#id').val()};
        $http({
            method: 'POST',
            data: $.param($scope.formUpdate),
            url: API_URL + 'actualizarGrupo',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).
        success(function(response) {
            angular.element('#dataUpdate').modal('hide');
                $scope.grupos = response.grupos;
                $scope.tipos = response.tipos;
                $scope.$watch('search.todo', function (term) {
                $scope.filteredgrupos = filterFilter($scope.grupos, term);
                $scope.currentPage = 1;
            });
              
        }).
            error(function(response) {
                sweetAlert("Oops...", "Ocurrió un error!", "error");
        }); 
    };

    $scope.materialesGrupo = function(id) {
        $http.get(API_URL + "obtenerMaterialesGrupo/"+id)
            .success(function(response) {
                $scope.mats_gpo = response.materiales_grupo;
                $scope.materiales = response.materiales;
                $scope.$watch('searchMats', function (term) {
                $scope.filteredmateriales = filterFilter($scope.materiales, term);
                $scope.currentPage = 1;
            });
        }).
        error(function(response) {
             sweetAlert("Ups...", "¡Ocurrió un error!", "Error");
        });
    }

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
        $scope.datos={"descripcion": $scope.formRegister.descripcion};
        $http({
                method: 'POST',
                data: $.param($scope.datos),
                url: API_URL + 'existeNombreGrupo',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).
                success(function(response) {
                    if(response==0){
                        document.getElementById("submit").disabled = false; 
                        document.getElementById("error").innerHTML = "";
                    }
                    else{
                        document.getElementById("submit").disabled = true; 
                        document.getElementById("error").innerHTML = "La descripción del grupo ya existe, teclea otra."; 
                    }          
                }).
                error(function(response) {
                    sweetAlert("Oops...", "Ocurrió un error!", "error");
                }); 
    }

});

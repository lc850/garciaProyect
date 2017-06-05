app.controller('cotizacionesController', function($scope, $http, API_URL, filterFilter) { 
    
    $scope.search="";
    $scope.search2="";
    $scope.search3="";
    $scope.searchMats="";
    $scope.pageSize= 8;
    //Mandar la hora del server
    var hoy=moment().format("YYYY-MM-DD");

    $scope.cargaInicial = function() {
        $http.get(API_URL + "obtenerCotizaciones")
            .success(function(response) {
                $scope.cotizaciones = response.cotizaciones;
                $scope.clientes = response.clientes;
                //console.log($scope.cotizaciones);
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
                $scope.gruposCotizacion = response.grupos_cotizacion;
                console.log($scope.gruposCotizacion); return;
                $scope.gpoNoCot=response.gpo_noCot;
                $scope.materiales=response.materiales;
                $scope.$watch('searchMats', function (term) {
                    $scope.filteredmateriales = filterFilter($scope.materiales, term);
                    $scope.currentPage = 1;
                });
                $scope.$watch('search3', function (term) {
                    $scope.filteredgpoNoCot = filterFilter($scope.gpoNoCot, term);
                    $scope.currentPage = 1;
                });
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
                        swal("¡Éxito!", "El grupo fue eliminado con éxito.", "success");
                        $scope.gruposCotizacion = response.grupos_cotizacion;
                        $scope.gpoNoCot=response.gpo_noCot;
                        $scope.$watch('search2', function (term) {
                        $scope.filteredgpoNoCot = filterFilter($scope.gpoNoCot, term);
                        $scope.currentPage = 1;
                        });      
                    }).
                    error(function(response) {
                        sweetAlert("Oops...", "Ocurrió un error!", "error");
                    }); 
           });
        }

    $scope.agregarGrupoCotizacion = function(id_cot, gpo, descripcion) {
        $cantidad=0;
            swal({
                title: "Cantidad:",
                text: "Grupo: "+descripcion,
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
                    $scope.datos={"id_cot":id_cot, "id_gpo":gpo, "cantidad_gpo":cantidad};
                    $http({
                        method: 'POST',
                        data: $.param($scope.datos),
                        url: API_URL + 'agregarGrupoCotizacion',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).
                    success(function(response) {
                        if(response.vacio==0){
                            sweetAlert("Oops...", "¡El grupo no se puede agregar porque está vacío!", "error");
                            return;
                        }
                        swal("¡Éxito!", "El grupo fue agregado con éxito.", "success");
                            $scope.gruposCotizacion = response.grupos_cotizacion;
                            $scope.gpoNoCot=response.gpo_noCot;
                            $scope.$watch('search3', function (term) {
                            $scope.filteredgpoNoCot = filterFilter($scope.gpoNoCot, term);
                            $scope.currentPage = 1;
                        });         
                    }).
                    error(function(response) {
                        sweetAlert("Oops...", "Ocurrió un error!", "error");
                    });
                }); 
    }

    $scope.borrarMaterial=function (id_detalle, id_cot) {
        swal({  title: "¿Está seguro de eliminar este material?",   
                text: "No se podrá recuperar",   
                type: "warning",   
                showCancelButton: true, 
                cancelButtonText: "Cancelar",  
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: "¡Si, Borrar!",   
                closeOnConfirm: false 
                }, function(){
                    $scope.datos={"id":id_detalle, "id_cot":id_cot};
                    $http({
                        method: 'POST',
                        data: $.param($scope.datos),
                        url: API_URL + 'removerMaterialCotizacion',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).
                    success(function(response) {
                        swal("¡Éxito!", "El material fue eliminado con éxito.", "success");
                            $scope.gruposCotizacion = response.grupos_cotizacion;
                            $scope.gpoNoCot=response.gpo_noCot;
                            $scope.$watch('search3', function (term) {
                            $scope.filteredgpoNoCot = filterFilter($scope.gpoNoCot, term);
                            $scope.currentPage = 1;
                        });             
                    }).
                    error(function(response) {
                        sweetAlert("Oops...", "Ocurrió un error!", "error");
                    }); 
           });
        }
    $scope.cargaDatos = function (id_cot, id_gpo, cant_gpo){
        $scope.datosCotizacion={"id_cot": id_cot, "id_gpo": id_gpo, "cant_gpo": cant_gpo};
    }

    $scope.agregarMaterialGrupoCotizacion = function(mat) {
        id_cot=$scope.datosCotizacion.id_cot;
        id_gpo=$scope.datosCotizacion.id_gpo;
        cant_gpo=$scope.datosCotizacion.cant_gpo;
        $scope.datos={"id_cot": id_cot, "id_gpo": id_gpo, "id_mat": mat.id};
        $http({
            method: 'POST',
            data: $.param($scope.datos),
            url: API_URL + 'existeMaterialGrupo',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).
        success(function(response) {
            if(response==0){
                $cantidad=0;
                $scope.datos="";
                swal({
                    title: "Cantidad:",
                    text: mat.descripcion+" ("+mat.unidad+")",
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
                        $scope.datos={"id_mat":mat.id, "id_gpo":id_gpo, "id_cot":id_cot, "cantidad":cantidad, "precio":mat.precio, "cant_gpo": cant_gpo};
                        $http({
                                method: 'POST',
                                data: $.param($scope.datos),
                                url: API_URL + 'agregarMaterialGrupoCotizacion',
                                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                            }).
                            success(function(response) {
                                swal("Correcto!", "Se agregaron " + inputValue + " " +mat.descripcion, "success");
                                    $scope.gruposCotizacion = response.grupos_cotizacion;
                                    $scope.gpoNoCot=response.gpo_noCot;
                                    $scope.$watch('search3', function (term) {
                                    $scope.filteredgpoNoCot = filterFilter($scope.gpoNoCot, term);
                                    $scope.currentPage = 1;
                                });          
                            }).
                            error(function(response) {
                                sweetAlert("Oops...", "Ocurrió un error!", "error");
                            }); 
                    });
            }
            else{
                sweetAlert("Oops...", "¡El Material ya existe en este grupo!", "error");
            }        
        }).
        error(function(response) {
            sweetAlert("Oops...", "Ocurrió un error!", "error");
        }); 
    }
});

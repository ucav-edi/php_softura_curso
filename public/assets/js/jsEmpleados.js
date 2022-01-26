//se prepara el documento para las funciones en javascript
//para poder llamar por ejemplo. los botones... se usan los valores de id
//se sustituyen en # en javascript

$(document).ready(function (){
    //se crea una variable con funciones a usar en el cuerpo del documento
    var opEmpleados = {
        //funcion para listar empleados
        listadoEmpleados : function () {
            //metodo para enviar en la tabla una columna de texto simulando una pantalla de procesando.
            //se envia usando un formato html() y dentro del html codigo del texto de la columna
            $('#tablaResultadosEmpleados').html('<tr><td colspan="5" class="text-center">Procesando...</td></tr>');
            //se envia una respuesta ajax (Asincronous JavaScript and XML) para enviar los datos
            //para este tipo se usa el tipo de respuesta (get o post) para el servidor
            $.ajax({
                type: 'post',
                url: 'http://localhost/php_puro_softura-main_1/rutas/empleados.php?peticion=empleados&funcion=listado',
                data: $('#formEmpleado').serialize(),
                //data:{},
                dataType:'json',
                success : function (respAjax) {
                    if(respAjax.success){
                        var html_registros_empleados = '';
                        respAjax.data.empleados.forEach(function(empleado){
                            var strEmpleadoObj = btoa(JSON.stringify(empleado));
                            var strDatoscontado = '';
                            empleado.datos_contacto.forEach(function(contacto){
                                strDatoscontado += '<li> '+contacto.tipo+': '+contacto.dato_contacto+'</li>';
                            });
                            html_registros_empleados += '<tr id = "renglonEmpleado'+empleado.id+'">' +
                                '<td>'+empleado.clave+'</td>' +
                                '<td>'+empleado.nombres+' '+empleado.apellido_paterno+' '+empleado.apellido_materno+'</td>' +
                                '<td>'+empleado.direccion+'</td>' +
                                '<td>'+strDatoscontado+'</td>' +
                                '<td>' +
                                '<button type="button" data-str_empleado_obj="'+strEmpleadoObj+'"' +
                                    'class="btn btn-warning btnModificarEmp">Modificar</button>' +
                                '<button type="button" data-str_empleado_obj="'+strEmpleadoObj+'"' +
                                    'class="btn btn-danger btnEliminarEmp">Eliminar</button>' +
                                '<button type="button" class="btn btn-success btnAddDatosContacto"' +
                                    'data-bs-toggle="modal" data-bs-target="#ModalDatosContacto"' +
                                    'data-id_empleado="'+empleado.id+'">Agregar Datos Contacto</button>' +
                                '</td>' +
                                '</tr>';
                        });
                        $('#tablaResultadosEmpleados').html(html_registros_empleados);
                    }

                },error : function (err){
                    alert('error en la peticion de catalogos');
                }

            });

        },
        guardarEmpleado :function () {
            var funcion = $('#inputIdEmp').val()=='0'? 'guardar':'actualizar';
            $.ajax({
                type : 'post',
                url: 'http://localhost/php_puro_softura-main_1/rutas/empleados.php?peticion=empleados&funcion='+funcion,
                data : $('#formularioEmpleado').serialize(),
                dataType: 'json',
                success:function (respAjax) {
                    if(respAjax.success){
                        $('#contenidoFormEmpledo').fadeOut();
                        $('#tableroEmpleados').fadeIn();
                        opEmpleados.listadoEmpleados();
                    }else{
                        var html_mensajes = '';
                        respAjax.msg.forEach(function (mensaje) {
                            html_mensajes+= '<li>'+mensaje+'</li>';
                        });
                        $('#divMensajesSistema').html(html_mensajes).fadeIn();
                        setTimeout(function(){
                            $('#divMensajesSistema').html('').fadeOut();
                        },10000);

                    }
                },error :function (err) {
                    alert('error en la peticion de catalogos');

                }
            });
        },
        eliminarEmpleado: function (empleado_id) {
            $.ajax({
                type : 'post',
                url: 'http://localhost/php_puro_softura-main_1/rutas/empleados.php?peticion=empleados&funcion=eliminar',
                //data : $('#inputIdEmp').serialize(),
                data:{
                    id:empleado_id,
                },
                dataType : 'json',
                success : function (respAjax) {
                    if(respAjax.success){
                        //$('#tableroEmpleados').fadeOut();
                        //$('#tableroEmpleados').fadeIn();
                        //opEmpleados.listadoEmpleados();
                        $('#renglonEmpleado'+empleado_id).remove();
                    }else{
                        var html_mensajes = '';
                        respAjax.msg.forEach(function (mensaje) {
                            html_mensajes+= '<li>'+mensaje+'</li>';
                        });
                        $('#divMensajesSistema').html(html_mensajes).fadeIn();
                        setTimeout(function(){
                            $('#divMensajesSistema').html('').fadeOut();
                        },10000);
                    }

                },error :function (err) {
                    alert('error en la peticion de catalogos');
                }
            })
        },
    }

    //se regresa el resultado de la funcion listadoEmpleados
    opEmpleados.listadoEmpleados();

    $(document).on('click','#botonAgregarEmpleado',function () {
        $('#contenidoFormEmpledo').fadeIn();
        $('#tableroEmpleados').fadeOut();
        //mandamos a llamar la funcion del js Catalogos
        //obtener_cat_estado
        $('#tituloFormEmpleado').html('Registrar nuevo empleado');
        $('#formularioEmpleado')[0].reset();
        $('#inputIdEmp').val(0);
    });

    $(document).on('click','#btnRegistrarEmp',function () {
        opEmpleados.guardarEmpleado();
    });

    $(document).on('click','#btnCGuardar',function () {
        $('#contenidoFormEmpledo').fadeOut();
        $('#tableroEmpleados').fadeIn();
    });

    $(document).on('click','#btnCancelEmpleado',function () {
        $('#contenidoFormEmpledo').fadeOut();
        $('#tableroEmpleados').fadeIn();
    });



    $(document).on('click','.btnModificarEmp',function () {
        $('#btnRegistrarEmp').html('Guardar Cambios');
        var botonModificar = $(this);
        $('#contenidoFormEmpledo').fadeIn();
        $('#tableroEmpleados').fadeOut();
        //llamar la funcion del js de catalogo -> obtener estado
        //Catalogos.obtener_catalogo_estado();
        $('#tituloFormEmpleado').html('Modificar empleado');
        var empleado = JSON.parse(atob(botonModificar.data('str_empleado_obj')));
        $('#inputIdEmp').val(empleado.id);
        $('#inputClave').val(empleado.clave);
        $('#inputNombre').val(empleado.nombres);
        $('#inputApellidoP').val(empleado.apellido_paterno);
        $('#inputApellidoM').val(empleado.apellido_materno);
        $('#inputDireccion').val(empleado.direccion);
        $('#inputListaEstado').val(empleado.catalogo_estado_id);
    });

    $(document).on('click','.btnEliminarEmp',function () {
        var botonEliminar = $(this);
        var empleadoEliminar = JSON.parse(atob(botonEliminar.data('str_empleado_obj')));
        //$('#inputIdEmp').val(empleadoEliminar.id);
        var confirmacion = confirm("Estas seguro de eliminar este registro?");
        if(confirmacion){
            opEmpleados.eliminarEmpleado(empleadoEliminar.id);
        }
      });
    $(document).on('click','.btnAddDatosContacto',function () {
        //$('#modalFormDatosContacto').modal('show');
    });

})




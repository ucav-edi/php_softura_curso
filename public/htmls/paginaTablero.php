<!--- parte donde se crea el cuerpo de la pagina--->
<!--- se crea una tabla para representar los empleados
debido a algunas funciones que se implementaran para el
funcionamiento de la tabla, se crearan id a algunos elementos
de la pagina para usarlos con algunas funciones javascripts
creadas"
--->

<table id="tableroEmpleados" class="table table-striped">
    <!--- se crea cabeza de la tabla--->
    <thead>
        <!--- se define una fila de la tabla.. funcionara como titulo --->
        <tr>
           <!--- se definen los titulos de columna de la tabla --->
            <th scope="col">Clave</th>
            <th scope="col">Nombre y Apellidos</th>
            <th scope="col">Dirección</th>
            <!---<th scope="col">Estado</th> --->
            <th scope="col">Datos de Contacto</th>
            <th scope="col" ><button class="btn btn-dark" id="botonAgregarEmpleado">Agregar</button>
            </th>
        </tr>
    </thead>

    <tbody id="tablaResultadosEmpleados">
        <!---<tr>
            <td>prueba texto mensaje</td>
            <td>prueba texto mensaje</td>
            <td>prueba texto mensaje</td>
            <td>prueba texto mensaje</td>
            <td>
                <button class="btn btn-success" id="botoneditarEmpleado">editar empleado</button>
                <button class="btn btn-danger" id="botonEliminarEmpleado">eliminar empleado</button>
            </td>
        </tr>
        --->
    </tbody>
</table>
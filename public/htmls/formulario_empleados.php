<!--- contenido para llenar por hileras el un tablero para empleados--->
<div class="row" id="contenidoFormEmpledo" style="display: none">
    <div class="col">
    </div>
    <div class="col">
        <div class="card">
            <div class="card-header" id="tituloFormEmpleado">
                Registrar Empleado
            </div>
            <div class="card-body">
                <!--- Formulario para llenar/agregar empleado--->
                <form id="formularioEmpleado" method="post">
                    <input type="hidden" id="inputIdEmp" name="id" value="0">
                    <div class="mb-3">
                        <label for="inputClave" class="form-label">Clave Emplado</label>
                        <input type="text" class="form-control" id="inputClave" name="clave">
                    </div>
                    <div class="mb-3">
                        <label for="inputNombre" class="form-label">Nombre Emplado</label>
                        <input type="text" class="form-control" id="inputNombre" name="nombres">
                    </div>
                    <div class="mb-3">
                        <label for="inputApellidoP" class="form-label">Apellido Paterno</label>
                        <input type="text" class="form-control" id="inputApellidoP" name="apellido_paterno">
                    </div>
                    <div class="mb-3">
                        <label for="inputApellidoM" class="form-label">Apellido Materno</label>
                        <input type="text" class="form-control" id="inputApellidoM" name="apellido_materno">
                    </div>
                    <div class="mb-3">
                        <label for="inputDireccion" class="form-label">Direccion</label>
                        <input type="text" class="form-control" id="inputDireccion" name="direccion">
                    </div>

                    <div class="mb-3">
                        <label for="inputListaEstado" class="form-label">Estado</label>
                        <select id="inputListaEstado" class="form-select" name="catalogo_estado_id">
                                <option value="">Seleccione</option>
                        </select>
                    </div>

                    <div class="mb-5">
                        <button type="button" class="btn btn-success" id="btnRegistrarEmp">Registrar</button>
                        <button type="button" class="btn btn-warning" id="btnCancelEmpleado">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col">

    </div>
</div>
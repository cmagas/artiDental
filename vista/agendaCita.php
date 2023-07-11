<link href="css/tablas.css" rel="stylesheet">
<link href="css/modales.css" rel="stylesheet">

<script type="text/javascript" src="js/eventosCitas.js"></script>


<div class="content-header"></div>
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h3 class="mt-4">CONTROL DE AGENDA DE CITAS</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                <li class="breadcrumb-item active">Control de Citas</li>
            </ol>
        </div>
    </div><!-- /.row -->
</div><!-- /.container-fluid -->


<!-- Main content -->
<section class="content">
    <div class="container-fluid">

        <!--DATOS-->
        <div class="row">
            <div class="col-lg-12">
                <table id="tbl_registroAgenda" class="table table-striped w-100 shadow">
                    <thead>
                        <tr>
                            <th></th>
                            <th>id</th>
                            <th>Paciente</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Estatus</th>
                            <th class="text-center">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--/. container-fluid -->
</section>
<!-- /.content -->

<!--MODAL NUEVO REGISTRO-->
<div class="modal" id="modal_registro_cita" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray py-1">
                <h5 class="modal-title">Agendar Cita</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 div_etiqueta">
                    <label for="iptCodigoVenta">
                        <span class="small">Nombre del Paciente</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control form-control-sm" id="iptCodigoVenta"
                        placeholder="Buscar Nombre del Paciente">
                </div>

                <div class="col-lg-12 div_etiqueta">
                    <input type="text" class="form-control form-control-sm text-center" id="txt_nombrePaciente"
                        disabled>
                </div>

                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_fechaCita">
                        <span class="small">Fecha de la Cita</span><span class="text-danger"> *</span>
                    </label>
                    <input type="date" class="form-control" id="txt_fechaCita" onchange="obtenerHorarioDisponible(this.value,'txt_horario')">
                </div>

                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_HoraCita">
                        <span class="small">Hora de la Cita</span><span class="text-danger"> *</span>
                    </label>
                    <select id="txt_horario" name="txt_horario" style="width: 100%;" class="form-control">
                        <option value="-1">Seleccione el Horario</option>
                    </select>
                    
                </div>
                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_comentario">
                        <span class="small">Comentarios adicionales</span>
                    </label>
                    <textarea class="form-control " rows="2" id="txt_comentario" maxlength="150"
                        placeholder="Maximo 150 caracteres"></textarea>
                </div>

                <div class="col-lg-12">
                    <input type="text" id="txtIdPaciente" class="form-control form-control-sm" hidden>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="registrar_cita()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="btnCancelarRegistro">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!--MODAL MODIFICAR REGISTRO-->
<div class="modal" id="modal_modificar_cita" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray py-1">
                <h5 class="modal-title">Modificar Cita</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="col-lg-12 div_etiqueta">
                    <input type="text" class="form-control form-control-sm text-center"
                        id="txt_nombrePaciente_modificar" disabled>
                </div>

                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_fechaCita_modificar">
                        <span class="small">Fecha de la Cita</span><span class="text-danger"> *</span>
                    </label>
                    <input type="date" class="form-control" id="txt_fechaCita_modificar" onchange="obtenerHorarioDisponible(this.value,'txt_horaCita_modificar')">
                </div>

                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_HoraCita_modificar">
                        <span class="small">Hora de la Cita</span><span class="text-danger"> *</span>
                    </label>
                    <select id="txt_horaCita_modificar" style="width: 100%;" class="form-control"></select>
                </div>
                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_comentario_modificar">
                        <span class="small">Comentarios adicionales</span>
                    </label>
                    <textarea class="form-control " rows="2" id="txt_comentario_modificar" maxlength="150"
                        placeholder="Maximo 150 caracteres"></textarea>
                </div>
                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_Situacion">
                        <span class="small">Estatus</span><span class="text-danger"> *</span>
                    </label>
                    <select id="txt_Situacion" style="width: 100%;">
                        <option value="-1">Seleccione Estatus</option>
                        <option value="1">Activo</option>
                        <option value="0">Cancelada</option>
                    </select>
                </div>
                <div class="col-lg-12">
                    <input type="text" id="txtIdRegistro" hidden>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="modificar_Cita()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="btnCancelarRegistro">Cancelar</button>
            </div>
        </div>
    </div>
</div>



<script>
$(document).ready(function() {
    listarEventoCita();
    listadoPaciente();

});
</script>
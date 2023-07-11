<?php
include_once("conexionBD.php");


?>
<link rel="stylesheet" type="text/css" href="css/dashboard.css">
<link href="css/tablas.css" rel="stylesheet">
<link href="css/modales.css" rel="stylesheet">

<script type="text/javascript" src="../Scripts/funcionesUtiles.js.php"></script>
<script type="text/javascript" src="../Scripts/base64.js"></script>
<script type="text/javascript" src="../Scripts/funcionesAjax.js.jgz"></script>

<script type="text/javascript" src="js/dashboard.js"></script>



<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="mt-4">TABLERO PRINCIPAL</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Tablero Principal</li>
                </ol>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Información Box -->
        <div class="row">
            <!--Card Total Citas Mes-->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-medkit"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Citas del Mes</span>
                        <span class="info-box-number text-center" id="totalCitaMes">
                            0
                        </span>
                    </div>
                </div>
            </div>

            <!-- Card Total Citas del Dia -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-stethoscope"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Citas del Día</span>
                        <span class="info-box-number text-center" id="totalCitaDia">0</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>

            <!--Total Ingresos Mes-->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-cart-plus"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total ingreso mes</span>
                        <span class="info-box-number text-center" id="ventasMes">$ 0.00</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <!-- Total Ingresos Dia -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-credit-card"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Ingreso Día</span>
                        <span class="info-box-number text-center" id="ventaDia">$ 0.00</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

        </div>

        <!-- row Calendario -->
        <div class="row">
            <div class="col-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h1 class="card-title" id="title-header">AGENDA PROGRAMADA</h1>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div> <!-- ./ end card-tools -->
                    </div> <!-- ./ end card-header -->
                    <div class="card-body">
                        <div class="container-fluid">
                            <div class="col-lg-12">
                                <button onclick="retrocederSemana()" class="btnBoton">Semana Anterior</button>
                                <button onclick="avanzarSemana()" class="btnBoton">Semana Siguiente</button>
                            </div>

                            <div class="col-lg-12">
                                <div id="agenda-citas"></div>
                            </div>

                        </div>

                    </div> <!-- ./ end card-body -->
                </div>
            </div>
        </div><!-- ./row Grafico de barras -->

        <!--CARD TABLA CITAS-->
        <div class="row">
            <div class="col-lg-6">
                <div class="card card-info">
                    <div class="card-header">
                        <h2 class="card-title">CITAS PENDIENTES DEL MES</h2>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div> <!-- ./ end card-tools -->
                    </div> <!-- ./ end card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="tbl_pacientes_mes_pendientes">
                                <thead>
                                    <tr class="text-danger">
                                        <th>Paciente</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div> <!-- ./ end card-body -->
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card card-info">
                    <div class="card-header">
                        <h2 class="card-title">ULTIMOS PACIENTES</h2>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div> <!-- ./ end card-tools -->
                    </div> <!-- ./ end card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="tbl_pacientes_atendidos">
                                <thead>
                                    <tr class="text-danger">
                                        <th>Paciente</th>
                                        <th>Fecha</th>
                                        <th>Telefono</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div> <!-- ./ end card-body -->
                </div>
            </div>
        </div>

    </div>
    <!--/. container-fluid -->
</section>
<!-- /.content -->

<!--MODAL NUEVO REGISTRO-->
<div class="modal" id="modal_registro_nuevo" tabindex="-1" role="dialog">
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
                    <input type="date" class="form-control" id="txt_fechaCitada" name="txt_fechaCitada" disabled>
                </div>

                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_HoraCitadaDash">
                        <span class="small">Hora de la Cita</span><span class="text-danger"> *</span>
                    </label>
                    <select id="txt_HoraCitadaDash" style="width: 100%;" class="form-control" disabled></select>
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
                <button class="btn btn-primary" onclick="registrar_cita_paciente()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="btnCancelarRegistro">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="../utilitario/fullCalendar/js/moment.min.js"></script>
<script type="text/javascript" src="../utilitario/fullCalendar/js/fullcalendar.min.js"></script>
<script type="text/javascript" src="../utilitario/fullCalendar/js/locale/es.js"></script>

<script>
$(document).ready(function() {
    cargarAgenda();
    obtenerDatos();
    obtenerCitasPendientes();
    obtenerCitasAtendidas()

});
</script>
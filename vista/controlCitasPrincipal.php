<?php
    include("conexionBD.php");
    $fecha=date("Y-m-d");

?>

<link href="css/tablas.css" rel="stylesheet">
<link href="css/modales.css" rel="stylesheet">
<link href="css/editor.css" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="../utilitario/bootstrap-wysihtml5-master/lib/css/prettify.css">
</link>
<link rel="stylesheet" type="text/css" href="../utilitario/bootstrap-wysihtml5-master/src/bootstrap-wysihtml5.css">
</link>



<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="mt-4">ADMINISTRACION DE CITAS</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Administración de Citas</li>
                </ol>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">

        <!--DATOS-->
        <div class="row">
            <div class="col-lg-12">
                <table id="tbl_cita_medicas" class="table table-striped w-100 shadow">
                    <thead>
                        <tr>
                            <th></th>
                            <th>id</th>
                            <th>Paciente</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Estatus Cita</th>
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

<!--MODAL EXPEDIENTE REGISTRO-->
<div class="modal" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gray py-1">
                <h4 class="modal-title" id="myModalLabel">REGISTRO CLINICO</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body">
                <div role="tabpanel">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">

                        <li role="presentation" class="active"><a href="#consulta" aria-controls="consulta" role="tab"
                                data-toggle="tab">Informe Consulta</a>
                        </li>
                        <li role="presentation"><a href="#imagenes" aria-controls="timeLine" role="tab"
                                data-toggle="tab">Imagenes</a>
                        </li>

                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">

                        <div role="tabpanel" class="tab-pane" id="consulta">
                            <div class="container contenido">
                                <h3 class="text-center">INFORME DE LA CONSULTA </h3>

                                <div class="col-lg-12 div_etiqueta">
                                    <label for="cmb_TipoConsulta">
                                        <span class="small">Seleccione el Tipo de Consulta</span><span
                                            class="text-danger"> *</span>
                                    </label>
                                    <select class="js-example-basic-single form-control" id="cmb_TipoConsulta"
                                        name="cmb_TipoConsulta" style="width: 100%;">
                                        <option value="-1">Tipo de Consulta</option>
                                        <?php
                                            $Consulta="SELECT idTipo,nombre_tipo FROM 4005_catTipoConsulta WHERE situacion='1'";
                                            $con->generarOpcionesSelect($Consulta);
                                        ?>
                                    </select>
                                </div>
                                </br>

                                <div class="hero-unit" style="margin-top:80px">
                                    <textarea class="textarea" placeholder="Enter text ..."
                                        style="width: 780px; height: 400px" id="t_consulta"
                                        name="t_consulta"></textarea>
                                </div>

                            </div>
                            <div class="col-lg-12 div_etiqueta">
                                <input type="text" id="txtidPaciente" hidden>
                            </div>
                            <div class="col-lg-12 div_etiqueta">
                                <input type="text" id="txtIdCita" hidden>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="imagenes">
                            <div class="container contenido">
                                <div class="row">
                                    <div class="col-12">
                                        <h3>TRANSFERIR ARCHIVO</h3>
                                        <div class="form-group">
                                            <input multiple type="file" class="form-control" id="inputArchivos">
                                            <br><br>
                                            <button id="btnEnviar" class="btn btn-success">Subir</button>
                                        </div>
                                        <div class="alert alert-info" id="estado"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="registrar_Consulta()">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>


        <script type="text/javascript" src="../utilitario/bootstrap-wysihtml5-master/lib/js/wysihtml5-0.3.0.js">
        </script>
        <script type="text/javascript" src="../utilitario/bootstrap-wysihtml5-master/lib/js/prettify.js"></script>
        <script type="text/javascript" src="../utilitario/bootstrap-wysihtml5-master/src/bootstrap-wysihtml5.js">
        </script>

        <script type="text/javascript" src="js/controlCitas.js"></script>

        <script>
        $('.textarea').wysihtml5({
            "stylesheets": ["css/editor.css"],
            "image": true,
        });
        </script>
        <script>
        $(document).ready(function() {
            listarCitaMedicas();


        });
        </script>
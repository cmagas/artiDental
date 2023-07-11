<?php
    include("conexionBD.php");
    $fecha=date("Y-m-d");

?>

<link href="css/tablas.css" rel="stylesheet">
<link href="css/modales.css" rel="stylesheet">

<script type="text/javascript" src="js/servicios.js"></script>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="mt-4">CATALOGO DE SERVICIOS</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Catálogo de Servicios</li>
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
                <table id="tbl_servicios" class="table table-striped w-100 shadow">
                    <thead>
                        <tr>
                            <th></th>
                            <th>id</th>
                            <th>Servicio</th>
                            <th>Impuesto</th>
                            <th>Costo</th>
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
<div class="modal" id="modal_registro_servicio" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray py-1">
                <h5 class="modal-title">Agregar Servicio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 div_etiqueta">
                    <span class="small">Nombre del Servicio</span><span class="text-danger"> *</span>
                    <input type="text" class="form-control" id="txt_nomServicio" placeholder="Nombre del Servicio">
                </div>
                <div class="col-lg-6 div_etiqueta">
                    <span class="small">Impuesto</span><span class="text-danger"> *</span>
                    <select class="js-example-basic-single form-control" id="cmb_impuesto" name="cmb_impuesto"
                        style="width: 100%;">
                        <option value="-1">Seleccione el Impuesto</option>
                        <?php
                                $Consulta="SELECT idImpuesto,CONCAT(nombreImpuesto,' [',valor,'%]') AS nombre FROM 4002_impuesto ORDER BY nombreImpuesto";
                                $con->generarOpcionesSelect($Consulta);
                            ?>
                    </select>
                </div>
                <div class="col-lg-6 div_etiqueta">
                    <span class="small">Precio del Servicio</span><span class="text-danger"> *</span>
                    <input type="number" class="form-control" id="txt_precio">
                </div>

                <div class="col-lg-12 div_etiqueta">
                    <span class="small">Descripción</span>
                    <textarea class="form-control " rows="2" id="txt_descripcion" maxlength="150"
                        placeholder="Maximo 150 caracteres"></textarea>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="registrar_servicio()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="btnCancelarRegistro">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!--MODAL NUEVO REGISTRO-->
<div class="modal" id="modal_modificacion_servicio" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray py-1">
                <h5 class="modal-title">Modificar Servicio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 div_etiqueta">
                    <span class="small">Nombre del Servicio</span><span class="text-danger"> *</span>
                    <input type="text" class="form-control" id="txt_nomServicio_modificar"
                        placeholder="Nombre del Servicio">
                </div>
                <div class="col-lg-6 div_etiqueta">
                    <span class="small">Impuesto</span><span class="text-danger"> *</span>
                    <select class="js-example-basic-single form-control" id="cmb_impuesto_modificar"
                        name="cmb_impuesto_modificar" style="width: 100%;">
                        <option value="-1">Seleccione el Impuesto</option>
                        <?php
                                $Consulta="SELECT idImpuesto,CONCAT(nombreImpuesto,' [',valor,'%]') AS nombre FROM 4002_impuesto ORDER BY nombreImpuesto";
                                $con->generarOpcionesSelect($Consulta);
                            ?>
                    </select>
                </div>
                <div class="col-lg-6 div_etiqueta">
                    <span class="small">Precio del Servicio</span><span class="text-danger"> *</span>
                    <input type="number" class="form-control" id="txt_precio_modificar">
                </div>

                <div class="col-lg-12 div_etiqueta">
                    <span class="small">Descripción</span>
                    <textarea class="form-control " rows="2" id="txt_descripcion_modificar" maxlength="150"
                        placeholder="Maximo 150 caracteres"></textarea>
                </div>
                <div class="col-lg-12 div_etiqueta">
                    <span class="small">Estatus</span><span class="text-danger"> *</span>
                    <select id="txt_Situacion" style="width: 100%;">
                        <option value="-1">Seleccione Estatus</option>
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>
                <div class="col-lg-12">
                    <input type="text" id="txtServicio" hidden>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="modificar_servicio()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="btnCancelarRegistro">Cancelar</button>
            </div>

        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    listarServicios();
});
</script>
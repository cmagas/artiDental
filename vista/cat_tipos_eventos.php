<?php
    include("conexionBD.php");
?>

<link href="css/tablas.css" rel="stylesheet">
<link href="css/modales.css" rel="stylesheet">

<script type="text/javascript" src="js/catTiposEventos.js"></script>


<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="mt-4">CATALOGO DE TIPOS DE EVENTOS</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Catálogo Eventos</li>
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
                <table id="tbl_tipo_eventos" class="table table-striped w-100 shadow">
                    <thead>
                        <tr>
                            <th></th>
                            <th>id</th>
                            <th>Tipo de Evento</th>
                            <th>Color</th>
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
<div class="modal" id="modal_registro" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray py-1">
                <h5 class="modal-title">Agregar Tipo de Evento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_nombre">
                        <span class="small">Nombre del Tipo</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_nombre" placeholder="Nombre del Almacen">
                </div>
                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_descripcion">
                        <span class="small">Descripción</span>
                    </label>
                    <textarea class="form-control " rows="2" id="txt_descripcion" maxlength="150"
                        placeholder="Maximo 150 caracteres"></textarea>
                </div>
                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_color">
                        <span class="small">Tablero de color</span><span class="text-danger"> *</span>
                    </label>
                    <input type="color" class="form-control" id="txt_color">
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="registrar_tipoEvento()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="btnCancelarRegistro">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!--MODAL MODIFICAR REGISTRO-->
<div class="modal" id="modal_registro_modificar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray py-1">
                <h5 class="modal-title">Modificar Tipo de Evento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_nombre_modificar">
                        <span class="small">Nombre del Tipo</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_nombre_modificar" placeholder="Nombre del Almacen">
                </div>
                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_descripcion_modificar">
                        <span class="small">Descripción</span>
                    </label>
                    <textarea class="form-control " rows="2" id="txt_descripcion_modificar" maxlength="150"
                        placeholder="Maximo 150 caracteres"></textarea>
                </div>
                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_color_modificar">
                        <span class="small">Tablero de color</span><span class="text-danger"> *</span>
                    </label>
                    <input type="color" class="form-control" id="txt_color_modificar">
                </div>
                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_Situacion">
                        <span class="small">Estatus</span><span class="text-danger"> *</span>
                    </label>
                    <select id="txt_Situacion" style="width: 100%;">
                        <option value="-1">Seleccione Estatus</option>
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>
                <div class="col-lg-12">
                    <input type="text" id="txtIdRegistro" hidden>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="modificar_tipoEvento()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="btnCancelarRegistro">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    listarTipoEventos();
});

$('#btnCancelarRegistro, #btnCerrarModal').on('click', function() {
    //limpiarCamposModalRegistro();
})
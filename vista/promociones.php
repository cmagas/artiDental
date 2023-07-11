<?php
    include("conexionBD.php");

?>

<link href="css/tablas.css" rel="stylesheet">
<link href="css/modales.css" rel="stylesheet">

<script type="text/javascript" src="js/promociones.js"></script>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="mt-4">MODULOS DE PROMOCIONES</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Promociones</li>
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
                <table id="tbl_promociones" class="table table-striped w-100 shadow">
                    <thead>
                        <tr>
                            <th></th>
                            <th>id</th>
                            <th>Titulo de la Promoción</th>
                            <th>Fecha public.</th>
                            <th>Fecha Fin</th>
                            <th>Situación</th>
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
<div class="modal" id="modal_registro_promocion" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray py-1">
                <h5 class="modal-title">Agregar Promoción</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="form_subir" enctype="multipart/form-data">
                    <div class="row">
                        <!--Columna foto-->
                        <div class="col-12 div_etiqueta">
                            <div class="form-group mb-2 mx-0">
                                <label for="iptImagen">
                                    <i class="fas fa-image fs-6"></i>
                                    <span class="small">Seleccione la Imagen de la Promocion (.jpg, .png, .gif,
                                        .jpeg)</span><span class="text-danger"> *</span>
                                </label>
                                <input type="file" class="form-control form-control-sm" id="iptImagen" name="iptImagen"
                                    accept="image/*" onchange="previewFile(this)">
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div style="width: 100%; height: 230px">
                                <img id="previewImg" src="fotos/no_imagen.png" class="border border-secondary"
                                    style="object-fit: cover; width: 100%; height: 100%;" alt="">
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-12 div_etiqueta mt-0">
                                    <label for="txt_titulo">
                                        <span class="small">Titulo de la Promoción</span><span class="text-danger">
                                            *</span>
                                    </label>
                                    <input type="text" class="form-control" id="txt_titulo" placeholder="Titulo"
                                        name="txt_titulo">
                                </div>
                                <div class="col-lg-12 div_etiqueta">
                                    <label for="txt_descripcion">
                                        <span class="small">Descripción</span>
                                    </label>
                                    <textarea class="form-control " rows="2" id="txt_descripcion" maxlength="150"
                                        placeholder="Maximo 150 caracteres" name="txt_descripcion"></textarea>
                                </div>
                                <div class="col-lg-6 div_etiqueta">
                                    <label for="txt_fecha_inicio">
                                        <span class="small">Fecha Publicación</span><span class="text-danger"> *</span>
                                    </label>
                                    <input type="date" class="form-control" id="txt_fecha_inicio"
                                        name="txt_fecha_inicio">
                                </div>
                                <div class="col-lg-6 div_etiqueta mb-4">
                                    <label for="txt_fecha_fin">
                                        <span class="small">Fecha Finalización</span><span class="text-danger"> *</span>
                                    </label>
                                    <input type="date" class="form-control" id="txt_fecha_fin" name="txt_fecha_fin">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="registrar_promocion()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="btnCancelarRegistro">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!--MODAL MODIFICAR REGISTRO-->
<div class="modal" id="modal_modificar_promocion" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray py-1">
                <h5 class="modal-title">Modificar Promoción</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 div_etiqueta mt-0">
                    <label for="txt_titulo_modificar">
                        <span class="small">Titulo de la Promoción</span><span class="text-danger">
                            *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_titulo_modificar" placeholder="Titulo"
                        name="txt_titulo_modificar">
                </div>
                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_descripcion_modificar">
                        <span class="small">Descripción</span>
                    </label>
                    <textarea class="form-control " rows="2" id="txt_descripcion_modificar" maxlength="150"
                        placeholder="Maximo 150 caracteres" name="txt_descripcion_modificar"></textarea>
                </div>
                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_fecha_inicio_modificar">
                        <span class="small">Fecha Publicación</span><span class="text-danger"> *</span>
                    </label>
                    <input type="date" class="form-control" id="txt_fecha_inicio_modificar"
                        name="txt_fecha_inicio_modificar">
                </div>
                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_fecha_fin_modificar">
                        <span class="small">Fecha Finalización</span><span class="text-danger"> *</span>
                    </label>
                    <input type="date" class="form-control" id="txt_fecha_fin_modificar" name="txt_fecha_fin_modificar">
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
                    <input type="text" id="txtIdPromocion" hidden>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="modificar_promocion()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="btnCancelarRegistro">Cancelar</button>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {

    listar_promociones();

});
</script>
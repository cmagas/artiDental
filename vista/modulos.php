<?php
    include("latis/conexionBD.php");

?>

<link href="css/tablas.css" rel="stylesheet">
<link href="css/modales.css" rel="stylesheet">

<script type="text/javascript" src="js/modulos.js"></script>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="mt-4">CATALOGO DE MODULOS DE SISTEMA</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right mt-4">
                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Modulos</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">

        <!--DATOS-->
        <div class="row">
            <div class="col-lg-12">
                <table id="tbl_modulos" class="table table-striped w-100 shadow">
                    <thead>
                        <tr>
                            <th></th>
                            <th>id</th>
                            <th>Modulo</th>
                            <th>Modulo Padre</th>
                            <th>Vista</th>
                            <th>icon_menu</th>
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
<div class="modal" id="modal_registro_modulos" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray py-1">
                <h5 class="modal-title">Agregar Módulo del Sistema</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_nombre">
                        <span class="small">Nombre del Módulo</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_nombre" placeholder="Nombre">
                </div>
                <div class="col-lg-6 div_etiqueta">
                    <label for="cmb_moduloPadre">
                        <span class="small">Módulo Padre</span>
                    </label>
                    <select class="js-example-basic-single" id="cmb_moduloPadre" style="width: 100%;">
                        <option value="-1">Seleccione el Padre</option>
                        <?php
                                $Consulta="SELECT idModulo,nombreModulo FROM 1006_modulos WHERE idPadre='-1' ORDER BY nombreModulo";
                                $con->generarOpcionesSelect($Consulta);
                            ?>
                    </select>
                </div>
                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_icono">
                        <span class="small">Nombre del Icono a mostrar</span>
                    </label>
                    <input type="text" class="form-control" id="txt_icono" placeholder="nombre Icono">
                </div>
                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_formulario">
                        <span class="small">Formulario Vista</span>
                    </label>
                    <input type="text" class="form-control" id="txt_formulario"
                        placeholder="Nombre del Formulario a mostrar">
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" onclick="registrar_modulo()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="btnCancelarRegistro">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!--MODAL MODIFICAR REGISTRO-->
<div class="modal" id="modal_modificar_modulos" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray py-1">
                <h5 class="modal-title">Modificar Módulo del Sistema</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_nombre_modifi">
                        <span class="small">Nombre del Módulo</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_nombre_modifi" placeholder="Nombre">
                </div>
                <div class="col-lg-6 div_etiqueta">
                    <label for="cmb_moduloPadre_modifi">
                        <span class="small">Módulo Padre</span>
                    </label>
                    <select class="js-example-basic-single" id="cmb_moduloPadre_modifi" style="width: 100%;">
                        <option value="-1">Seleccione el Padre</option>
                        <?php
                                $Consulta="SELECT idModulo,nombreModulo FROM 1006_modulos WHERE idPadre='-1' ORDER BY nombreModulo";
                                $con->generarOpcionesSelect($Consulta);
                            ?>
                    </select>
                </div>
                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_icono_modifi">
                        <span class="small">Nombre del Icono a mostrar</span>
                    </label>
                    <input type="text" class="form-control" id="txt_icono_modifi" placeholder="nombre Icono">
                </div>
                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_formulario_modifi">
                        <span class="small">Formulario Vista</span>
                    </label>
                    <input type="text" class="form-control" id="txt_formulario_modifi"
                        placeholder="Nombre del Formulario a mostrar">
                </div>
                <div class="col-lg-6 div_etiqueta">
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
                    <input type="text" id="txtIdModulo" hidden>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" onclick="modificar_modulo()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="btnCancelarRegistro">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    listarModulos();
});

$('#btnCancelarRegistro, #btnCerrarModal').on('click', function() {
    limpiarCamposModalRegistro();
})
</script>
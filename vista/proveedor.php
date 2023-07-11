<?php
    include("latis/conexionBD.php");

?>

<link href="css/tablas.css" rel="stylesheet">
<link href="css/modales.css" rel="stylesheet">

<script type="text/javascript" src="js/proveedores.js"></script>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="mt-4">CATALOGO DE PROVEEDORES</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right mt-4">
                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Proveedores</li>
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
                <table id="tbl_proveedor" class="table table-striped w-100 shadow">
                    <thead>
                        <tr>
                            <th></th>
                            <th>id</th>
                            <th>Nombre</th>
                            <th>Localidad</th>
                            <th>Estado</th>
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
<div class="modal" id="modal_registro_Proveedor" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray py-1">
                <h5 class="modal-title">Agregar Proveedor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-4 div_etiqueta">
                    <label for="cmb_tipo">
                        <span class="small">Tipo de Proveedor</span><span class="text-danger"> *</span>
                    </label>
                    <select class="js-example-basic-single" id="cmb_tipo" style="width: 100%;"
                        onchange="tipoProveedor(this.value)">
                        <option value="-1">Seleccione el tipo</option>
                        <option value="1">Persona Física</option>
                        <option value="2">Persona Moral</option>
                    </select>
                </div>
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_rfc">
                        <span class="small">R.F.C.</span>
                    </label>
                    <input type="text" class="form-control" id="txt_rfc" maxlength="12" placeholder="RFC">
                </div>
                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_razonSocial">
                        <span class="small">Nombre o Razón Social</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_razonSocial" maxlength="150"
                        placeholder="Maximo 150 caract.">
                </div>
                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_apPaterno">
                        <span class="small">Apellido Paterno</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_apPaterno" maxlength="50"
                        placeholder="Maximo 50 caract." disabled>
                </div>
                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_apMaterno">
                        <span class="small">Apellido Materno</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_apMaterno" maxlength="50"
                        placeholder="Maximo 50 caract." disabled>
                </div>
                <div class="col-lg-12">
                    <hr>
                </div>
                <div class="col-lg-12 datos_divisor">
                    <h3>Dirección</h3>
                </div>
                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_direccion">
                        <span class="small">Dirección</span>
                    </label>
                    <textarea class="form-control " rows="2" id="txt_direccion"></textarea>
                </div>
                <div class="col-lg-6 div_etiqueta">
                    <label for="cmb_estado">
                        <span class="small">Estado</span>
                    </label>
                    <select class="js-example-basic-single" id="cmb_estado" style="width: 100%;"
                        onchange="obtenerMunicipiosPorEstado(this.value)">
                        <?php
                                $Consulta="SELECT cveEstado,estado FROM 820_estados ORDER BY estado";
                                $con->generarOpcionesSelect($Consulta);
                            ?>
                    </select>
                </div>
                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_municipio">
                        <span class="small">Municipio</span>
                    </label>
                    <select id="txt_municipio" style="width: 100%;">

                    </select>
                </div>
                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_Localidad">
                        <span class="small">Localidad</span>
                    </label>
                    <input type="text" class="form-control" id="txt_Localidad" maxlength="150"
                        placeholder="Maximo 150 caract.">
                </div>
                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_email">
                        <span class="small">Correo electrónico</span>
                    </label>
                    <input type="email" class="form-control" id="txt_email">
                </div>
                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_telefono">
                        <span class="small">Teléfono</span>
                    </label>
                    <input type="text" class="form-control" id="txt_telefono" maxlength="10">
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" onclick="registrar_proveedor()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="btnCancelarRegistro">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!--MODAL MODIFICAR REGISTRO-->
<div class="modal" id="modal_modificar_Proveedor" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray py-1">
                <h5 class="modal-title">Modificar Proveedor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-4 div_etiqueta">
                    <label for="cmb_tipo_modifi">
                        <span class="small">Tipo de Proveedor</span><span class="text-danger"> *</span>
                    </label>
                    <select class="js-example-basic-single" id="cmb_tipo_modifi" style="width: 100%;"
                        onchange="tipoProveedor(this.value)">
                        <option value="-1">Seleccione el tipo</option>
                        <option value="1">Persona Física</option>
                        <option value="2">Persona Moral</option>
                    </select>
                </div>
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_rfc_modifi">
                        <span class="small">R.F.C.</span>
                    </label>
                    <input type="text" class="form-control" id="txt_rfc_modifi" maxlength="12" placeholder="RFC">
                </div>
                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_razonSocial_modifi">
                        <span class="small">Nombre o Razón Social</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_razonSocial_modifi" maxlength="150"
                        placeholder="Maximo 150 caract.">
                </div>
                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_apPaterno_modifi">
                        <span class="small">Apellido Paterno</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_apPaterno_modifi" maxlength="50"
                        placeholder="Maximo 50 caract." disabled>
                </div>
                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_apMaterno_modifi">
                        <span class="small">Apellido Materno</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_apMaterno_modifi" maxlength="50"
                        placeholder="Maximo 50 caract." disabled>
                </div>
                <div class="col-lg-12">
                    <hr>
                </div>
                <div class="col-lg-12 datos_divisor">
                    <h3>Dirección</h3>
                </div>
                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_direccion_modifi">
                        <span class="small">Dirección</span>
                    </label>
                    <textarea class="form-control " rows="2" id="txt_direccion_modifi"></textarea>
                </div>
                <div class="col-lg-6 div_etiqueta">
                    <label for="cmb_estado_modifi">
                        <span class="small">Estado</span>
                    </label>
                    <select class="js-example-basic-single" id="cmb_estado_modifi" style="width: 100%;"
                        onchange="obtenerMunicipiosPorEstado2(this.value)">
                        <?php
                                $Consulta="SELECT cveEstado,estado FROM 820_estados ORDER BY estado";
                                $con->generarOpcionesSelect($Consulta);
                            ?>
                    </select>
                </div>
                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_municipio_modifi">
                        <span class="small">Municipio</span>
                    </label>
                    <select id="txt_municipio_modifi" style="width: 100%;">

                    </select>
                </div>
                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_Localidad_modifi">
                        <span class="small">Localidad</span>
                    </label>
                    <input type="text" class="form-control" id="txt_Localidad_modifi" maxlength="150"
                        placeholder="Maximo 150 caract.">
                </div>
                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_email_modifi">
                        <span class="small">Correo electrónico</span>
                    </label>
                    <input type="email" class="form-control" id="txt_email_modifi">
                </div>
                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_telefono_modifi">
                        <span class="small">Teléfono</span>
                    </label>
                    <input type="text" class="form-control" id="txt_telefono_modifi" maxlength="10">
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
                    <input type="text" id="txtIdProveedor" hidden>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" onclick="modificar_proveedor()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="btnCancelarRegistro">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    listarProveedores();
});

$('#btnCancelarRegistro, #btnCerrarModal').on('click', function() {
    limpiarCamposModalRegistro();
})
</script>
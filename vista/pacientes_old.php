<?php
    include("conexionBD.php");
    $fecha=date("Y-m-d");

?>

<link href="css/tablas.css" rel="stylesheet">
<link href="css/modales.css" rel="stylesheet">

<script type="text/javascript" src="js/pacientes.js"></script>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="mt-4">CONTROL DE PACIENTES</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Control Pacientes</li>
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
                <table id="tbl_pacientes" class="table table-striped w-100 shadow">
                    <thead>
                        <tr>
                            <th></th>
                            <th>id</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Foto</th>
                            <th>Fecha alta</th>
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
<div class="modal" id="modal_registro_paciente" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray py-1">
                <h5 class="modal-title">Registrar Pacientes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="form_subir" enctype="multipart/form-data">

                    <div class="row">
                        <!--Columna foto-->
                        <div class="col-12 div_etiqueta">
                            <div class="form-group mb-2">
                                <label for="iptImagen">
                                    <i class="fas fa-image fs-6"></i>
                                    <span class="small">Seleccione la Foto (.jpg, .png, .gif,
                                        .jpeg)</span>
                                </label>
                                <input type="file" class="form-control form-control-sm" id="iptImagen" name="iptImagen"
                                    accept="image/*" onchange="previewFile(this)">
                            </div>
                        </div>

                        <div class="col-12 col-lg-4 my-1">
                            <div style="width: 100%; height: 200px">
                                <img id="previewImg" src="fotos/no_imagen.png" class="border border-secondary"
                                    style="object-fit: cover; width: 100%; height: 100%;" alt="">
                            </div>
                        </div>

                        <div class="col-lg-8">
                            <div class="row">
                                <!--Columna Nombre-->
                                <div class="col-lg-4 div_etiqueta">
                                    <label for="txt_nombre">
                                        <span class="small">Nombre</span><span class="text-danger"> *</span>
                                    </label>
                                    <input type="text" class="form-control" id="txt_nombre" name="txt_nombre"
                                        style="text-transform:uppercase;">
                                </div>
                                <!--Columna Apellido Paterno-->
                                <div class="col-lg-4 div_etiqueta">
                                    <label for="txt_apPaterno">
                                        <span class="small">Apellido paterno</span><span class="text-danger"> *</span>
                                    </label>
                                    <input type="text" class="form-control" id="txt_apPaterno" name="txt_apPaterno"
                                        style="text-transform:uppercase;">
                                </div>
                                <!--Columna Apellido Materno-->
                                <div class="col-lg-4 div_etiqueta">
                                    <label for="txt_apMaterno">
                                        <span class="small">Apellido materno</span><span class="text-danger"> *</span>
                                    </label>
                                    <input type="text" class="form-control" id="txt_apMaterno" name="txt_apMaterno"
                                        style="text-transform:uppercase;">
                                </div>
                                <!--Columna RFC-->
                                <div class="col-lg-4 div_etiqueta">
                                    <label for="txt_rfc">
                                        <span class="small">R.F.C.</span>
                                    </label>
                                    <input type="text" class="form-control" id="txt_rfc" name="txt_rfc" maxlength="13"
                                        style="text-transform:uppercase;">
                                </div>
                                <!--Columna Genero-->
                                <div class="col-lg-4 div_etiqueta">
                                    <label for="txt_genero">
                                        <span class="small">Genero</span>
                                    </label>
                                    <select id="txt_genero" name="txt_genero" style="width: 100%;" class="form-control">
                                        <option value="-1">Seleccione</option>
                                        <option value="1">Femenino</option>
                                        <option value="2">Masculino</option>
                                    </select>
                                </div>
                                <!--Columna Telefono-->
                                <div class="col-lg-4 div_etiqueta">
                                    <label for="txt_telefono">
                                        <span class="small">Teléfono</span><span class="text-danger"> *</span>
                                    </label>
                                    <input type="tel" class="form-control" id="txt_telefono" name="txt_telefono">
                                </div>
                                <!--Columna Email-->
                                <div class="col-lg-6 div_etiqueta">
                                    <label for="txt_email">
                                        <span class="small">Correo Electrónico</span><span class="text-danger"> *</span>
                                    </label>
                                    <input type="email" class="form-control" id="txt_email" name="txt_email"
                                        maxlength="150" style="text-transform:uppercase;">
                                </div>
                                <!--Columna Fecha Nac-->
                                <div class="col-lg-6 div_etiqueta">
                                    <label for="txt_fechaNac">
                                        <span class="small">Fecha de Nacimiento</span>
                                    </label>
                                    <input type="date" class="form-control" id="txt_fechaNac" name="txt_fechaNac"
                                        max="<?php echo $fecha; ?>">
                                </div>
                            </div>
                        </div>

                        <!--Columna linea-->
                        <div class="col-lg-12">
                            <hr>
                        </div>

                        <!--Columna Cabecera Direccion-->
                        <div class="col-lg-12 datos_divisor">
                            <h3>Dirección</h3>
                        </div>

                        <!--Columna Estado-->
                        <div class="col-lg-6 div_etiqueta">
                            <label for="cmb_estado">
                                <span class="small">Estado</span>
                            </label>
                            <select class="js-example-basic-single form-control" id="cmb_estado" name="cmb_estado"
                                style="width: 100%;" onchange="obtenerMunicipiosPorEstado(this.value)">
                                <option value="-1">Seleccione el Estado</option>
                                <?php
                                $Consulta="SELECT cveEstado,estado FROM 820_estados ORDER BY estado";
                                $con->generarOpcionesSelect($Consulta);
                            ?>
                            </select>
                        </div>

                        <!--Columna Municipio-->
                        <div class="col-lg-6 div_etiqueta">
                            <label for="txt_municipio">
                                <span class="small">Municipio</span>
                            </label>
                            <select id="txt_municipio" name="txt_municipio" style="width: 100%;" class="form-control">
                                <option value="-1">Seleccione el Municipio</option>
                            </select>
                        </div>

                        <!--Columna Calle-->
                        <div class="col-lg-10 div_etiqueta">
                            <label for="txt_calle">
                                <span class="small">Calle</span>
                            </label>
                            <input type="text" class="form-control" id="txt_calle" name="txt_calle" maxlength="50"
                                placeholder="Maximo 50 caract." style="text-transform:uppercase;">
                        </div>

                        <!--Columna Numero-->
                        <div class="col-lg-2 div_etiqueta">
                            <label for="txt_numero">
                                <span class="small">Número</span>
                            </label>
                            <input type="text" class="form-control" id="txt_numero" name="txt_numero" maxlength="10"
                                style="text-transform:uppercase;">
                        </div>

                        <!--Columna Colonia-->
                        <div class="col-lg-10 div_etiqueta">
                            <label for="txt_colonia">
                                <span class="small">Colonia</span>
                            </label>
                            <input type="text" class="form-control" id="txt_colonia" name="txt_colonia" maxlength="100"
                                placeholder="Colonia" style="text-transform:uppercase;">
                        </div>

                        <!--Columna Codigo Postal-->
                        <div class="col-lg-2 div_etiqueta">
                            <label for="txt_codPostal">
                                <span class="small">Cod. Postal</span>
                            </label>
                            <input type="text" class="form-control" id="txt_codPostal" name="txt_codPostal"
                                maxlength="10">
                        </div>

                        <!--Columna Localidad-->
                        <div class="col-lg-12 div_etiqueta">
                            <label for="txt_Localidad">
                                <span class="small">Localidad</span>
                            </label>
                            <input type="text" class="form-control" id="txt_Localidad" name="txt_Localidad"
                                maxlength="200" placeholder="Maximo 200 caract." style="text-transform:uppercase;">
                        </div>

                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" onclick="registrar_paciente()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="btnCancelarRegistro">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!--MODAL MODIFICAR PACIENTES-->
<div class="modal" id="modal_modificar_paciente" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray py-1">
                <h5 class="modal-title">Modificar Pacientes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <!--Columna Nombre-->
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_nombre_modificar">
                        <span class="small">Nombre</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_nombre_modificar" name="txt_nombre_modificar"
                        style="text-transform:uppercase;">
                </div>
                <!--Columna Apellido Paterno-->
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_apPaterno_modificar">
                        <span class="small">Apellido paterno</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_apPaterno_modificar" name="txt_apPaterno_modificar"
                        style="text-transform:uppercase;">
                </div>
                <!--Columna Apellido Materno-->
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_apMaterno_modificar">
                        <span class="small">Apellido materno</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_apMaterno_modificar" name="txt_apMaterno_modificar"
                        style="text-transform:uppercase;">
                </div>
                <!--Columna RFC-->
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_rfc_modificar">
                        <span class="small">R.F.C.</span>
                    </label>
                    <input type="text" class="form-control" id="txt_rfc_modificar" name="txt_rfc_modificar" maxlength="13"
                        style="text-transform:uppercase;">
                </div>
                <!--Columna Genero-->
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_genero_modificar">
                        <span class="small">Genero</span>
                    </label>
                    <select id="txt_genero_modificar" name="txt_genero_modificar" style="width: 100%;" class="form-control">
                        <option value="-1">Seleccione</option>
                        <option value="1">Femenino</option>
                        <option value="2">Masculino</option>
                    </select>
                </div>
                <!--Columna Telefono-->
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_telefono_modificar">
                        <span class="small">Teléfono</span><span class="text-danger"> *</span>
                    </label>
                    <input type="tel" class="form-control" id="txt_telefono_modificar" name="txt_telefono_modificar">
                </div>
                <!--Columna Email-->
                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_email_modificar">
                        <span class="small">Correo Electrónico</span><span class="text-danger"> *</span>
                    </label>
                    <input type="email" class="form-control" id="txt_email_modificar" name="txt_email_modificar" maxlength="150"
                        style="text-transform:uppercase;">
                </div>
                <!--Columna Fecha Nac-->
                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_fechaNac_modificar">
                        <span class="small">Fecha de Nacimiento</span>
                    </label>
                    <input type="date" class="form-control" id="txt_fechaNac_modificar" name="txt_fechaNac_modificar"
                        max="<?php echo $fecha; ?>">
                </div>

                <!--Columna linea-->
                <div class="col-lg-12">
                    <hr>
                </div>

                <!--Columna Cabecera Direccion-->
                <div class="col-lg-12 ">
                    <h3>Dirección</h3>
                </div>

                <!--Columna Estado-->
                <div class="col-lg-6 div_etiqueta">
                    <label for="cmb_estado_modificar">
                        <span class="small">Estado</span>
                    </label>
                    <select class="js-example-basic-single form-control" id="cmb_estado_modificar"
                        style="width: 100%;" onchange="obtenerMunicipiosPorEstado2(this.value)">
                        <option value="-1">Seleccione el Estado</option>
                        <?php
                                $Consulta="SELECT cveEstado,estado FROM 820_estados ORDER BY estado";
                                $con->generarOpcionesSelect($Consulta);
                            ?>
                    </select>
                </div>

                <!--Columna Municipio-->
                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_municipio_modificar">
                        <span class="small">Municipio</span>
                    </label>
                    <select id="txt_municipio_modificar" style="width: 100%;" class="form-control">
                        <option value="-1">Seleccione el Municipio</option>
                    </select>
                </div>

                <!--Columna Calle-->
                <div class="col-lg-10 div_etiqueta">
                    <label for="txt_calle_modificar">
                        <span class="small">Calle</span>
                    </label>
                    <input type="text" class="form-control" id="txt_calle_modificar" name="txt_calle_modificar" maxlength="50"
                        placeholder="Maximo 50 caract." style="text-transform:uppercase;">
                </div>

                <!--Columna Numero-->
                <div class="col-lg-2 div_etiqueta">
                    <label for="txt_numero_modificar">
                        <span class="small">Número</span>
                    </label>
                    <input type="text" class="form-control" id="txt_numero_modificar" name="txt_numero_modificar" maxlength="10"
                        style="text-transform:uppercase;">
                </div>

                <!--Columna Colonia-->
                <div class="col-lg-10 div_etiqueta">
                    <label for="txt_colonia_modificar">
                        <span class="small">Colonia</span>
                    </label>
                    <input type="text" class="form-control" id="txt_colonia_modificar" name="txt_colonia_modificar" maxlength="100"
                        placeholder="Colonia" style="text-transform:uppercase;">
                </div>

                <!--Columna Codigo Postal-->
                <div class="col-lg-2 div_etiqueta">
                    <label for="txt_codPostal_modificar">
                        <span class="small">Cod. Postal</span>
                    </label>
                    <input type="text" class="form-control" id="txt_codPostal_modificar" name="txt_codPostal_modificar" maxlength="10">
                </div>

                <!--Columna Localidad-->
                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_Localidad_modificar">
                        <span class="small">Localidad</span>
                    </label>
                    <input type="text" class="form-control" id="txt_Localidad_modificar" name="txt_Localidad_modificar" maxlength="200"
                        placeholder="Maximo 200 caract." style="text-transform:uppercase;">
                </div>
                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_Situacion">
                        <span class="small">Estatus</span><span class="text-danger"> *</span>
                    </label>
                    <select id="txt_Situacion" style="width: 100%;" class="form-control">
                        <option value="-1">Seleccione Estatus</option>
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>
                <div class="col-lg-12">
                    <input type="text" id="txtIdPaciente" hidden>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" onclick="modificar_paciente()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="btnCancelarRegistro">Cancelar</button>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    listarPacientes();
});
</script>
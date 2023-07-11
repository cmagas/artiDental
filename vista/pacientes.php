<?php
    include("conexionBD.php");
    $fecha=date("Y-m-d");

    $consultaHistorial="";

?>

<link href="css/tablas.css" rel="stylesheet">
<link href="css/modales.css" rel="stylesheet">

<link href="css/pacientes.css" rel="stylesheet">
<link href="css/timeline.css" rel="stylesheet">


<script type="text/javascript" src="js/pacientes.js"></script>

<div class="content-header">
    <div class="cont_line-fluid">
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
    </div><!-- /.cont_line-fluid -->
</div>

<!-- Main content -->
<section class="content">
    <div class="cont_line-fluid">

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
    <!--/. cont_line-fluid -->
</section>
<!-- /.content -->

<!--MODAL NUEVO REGISTRO-->
<div class="modal" id="modal_registro_paciente" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray py-1">
                <h5 class="modal-title">REGISTRAR DATOS DEL PACIENTE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div role="tabpanel">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#datosPaciente" aria-controls="historial"
                                role="tab" data-toggle="tab">DATOS DEL PACIENTE</a>
                        </li>
                        <li role="presentation"><a href="#historial" aria-controls="datosG" role="tab"
                                data-toggle="tab">HISTORIAL CLINICO A</a>
                        </li>
                        <li role="presentation"><a href="#historial2" aria-controls="datosG" role="tab"
                                data-toggle="tab">HISTORIAL CLINICO B</a>
                        </li>
                        <li role="presentation"><a href="#historial3" aria-controls="datosG" role="tab"
                                data-toggle="tab">HISTORIAL CLINICO C</a>
                        </li>
                        <li role="presentation"><a href="#historial4" aria-controls="datosG" role="tab"
                                data-toggle="tab">HISTORIAL CLINICO D</a>
                        </li>

                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="datosPaciente">
                            <form id="form_subir" enctype="multipart/form-data">

                                <div class="row">
                                    <div class="form-group mb-2 col-12 col-lg-6">
                                        <label for="iptImagen">
                                            <i class="fas fa-image fs-6"></i>
                                            <span class="small">Seleccione la Foto (.jpg, .png, .gif,
                                                .jpeg)</span>
                                        </label>
                                        <input type="file" class="form-control form-control-sm" id="iptImagen"
                                            name="iptImagen" accept="image/*" onchange="previewFile(this)">
                                    </div>
                                    <div class="col-12 col-lg-6 my-1">
                                        <div style="width: 100%; height: 200px">
                                            <img id="previewImg" src="fotos/no_imagen.png"
                                                class="border border-secondary"
                                                style="object-fit: cover; width: 100%; height: 100%;" alt="">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <!--Columna Nombre-->
                                            <div class="col-lg-4 div_etiqueta">
                                                <label for="txt_nombre">
                                                    <span class="small">Nombre</span><span class="text-danger"> *</span>
                                                </label>
                                                <input type="text" class="form-control" id="txt_nombre"
                                                    name="txt_nombre" style="text-transform:uppercase;">
                                            </div>
                                            <!--Columna Apellido Paterno-->
                                            <div class="col-lg-4 div_etiqueta">
                                                <label for="txt_apPaterno">
                                                    <span class="small">Apellido paterno</span><span
                                                        class="text-danger"> *</span>
                                                </label>
                                                <input type="text" class="form-control" id="txt_apPaterno"
                                                    name="txt_apPaterno" style="text-transform:uppercase;">
                                            </div>
                                            <!--Columna Apellido Materno-->
                                            <div class="col-lg-4 div_etiqueta">
                                                <label for="txt_apMaterno">
                                                    <span class="small">Apellido materno</span><span
                                                        class="text-danger"> *</span>
                                                </label>
                                                <input type="text" class="form-control" id="txt_apMaterno"
                                                    name="txt_apMaterno" style="text-transform:uppercase;">
                                            </div>
                                            <!--Columna RFC-->
                                            <div class="col-lg-4 div_etiqueta">
                                                <label for="txt_rfc">
                                                    <span class="small">R.F.C.</span>
                                                </label>
                                                <input type="text" class="form-control" id="txt_rfc" name="txt_rfc"
                                                    maxlength="13" style="text-transform:uppercase;">
                                            </div>
                                            <!--Columna Genero-->
                                            <div class="col-lg-4 div_etiqueta">
                                                <label for="txt_genero">
                                                    <span class="small">Genero</span>
                                                </label>
                                                <select id="txt_genero" name="txt_genero" style="width: 100%;"
                                                    class="form-control">
                                                    <option value="-1">Seleccione</option>
                                                    <option value="1">Femenino</option>
                                                    <option value="2">Masculino</option>
                                                </select>
                                            </div>
                                            <!--Columna Telefono-->
                                            <div class="col-lg-4 div_etiqueta">
                                                <label for="txt_telefono">
                                                    <span class="small">Teléfono</span><span class="text-danger">
                                                        *</span>
                                                </label>
                                                <input type="tel" class="form-control" id="txt_telefono"
                                                    name="txt_telefono">
                                            </div>
                                            <!--Columna Email-->
                                            <div class="col-lg-4 div_etiqueta">
                                                <label for="txt_email">
                                                    <span class="small">Correo Electrónico</span><span
                                                        class="text-danger"> *</span>
                                                </label>
                                                <input type="email" class="form-control" id="txt_email" name="txt_email"
                                                    maxlength="150" style="text-transform:uppercase;">
                                            </div>
                                            <!--Columna Fecha Nac-->
                                            <div class="col-lg-4 div_etiqueta">
                                                <label for="txt_fechaNac">
                                                    <span class="small">Fecha de Nacimiento</span>
                                                </label>
                                                <input type="date" class="form-control" id="txt_fechaNac"
                                                    name="txt_fechaNac" max="<?php echo $fecha; ?>">
                                            </div>
                                            <div class="col-lg-2 div_etiqueta">
                                                <label for="txt_peso">
                                                    <span class="small">Peso</span>
                                                </label>
                                                <input type="text" class="form-control" id="txt_peso" name="txt_peso">
                                            </div>
                                            <div class="col-lg-2 div_etiqueta">
                                                <label for="txt_estatura">
                                                    <span class="small">Estatura</span>
                                                </label>
                                                <input type="text" class="form-control" id="txt_estatura"
                                                    name="txt_estatura">
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
                                        <select class="js-example-basic-single form-control" id="cmb_estado"
                                            name="cmb_estado" style="width: 100%;"
                                            onchange="obtenerMunicipiosPorEstado(this.value)">
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
                                        <select id="txt_municipio" name="txt_municipio" style="width: 100%;"
                                            class="form-control">
                                            <option value="-1">Seleccione el Municipio</option>
                                        </select>
                                    </div>

                                    <!--Columna Calle-->
                                    <div class="col-lg-10 div_etiqueta">
                                        <label for="txt_calle">
                                            <span class="small">Calle</span>
                                        </label>
                                        <input type="text" class="form-control" id="txt_calle" name="txt_calle"
                                            maxlength="50" placeholder="Maximo 50 caract."
                                            style="text-transform:uppercase;">
                                    </div>

                                    <!--Columna Numero-->
                                    <div class="col-lg-2 div_etiqueta">
                                        <label for="txt_numero">
                                            <span class="small">Número</span>
                                        </label>
                                        <input type="text" class="form-control" id="txt_numero" name="txt_numero"
                                            maxlength="10" style="text-transform:uppercase;">
                                    </div>

                                    <!--Columna Colonia-->
                                    <div class="col-lg-10 div_etiqueta">
                                        <label for="txt_colonia">
                                            <span class="small">Colonia</span>
                                        </label>
                                        <input type="text" class="form-control" id="txt_colonia" name="txt_colonia"
                                            maxlength="100" placeholder="Colonia" style="text-transform:uppercase;">
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
                                            maxlength="200" placeholder="Maximo 200 caract."
                                            style="text-transform:uppercase;">
                                    </div>

                                </div>
                            </form>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="historial">
                            <div class="preg_resp">
                                <div class="pregunta">
                                    1. ¿Se encuentra en buen estado de salud?
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg1" value="1" /> Sí<br />
                                    <input type="radio" name="preg1" value="0" /> No<br />
                                </div>

                            </div>
                            <div class="preg_resp">
                                <div class="pregunta">
                                    2. ¿Ha habido algún cambio en su salud general en el año pasado?
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg2" value="1" /> Sí<br />
                                    <input type="radio" name="preg2" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta">
                                    3. Su ultimo exámen físico fue en:
                                </div>
                                <div class="respuesta">
                                    <input type="text" name="preg3" value="" style="width:400px" /><br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta">
                                    4. ¿Está bajo cuidado de algún Médico?
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg4" value="1" /> Sí<br />
                                    <input type="radio" name="preg4" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    a. De ser así, ¿De que se está tratando?
                                </div>
                                <div class="respuesta1">
                                    <input type="text" name="preg4_1" value="" style="width:400px" /><br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta">
                                    5. El nombre y domicilio de su Médico es:
                                </div>
                                <div class="respuesta">
                                    <textarea class="form-control " rows="2" id="preg5" maxlength="150"
                                        placeholder="Maximo 150 caracteres" style="width:400px"></textarea>
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta">
                                    6. ¿Le han efectuado alguna operación o padecido alguna enfermedad grave?
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg6" value="1" /> Sí<br />
                                    <input type="radio" name="preg6" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    a. De ser así, ¿cual fue el problema?
                                </div>
                                <div class="respuesta1">
                                    <textarea class="form-control " rows="2" id="preg6_1" maxlength="150"
                                        placeholder="Maximo 150 caracteres" style="width:400px"></textarea>
                                </div>
                            </div>

                            <div class="preg_resp">
                                <div class="pregunta">
                                    7. ¿Ha sido hospitalizado o ha padecido alguna enfermedad en los últimos cinco años?
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg7" value="1" /> Sí<br />
                                    <input type="radio" name="preg7" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    a. De ser así, ¿cual fue el problema?
                                </div>
                                <div class="respuesta1">
                                    <textarea class="form-control " rows="2" id="preg7_1" maxlength="150"
                                        placeholder="Maximo 150 caracteres" style="width:400px"></textarea>
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta">
                                    8. Padece o ha padecido algunas de las enfermedades o problemas siguientes:
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    a. Daño en las valvulas cardiacas o válvulas cardiacas artificiales
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg8_1" value="1" /> Sí<br />
                                    <input type="radio" name="preg8_1" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    b. Lesiones cardiacas congénitas
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg8_2" value="1" /> Sí<br />
                                    <input type="radio" name="preg8_2" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    c. Enfermedades cardiovasculares (problemas cardiacos, ataques cardiacos,
                                    insuficiencia Coronaria,
                                    presión alta, arteriosclerosis, apoplejía)
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg8_3" value="1" /> Sí<br />
                                    <input type="radio" name="preg8_3" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta2">
                                    1. ¿Siente dolor en el pecho cuando se agita?
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg8_4" value="1" /> Sí<br />
                                    <input type="radio" name="preg8_4" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta2">
                                    2. ¿Le falta la respiración despues de realizar un ejercicio moderado?
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg8_5" value="1" /> Sí<br />
                                    <input type="radio" name="preg8_5" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta2">
                                    3. ¿Se le inflaman los tobillos?
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg8_6" value="1" /> Sí<br />
                                    <input type="radio" name="preg8_6" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta2">
                                    4. ¿Le falta el aire cuando esta acostado, o necesita mas almohadas para dormir?
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg8_7" value="1" /> Sí<br />
                                    <input type="radio" name="preg8_7" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta2">
                                    5. ¿Tiene marcapasos?
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg8_8" value="1" /> Sí<br />
                                    <input type="radio" name="preg8_8" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    d. Alergias
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg8_9" value="1" /> Sí<br />
                                    <input type="radio" name="preg8_9" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    e. Problemas sinusales
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg8_10" value="1" /> Sí<br />
                                    <input type="radio" name="preg8_10" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    f. Asma 0 fiebre de heno
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg8_11" value="1" /> Sí<br />
                                    <input type="radio" name="preg8_11" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    g. Urticaria 0 erupciones cutáneas
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg8_12" value="1" /> Sí<br />
                                    <input type="radio" name="preg8_12" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    h. Desmayos o ataques
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg8_13" value="1" /> Sí<br />
                                    <input type="radio" name="preg8_13" value="0" /> No<br />
                                </div>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="historial2">

                            <div class="preg_resp">
                                <div class="pregunta1">
                                    i. Diabetes
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg8_14" value="1" /> Sí<br />
                                    <input type="radio" name="preg8_14" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta2">
                                    1. ¿Tiene usted que orinar mas de seis veces al día?
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg8_15" value="1" /> Sí<br />
                                    <input type="radio" name="preg8_15" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta2">
                                    2. ¿Tiene usted sed la mayor parte del día?
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg8_16" value="1" /> Sí<br />
                                    <input type="radio" name="preg8_16" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta2">
                                    3. ¿Se le seca frecuentemente la boca?
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg8_17" value="1" /> Sí<br />
                                    <input type="radio" name="preg8_17" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    j. Hepatitis ictericia o enfermedades
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg8_18" value="1" /> Sí<br />
                                    <input type="radio" name="preg8_18" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    k. Artritis
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg8_19" value="1" /> Sí<br />
                                    <input type="radio" name="preg8_19" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    l. Reumatismo inflamatorio (articulaciones inflamadas dolorosas)
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg8_20" value="1" /> Sí<br />
                                    <input type="radio" name="preg8_20" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    m. Ulceras estomacales
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg8_21" value="1" /> Sí<br />
                                    <input type="radio" name="preg8_21" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    n. Problemas del riñon
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg8_22" value="1" /> Sí<br />
                                    <input type="radio" name="preg8_22" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    o. Tuberculosis
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg8_23" value="1" /> Sí<br />
                                    <input type="radio" name="preg8_23" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    p. ¿Tiene tos persistente o tose sangre?
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg8_24" value="1" /> Sí<br />
                                    <input type="radio" name="preg8_24" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    q. Bja presión arterial
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg8_25" value="1" /> Sí<br />
                                    <input type="radio" name="preg8_25" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    r. Enfermedades venéreas
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg8_26" value="1" /> Sí<br />
                                    <input type="radio" name="preg8_26" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    s. Otras
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg8_26" value="1" /> Sí<br />
                                    <input type="radio" name="preg8_26" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta">
                                    9. ¿ha padecido sangrados anormales relacionados con extracciones previas, cirugías
                                    o traumatismo?
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg9" value="1" /> Sí<br />
                                    <input type="radio" name="preg9" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    a. ¿Le salen moretones (equimosis) con facilidad?
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg9_1" value="1" /> Sí<br />
                                    <input type="radio" name="preg9_1" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    b. ¿Ha necesitado alguna vez una transfusión sanguínea?
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg9_2" value="1" /> Sí<br />
                                    <input type="radio" name="preg9_2" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta2">
                                    De ser así, explique las circunstancia
                                </div>
                                <div class="respuesta">
                                    <textarea class="form-control " rows="2" id="preg9_3" maxlength="150"
                                        placeholder="Maximo 150 caracteres" style="width:400px"></textarea>
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta">
                                    10. ¿Padece algún trastorno sanguíneo como la anemia?
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg10" value="1" /> Sí<br />
                                    <input type="radio" name="preg10" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta">
                                    11. ¿Le han practicado alguna cirugía o tratamiento con radiaciones para algún tumor
                                    o crecimiento
                                    o otra alteración de su cabeza o cuello?
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg11" value="1" /> Sí<br />
                                    <input type="radio" name="preg11" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta">
                                    12. ¿Está tomando alguna droga o medicamento?
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg12" value="1" /> Sí<br />
                                    <input type="radio" name="preg12" value="0" /> No<br />
                                </div>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="historial3">
                            <div class="preg_resp">
                                <div class="pregunta">
                                    13. ¿Esta tomando algo de lo siguiente?
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    a. Antibiotico o sulfas
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg13_1" value="1" /> Sí<br />
                                    <input type="radio" name="preg13_1" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    b. Anticoagulantes (adelgazadores de la sangre)
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg13_2" value="1" /> Sí<br />
                                    <input type="radio" name="preg13_2" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    c. Medicamentos para la presión arterial alta
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg13_3" value="1" /> Sí<br />
                                    <input type="radio" name="preg13_3" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    d. Cortosona esteroide
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg13_4" value="1" /> Sí<br />
                                    <input type="radio" name="preg13_4" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    e. Tranquilizantes
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg13_5" value="1" /> Sí<br />
                                    <input type="radio" name="preg13_5" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    f. Antihistamínico
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg13_6" value="1" /> Sí<br />
                                    <input type="radio" name="preg13_6" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    g. Aspirina
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg13_7" value="1" /> Sí<br />
                                    <input type="radio" name="preg13_7" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    h. Insulina, tobultamida (orinaza) o drogas similares
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg13_8" value="1" /> Sí<br />
                                    <input type="radio" name="preg13_8" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    i. Digitálicos o fármacos para problemas cardiacos
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg13_9" value="1" /> Sí<br />
                                    <input type="radio" name="preg13_9" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    j. Nitroglicerina
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg13_10" value="1" /> Sí<br />
                                    <input type="radio" name="preg13_10" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    k. Anticonceptivos orales u otras hormonas para terapéutica
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg13_11" value="1" /> Sí<br />
                                    <input type="radio" name="preg13_11" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    l. Otros
                                </div>
                                <div class="respuesta">
                                    <input type="text" name="preg13_12" value="" style="width:400px" /><br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta">
                                    14. ¿Es usted alérgico? o ha reaccionado de manera adversa a:
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    a. Anestésicos locales
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg14_1" value="1" /> Sí<br />
                                    <input type="radio" name="preg14_1" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    b. Penicilina u otros antibióticos
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg14_2" value="1" /> Sí<br />
                                    <input type="radio" name="preg14_2" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    c. Sulfas
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg14_3" value="1" /> Sí<br />
                                    <input type="radio" name="preg14_3" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    d. Barbitúricos o sedantes pastillas para dormir
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg14_4" value="1" /> Sí<br />
                                    <input type="radio" name="preg14_4" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    e. Aspirinas
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg14_5" value="1" /> Sí<br />
                                    <input type="radio" name="preg14_5" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    f. Yodo
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg14_6" value="1" /> Sí<br />
                                    <input type="radio" name="preg14_6" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    g. Codeína u otros narcóticos
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg14_7" value="1" /> Sí<br />
                                    <input type="radio" name="preg14_7" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    h. Otros
                                </div>
                                <div class="respuesta">
                                    <input type="text" name="preg14_8" value="" style="width:400px" /><br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta">
                                    15. ¿Ha tenido usted problema grave vinculado con cualquier tratamiento dental
                                    previo?
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg15" value="1" /> Sí<br />
                                    <input type="radio" name="preg15" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    Sí es así explique cuál
                                </div>
                                <div class="respuesta">
                                    <textarea class="form-control " rows="2" id="preg15_1" maxlength="150"
                                        placeholder="Maximo 150 caracteres" style="width:400px"></textarea>
                                </div>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="historial4">
                            <div class="preg_resp">
                                <div class="pregunta">
                                    16. ¿Tiene usted un problema no mencionado en la parte superior que crea que yo debo
                                    conocer?
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg16" value="1" /> Sí<br />
                                    <input type="radio" name="preg16" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta1">
                                    Sí es así explique cuál
                                </div>
                                <div class="respuesta">
                                    <textarea class="form-control " rows="2" id="preg16_1" maxlength="150"
                                        placeholder="Maximo 150 caracteres" style="width:400px"></textarea>
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta">
                                    17. ¿Trabaja usted en algun lugar donde este expuesto a rayos X, u otra radiación
                                    ionizante?
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg17" value="1" /> Sí<br />
                                    <input type="radio" name="preg17" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta">
                                    18. ¿Usa lentes de contacto?
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg18" value="1" /> Sí<br />
                                    <input type="radio" name="preg18" value="0" /> No<br />
                                </div>
                            </div>
                            <h4 class="subtitulos">MUJERES</h4>

                            <div class="preg_resp">
                                <div class="pregunta">
                                    19. ¿Esta usted embarazada?
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg19" value="1" /> Sí<br />
                                    <input type="radio" name="preg19" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta">
                                    20. ¿Tiene algún problema con su periodo mensual?
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg20" value="1" /> Sí<br />
                                    <input type="radio" name="preg20" value="0" /> No<br />
                                </div>
                            </div>
                            <div class="preg_resp">
                                <div class="pregunta">
                                    21. ¿Esta usted amamantando?
                                </div>
                                <div class="respuesta">
                                    <input type="radio" name="preg21" value="1" /> Sí<br />
                                    <input type="radio" name="preg21" value="0" /> No<br />
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
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
                    <input type="text" class="form-control" id="txt_rfc_modificar" name="txt_rfc_modificar"
                        maxlength="13" style="text-transform:uppercase;">
                </div>
                <!--Columna Genero-->
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_genero_modificar">
                        <span class="small">Genero</span>
                    </label>
                    <select id="txt_genero_modificar" name="txt_genero_modificar" style="width: 100%;"
                        class="form-control">
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
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_email_modificar">
                        <span class="small">Correo Electrónico</span><span class="text-danger"> *</span>
                    </label>
                    <input type="email" class="form-control" id="txt_email_modificar" name="txt_email_modificar"
                        maxlength="150" style="text-transform:uppercase;">
                </div>
                <!--Columna Fecha Nac-->
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_fechaNac_modificar">
                        <span class="small">Fecha de Nacimiento</span>
                    </label>
                    <input type="date" class="form-control" id="txt_fechaNac_modificar" name="txt_fechaNac_modificar"
                        max="<?php echo $fecha; ?>">
                </div>
                <div class="col-lg-2 div_etiqueta">
                    <label for="txt_peso_modificar">
                        <span class="small">Peso</span>
                    </label>
                    <input type="text" class="form-control" id="txt_peso_modificar" name="txt_peso_modificar">
                </div>
                <div class="col-lg-2 div_etiqueta">
                    <label for="txt_estatura_modificar">
                        <span class="small">Estatura</span>
                    </label>
                    <input type="text" class="form-control" id="txt_estatura_modificar" name="txt_estatura_modificar">
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
                    <select class="js-example-basic-single form-control" id="cmb_estado_modificar" style="width: 100%;"
                        onchange="obtenerMunicipiosPorEstado2(this.value)">
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
                    <input type="text" class="form-control" id="txt_calle_modificar" name="txt_calle_modificar"
                        maxlength="50" placeholder="Maximo 50 caract." style="text-transform:uppercase;">
                </div>

                <!--Columna Numero-->
                <div class="col-lg-2 div_etiqueta">
                    <label for="txt_numero_modificar">
                        <span class="small">Número</span>
                    </label>
                    <input type="text" class="form-control" id="txt_numero_modificar" name="txt_numero_modificar"
                        maxlength="10" style="text-transform:uppercase;">
                </div>

                <!--Columna Colonia-->
                <div class="col-lg-10 div_etiqueta">
                    <label for="txt_colonia_modificar">
                        <span class="small">Colonia</span>
                    </label>
                    <input type="text" class="form-control" id="txt_colonia_modificar" name="txt_colonia_modificar"
                        maxlength="100" placeholder="Colonia" style="text-transform:uppercase;">
                </div>

                <!--Columna Codigo Postal-->
                <div class="col-lg-2 div_etiqueta">
                    <label for="txt_codPostal_modificar">
                        <span class="small">Cod. Postal</span>
                    </label>
                    <input type="text" class="form-control" id="txt_codPostal_modificar" name="txt_codPostal_modificar"
                        maxlength="10">
                </div>

                <!--Columna Localidad-->
                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_Localidad_modificar">
                        <span class="small">Localidad</span>
                    </label>
                    <input type="text" class="form-control" id="txt_Localidad_modificar" name="txt_Localidad_modificar"
                        maxlength="200" placeholder="Maximo 200 caract." style="text-transform:uppercase;">
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

<!--MODAL TIME LINE-->
<div class="modal" id="modal_timeLine" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray py-1">
                <h5 class="modal-title">TIME LINE DEL PACIENTE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-date">20-MARZO-2023</div>
                        <div class="timeline-content">DESCRIPCION</div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <input type="text" id="txtIdPacienteTime" class="texto_prueba">
                </div>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    listarPacientes();
});
</script>
<?php
    include("conexionBD.php");
    $fecha=date("Y-m-d");

    $razonSocial="";
    $rfc="";
    $logo="fotos/empresa/no_imagen.png";
    $localidad="";
    $estado="-1";
    $municipio="-1";
    $calle="";
    $numero="";
    $colonia="";
    $codPostal="";
    $telefono="";
    $email="";

    $consulta="SELECT * FROM 2004_empresa WHERE situacion='1'";
    $res=$con->obtenerPrimeraFila($consulta);
    if($res)
    {
        $razonSocial=$res[3];
        $rfc=$res[7];
        $logo=$res[8];
        $localidad=$res[9];
        $estado=$res[10];
        $municipio=$res[11];
        $calle=$res[12];
        $numero=$res[13];
        $colonia=$res[14];
        $codPostal=$res[15];
        $telefono=$res[16];
        $email=$res[17];
    }


?>

<link href="css/tablas.css" rel="stylesheet">
<link href="css/modales.css" rel="stylesheet">

<script type="text/javascript" src="js/empresa.js"></script>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="mt-4">CONFIGURACIÓN DE EMPRESA</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Configuración de Empresa</li>
                </ol>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<section class="content">
    <div class="container">
        <form id="form_subir" enctype="multipart/form-data">
            <div class="row">
                <!--Columna foto-->
                <div class="col-12 div_etiqueta">
                    <div class="form-group mb-2">
                        <label for="iptImagen">
                            <i class="fas fa-image fs-6"></i>
                            <span class="small">Seleccione el Logo (.jpg, .png, .gif,
                                .jpeg)</span>
                        </label>
                        <input type="file" class="form-control form-control-sm" id="iptImagen" name="iptImagen"
                            accept="image/*" onchange="previewFile(this)">
                    </div>
                </div>

                <div class="col-12 col-lg-3 my-1">
                    <div style="width: 100%; height: 200px">
                        <img id="previewImg" src="<?php echo $logo ?>" class="border border-secondary"
                            style="object-fit: contain; width: 100%; height: 100%;" alt="">
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="row">
                        <!--Columna Nombre-->
                        <div class="col-lg-12 div_etiqueta">
                            <label for="txt_nombre">
                                <span class="small">Nombre del Establecimiento</span><span class="text-danger"> *</span>
                            </label>
                            <input type="text" class="form-control" id="txt_nombre" name="txt_nombre" value="<?php echo $razonSocial ?>"
                                style="text-transform:uppercase;">
                        </div>
                        <!--Columna RFC-->
                        <div class="col-lg-4 div_etiqueta">
                            <label for="txt_rfc">
                                <span class="small">R.F.C.</span>
                            </label>
                            <input type="text" class="form-control" id="txt_rfc" name="txt_rfc" maxlength="13"
                                style="text-transform:uppercase;" value="<?php echo $rfc ?>">
                        </div>

                        <!--Columna Telefono-->
                        <div class="col-lg-4 div_etiqueta">
                            <label for="txt_telefono">
                                <span class="small">Teléfono</span>
                            </label>
                            <input type="tel" class="form-control" id="txt_telefono" name="txt_telefono" value="<?php echo $telefono ?>">
                        </div>

                        <!--Columna Email-->
                        <div class="col-lg-4 div_etiqueta">
                            <label for="txt_email">
                                <span class="small">Correo Electrónico</span>
                            </label>
                            <input type="email" class="form-control" id="txt_email" name="txt_email" maxlength="150"
                                style="text-transform:uppercase;" value="<?php echo $email ?>">
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
                        <option value="<?php echo $estado ?>">Seleccione el Estado</option>
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
                        placeholder="Maximo 50 caract." style="text-transform:uppercase;" value="<?php echo $calle ?>">
                </div>

                <!--Columna Numero-->
                <div class="col-lg-2 div_etiqueta">
                    <label for="txt_numero">
                        <span class="small">Número</span>
                    </label>
                    <input type="text" class="form-control" id="txt_numero" name="txt_numero" maxlength="10"
                        style="text-transform:uppercase;" value="<?php echo $numero ?>">
                </div>

                <!--Columna Colonia-->
                <div class="col-lg-10 div_etiqueta">
                    <label for="txt_colonia">
                        <span class="small">Colonia</span>
                    </label>
                    <input type="text" class="form-control" id="txt_colonia" name="txt_colonia" maxlength="100"
                        placeholder="Colonia" style="text-transform:uppercase;" value="<?php echo $colonia ?>">
                </div>

                <!--Columna Codigo Postal-->
                <div class="col-lg-2 div_etiqueta">
                    <label for="txt_codPostal">
                        <span class="small">Cod. Postal</span>
                    </label>
                    <input type="text" class="form-control" id="txt_codPostal" name="txt_codPostal" maxlength="10" value="<?php echo $codPostal ?>">
                </div>

                <!--Columna Localidad-->
                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_Localidad">
                        <span class="small">Localidad</span>
                    </label>
                    <input type="text" class="form-control" id="txt_Localidad" name="txt_Localidad" maxlength="200"
                        placeholder="Maximo 200 caract." style="text-transform:uppercase;" value="<?php echo $localidad ?>">
                </div>

            </div>
        </form>

        <div class="modal-footer">
            <button class="btn btn-primary" onclick="registrar_empresa()">Guardar datos</button>
        </div>

    </div>

</section>
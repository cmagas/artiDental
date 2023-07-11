<?php
    include("latis/conexionBD.php");

?>

<link href="css/tablas.css" rel="stylesheet">
<link href="css/modales.css" rel="stylesheet">

<script type="text/javascript" src="js/productos.js"></script>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="mt-4">CATALOGO DE PRODUCTOS</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right mt-4">
                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Productos</li>
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
                <table id="tbl_productos" class="table table-striped w-100 shadow">
                    <thead>
                        <tr>
                            <th></th>
                            <th>id</th>
                            <th>Codigo</th>
                            <th>Categoria</th>
                            <th>Producto</th>
                            <th>P. venta</th>
                            <th>Utilidad</th>
                            <th>Stock Max.</th>
                            <th>Stock Min.</th>
                            <th>Exist.</th>
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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray py-1">
                <h5 class="modal-title">Agregar Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_codigoBarra"><i class="fas fa-barcode fs-6"></i>
                        <span class="small">Codigo de Barra</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_codigoBarra" placeholder="Código del Producto">
                </div>
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_categoria"><i class="fas fa-dumpster fs-6"></i>
                        <span class="small">Categoría</span><span class="text-danger"> *</span>
                    </label>
                    <select name="" id="txt_categoria" style="width: 100%;" class="form-control">
                        <option value="-1">Seleccione la Categoría</option>
                        <?php
                            $Consulta="SELECT id_categoria,nombre_categoria FROM 4001_categorias WHERE situacion='1' ORDER BY nombre_categoria";
                            $con->generarOpcionesSelect($Consulta);
                        ?>
                    </select>
                </div>
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_impuesto"><i class="fas fa-dollar-sign fs-6"></i>
                        <span class="small">Impuesto</span><span class="text-danger"> *</span>
                    </label>
                    <select name="" id="txt_impuesto" style="width: 100%;" class="form-control">
                        <option value="-1">Seleccione el impuesto</option>
                        <?php
                            $Consulta="SELECT idImpuesto, CONCAT(nombreImpuesto,'[ ',valor,' ]') AS impuesto FROM 4002_impuesto WHERE situacion='1'";
                            $con->generarOpcionesSelect($Consulta);
                        ?>
                    </select>
                </div>
                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_producto"><i class="fas fa-tasks fs-6"></i>
                        <span class="small">Producto</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_producto" placeholder="Nombre del Producto">
                </div>
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_precioCompra"><i class="fas fa-dollar-sign fs-6"></i>
                        <span class="small">Precio de Compra</span><span class="text-danger"> *</span>
                    </label>
                    <input type="number" class="form-control" id="txt_precioCompra">
                </div>
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_precioVenta"><i class="fas fa-dollar-sign fs-6"></i>
                        <span class="small">Precio de Venta</span><span class="text-danger"> *</span>
                    </label>
                    <input type="number" class="form-control" id="txt_precioVenta">
                </div>
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_utilidad"><i class="fas fa-dollar-sign fs-6"></i>
                        <span class="small">Utilidad</span>
                    </label>
                    <input type="text" class="form-control" id="txt_utilidad" disabled>
                </div>
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_stockMaximo"><i class="fas fa-plus-square fs-6"></i>
                        <span class="small">Stock Máximo</span><span class="text-danger"> *</span>
                    </label>
                    <input type="number" class="form-control" id="txt_stockMaximo">
                </div>
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_stockMinimo"><i class="fas fa-minus-square fs-6"></i>
                        <span class="small">Stock Mínimo</span><span class="text-danger"> *</span>
                    </label>
                    <input type="number" class="form-control" id="txt_stockMinimo">
                </div>
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_existencia"><i class="fas fa-columns fs-6"></i>
                        <span class="small">Existencia</span>
                    </label>
                    <input type="number" class="form-control" id="txt_existencia" disabled>
                </div>
                <div class="col-lg-12 div_etiqueta"><i class="fas fa-file-image fs-6"></i>
                    <label for="txt_foto"><span class="small">Imagen del Producto</span></label>
                    <input type="file" class="form-control" id="txt_foto" placeholder="fecha Nac">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="registrar_producto()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="btnCancelarRegistro">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!--MODAL MODIFICAR REGISTRO-->
<div class="modal" id="modal_modificar_productos" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray py-1">
                <h5 class="modal-title">Modificar Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_codigoBarra_modifi"><i class="fas fa-barcode fs-6"></i>
                        <span class="small">Codigo de Barra</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_codigoBarra_modifi"
                        placeholder="Código del Producto">
                </div>
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_categoria_modifi"><i class="fas fa-dumpster fs-6"></i>
                        <span class="small">Categoría</span><span class="text-danger"> *</span>
                    </label>
                    <select name="" id="txt_categoria_modifi" style="width: 100%;" class="form-control">
                        <option value="-1">Seleccione la Categoría</option>
                        <?php
                            $Consulta="SELECT id_categoria,nombre_categoria FROM 4001_categorias WHERE situacion='1' ORDER BY nombre_categoria";
                            $con->generarOpcionesSelect($Consulta);
                        ?>
                    </select>
                </div>
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_impuesto_modifi"><i class="fas fa-dollar-sign fs-6"></i>
                        <span class="small">Impuesto</span><span class="text-danger"> *</span>
                    </label>
                    <select name="" id="txt_impuesto_modifi" style="width: 100%;" class="form-control">
                        <option value="-1">Seleccione el impuesto</option>
                        <?php
                            $Consulta="SELECT idImpuesto, CONCAT(nombreImpuesto,'[ ',valor,' ]') AS impuesto FROM 4002_impuesto WHERE situacion='1'";
                            $con->generarOpcionesSelect($Consulta);
                        ?>
                    </select>
                </div>
                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_producto_modifi"><i class="fas fa-tasks fs-6"></i>
                        <span class="small">Producto</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_producto_modifi" placeholder="Nombre del Producto">
                </div>
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_precioCompra_modifi"><i class="fas fa-dollar-sign fs-6"></i>
                        <span class="small">Precio de Compra</span><span class="text-danger"> *</span>
                    </label>
                    <input type="number" class="form-control" id="txt_precioCompra_modifi">
                </div>
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_precioVenta_modifi"><i class="fas fa-dollar-sign fs-6"></i>
                        <span class="small">Precio de Venta</span><span class="text-danger"> *</span>
                    </label>
                    <input type="number" class="form-control" id="txt_precioVenta_modifi">
                </div>
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_utilidad_modifi"><i class="fas fa-dollar-sign fs-6"></i>
                        <span class="small">Utilidad</span>
                    </label>
                    <input type="text" class="form-control" id="txt_utilidad_modifi" disabled>
                </div>
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_stockMaximo_modifi"><i class="fas fa-plus-square fs-6"></i>
                        <span class="small">Stock Máximo</span><span class="text-danger"> *</span>
                    </label>
                    <input type="number" class="form-control" id="txt_stockMaximo_modifi">
                </div>
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_stockMinimo_modifi"><i class="fas fa-minus-square fs-6"></i>
                        <span class="small">Stock Mínimo</span><span class="text-danger"> *</span>
                    </label>
                    <input type="number" class="form-control" id="txt_stockMinimo_modifi">
                </div>
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_existencia_modifi"><i class="fas fa-columns fs-6"></i>
                        <span class="small">Existencia</span>
                    </label>
                    <input type="number" class="form-control" id="txt_existencia_modifi" disabled>
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
                    <input type="text" id="txtIdProducto" hidden>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="Modificar_producto()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="btnCancelarRegistro">Cancelar</button>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    listarProductos();
});

$('#btnCancelarRegistro, #btnCerrarModal').on('click', function() {
    limpiarCamposModalRegistro();
})

/*===================================================================*/
//EVENTO PARA CALCULAR LA UTILIDAD AL DIGITAR SOBRE LOS INPUT'S
/*===================================================================*/
$("#txt_precioCompra, #txt_precioVenta").keyup(function() {
    calcularUtilidadProducto(1);
});

/*===================================================================*/
//EVENTO PARA CALCULAR LA UTILIDAD AL CAMBIAR EL CONTENIDO (PERDER FOCUS)
/*===================================================================*/
$("#txt_precioCompra, #txt_precioVenta").change(function() {
    calcularUtilidadProducto(1);
});

/*===================================================================*/
//EVENTO PARA CALCULAR LA UTILIDAD AL DIGITAR SOBRE LOS INPUT'S
/*===================================================================*/
$("#txt_precioCompra_modifi, #txt_precioVenta_modifi").keyup(function() {
    calcularUtilidadProducto(2);
});

/*===================================================================*/
//EVENTO PARA CALCULAR LA UTILIDAD AL CAMBIAR EL CONTENIDO (PERDER FOCUS)
/*===================================================================*/
$("#txt_precioCompra_modifi, #txt_precioVenta_modifi").change(function() {
    calcularUtilidadProducto(2);
});
</script>
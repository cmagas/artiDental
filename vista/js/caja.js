var table;
var items = []; // SE USA PARA EL INPUT DE AUTOCOMPLETE
var itemProducto = 1;

/* ======================================================================================
    EVENTO PARA VACIAR EL CARRITO DE COMPRAS
=========================================================================================*/
$("#btnVaciarListado").on('click', function() {
    vaciarListado();
})

function inicializarTablaProductos()
{
    table = $('#lstProductosVenta').DataTable({
        "columns": [
            { "data": "id" },
            { "data": "codigo_producto" },
            { "data": "id_categoria" },
            { "data": "nombre_categoria" },
            { "data": "descripcion_producto" },
            { "data": "cantidad" },
            { "data": "precio_venta_producto" },
            { "data": "total" },
            { "data": "acciones" },
            { "data": "aplica_peso" },
            { "data": "precio_mayor_producto" },
            { "data": "precio_oferta_producto" },
            { "data": "valorImpuesto" }
        ],
        columnDefs: [{
                targets: 0,
                visible: false
            },
            {
                targets: 2,
                visible: false
            },
            {
                targets: 3,
                visible: false
            },
            {
                targets: 6,
                orderable: false
            },
            {
                targets: 9,
                visible: false
            },
            {
                targets: 10,
                visible: false
            },
            {
                targets: 11,
                visible: false
            },
            {
                targets: 12,
                visible: false
            }
        ],
        "order": [
            [0, 'desc']
        ],
        language: idioma_espanol,
    });
}

/* ======================================================================================
    TRAER LISTADO DE PRODUCTOS PARA INPUT DE AUTOCOMPLETADO
    ======================================================================================*/
function listadoProducto()
{
    var cadObj="";
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            const arreglo=JSON.parse(arrResp[1]);

            arreglo.forEach(element => {
                 items.push(element.descripcion_producto);
            });

              $("#iptCodigoVenta").autocomplete({

                source: items,
                select: function(event, ui) {
                    //console.log(ui.item.value);
                    CargarProductos(ui.item.value);                                                            
                    $("#iptCodigoVenta").val("");
                    $("#iptCodigoVenta").focus();

                    return false;
                }
            })
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo obtener registros","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFuncionesCaja.php',funcAjax, 'POST','funcion=6&cadObj='+cadObj,true) 
}

/* ======================================================================================
    EVENTO QUE REGISTRA EL PRODUCTO EN EL LISTADO CUANDO SE INGRESA EL CODIGO DE BARRAS
======================================================================================*/
    $("#iptCodigoVenta").change(function() {
        CargarProductos();        
    });

 /* ======================================================================================
    EVENTO PARA ELIMINAR UN PRODUCTO DEL LISTADO
======================================================================================*/
    $('#lstProductosVenta tbody').on('click', '.btnEliminarproducto', function() {
        table.row($(this).parents('tr')).remove().draw();
        recalcularTotales();
    }); 
    
 /* ======================================================================================
    EVENTO PARA AUMENTAR LA CANTIDAD DE UN PRODUCTO DEL LISTADO
====================================================================================== */
    $('#lstProductosVenta tbody').on('click', '.btnAumentarCantidad', function() {

        var data = table.row($(this).parents('tr')).data(); //Recuperar los datos de la fila

        var idx = table.row($(this).parents('tr')).index();  // Recuperar el Indice de la Fila

        var codigo_producto = data['codigo_producto'];
        var cantidad = data['cantidad'];

        $.ajax({
            async: false,
            url: "funciones/paginaFuncionesCaja.php",
            method: "POST",
            data: {
                'funcion': 8,
                'codigo_producto': codigo_producto,
                'cantidad_a_comprar': cantidad
            },

            dataType: 'json',
            success: function(respuesta) {
                //console.log(respuesta['existe']);

                if (parseInt(respuesta['existe']) == 0) {

                    return Swal.fire(" El producto " + data['descripcion_producto'] + ", ya no tiene stock","error");

                    $("#iptCodigoVenta").val("");
                    $("#iptCodigoVenta").focus();

                } else {

                    cantidad = parseInt(data['cantidad']) + 1;

                    table.cell(idx, 5).data(cantidad + ' Und(s)').draw();

                    var precio=data['precio_venta_producto'].replace("$ ", "")
 
                    NuevoPrecio = (parseInt(cantidad) * precio).toFixed(2);
 
                    NuevoPrecio = "$ " + NuevoPrecio;
                    
                    table.cell(idx, 7).data(NuevoPrecio).draw();

                    recalcularTotales();
                }
            }
        });

    });    

  /* ======================================================================================
    EVENTO PARA DESMINUIR LA CANTIDAD DE UN PRODUCTO DEL LISTADO
    ======================================================================================*/
    $('#lstProductosVenta tbody').on('click', '.btnDisminuirCantidad', function() {

        var data = table.row($(this).parents('tr')).data();

        if (data['cantidad'].replace('Und(s)', '') >= 2) {

            cantidad = parseInt(data['cantidad'].replace('Und(s)', '')) - 1;

            var idx = table.row($(this).parents('tr')).index();

            table.cell(idx, 5).data(cantidad + ' Und(s)').draw();

            NuevoPrecio = (parseInt(data['cantidad']) * data['precio_venta_producto'].replace("$ ", "")).toFixed(2);
            NuevoPrecio = "$ " + NuevoPrecio;

            table.cell(idx, 7).data(NuevoPrecio).draw();

        }

        recalcularTotales();
    });

/* ======================================================================================
    EVENTO PARA INGRESAR EL PESO DEL PRODUCTO
    ====================================================================================== */
    $('#lstProductosVenta tbody').on('click', '.btnIngresarPeso', function() {

        var data = table.row($(this).parents('tr')).data();

        Swal.fire({
            title: "",
            text: "Peso del Producto [KG (ej: .5, 2.5,etc)]):",
            input: 'text',
            width: 300,
            confirmButtonText: 'Aceptar',
            showCancelButton: true,
        }).then((result) => {

            if (result.value) {
                
                cantidad = result.value;

                var idx = table.row($(this).parents('tr')).index();

                table.cell(idx, 5).data(cantidad + ' Kg(s)').draw();

                NuevoPrecio = ((parseFloat(data['cantidad']) * data['precio_venta_producto'].replace("$ ", "")).toFixed(2));
                NuevoPrecio = "$ " + NuevoPrecio;

                table.cell(idx, 7).data(NuevoPrecio).draw();

                recalcularTotales();
            }
        });

    });

/* ======================================================================================
    EVENTO PARA MODIFICAR EL PRECIO DE VENTA DEL PRODUCTO
======================================================================================*/
$('#lstProductosVenta tbody').on('click', '.dropdown-item', function() { 
    codigo_producto = $(this).attr("codigo");
    precio_venta = parseFloat($(this).attr("precio").replaceAll("$ ","")).toFixed(2);
    
    recalcularMontos(codigo_producto,precio_venta);
});

/* =======================================================================================
EVENTO QUE PERMITE CHECKEAR EL EFECTIVO CUANDO ES EXACTO
=========================================================================================*/
$("#chkEfectivoExacto").change(function() {

    if ($("#chkEfectivoExacto").is(':checked')) {

        var vuelto = 0;
        var totalVenta = $("#totalVenta").html();

        $("#iptEfectivoRecibido").val(totalVenta);

        $("#EfectivoEntregado").html(totalVenta);

        var EfectivoRecibido = parseFloat($("#EfectivoEntregado").html().replace("$ ", ""));

        vuelto = parseFloat(totalVenta) - parseFloat(EfectivoRecibido);

        $("#Vuelto").html(vuelto.toFixed(2));
        
    } else {
        
        $("#iptEfectivoRecibido").val("")
        $("#EfectivoEntregado").html("0.00");
        $("#Vuelto").html("0.00");

    }
})

/* ======================================================================================
EVENTO QUE SE DISPARA AL DIGITAR EL MONTO EN EFECTIVO ENTREGADO POR EL CLIENTE
=========================================================================================*/
$("#iptEfectivoRecibido").keyup(function() {
    actualizarVuelto();
});

/* ======================================================================================
    EVENTO PARA INICIAR EL REGISTRO DE LA VENTA
====================================================================================== */
$("#btnIniciarVenta").on('click', function() {
    realizarVenta();
})



function recalcularMontos(codigo_producto, precio_venta){

    table.rows().eq(0).each(function(index) {

        var row = table.row(index);

        var data = row.data();

        if (data['codigo_producto'] == codigo_producto) {
        
            // AUMENTAR EN 1 EL VALOR DE LA CANTIDAD
            table.cell(index, 6).data("$ " + parseFloat(precio_venta).toFixed(2)).draw();

            // ACTUALIZAR EL NUEVO PRECIO DEL ITEM DEL LISTADO DE VENTA
            NuevoPrecio = (parseFloat(data['cantidad']) * data['precio_venta_producto'].replaceAll("$ ", "")).toFixed(2);
            NuevoPrecio = "$ " + NuevoPrecio;
            table.cell(index, 7).data(NuevoPrecio).draw();

        }

    });

    // RECALCULAMOS TOTALES
    recalcularTotales();

}    

/*===================================================================*/
    //FUNCION PARA RECALCULAR LOS TOTALES DE VENTA
/*===================================================================*/
function recalcularTotales(){

    var TotalVenta = 0.00;
    var totalIVA = 0.00;
    var cantidad=0;

    table.rows().eq(0).each(function(index) {

        var row = table.row(index);
        var data = row.data();

        //console.log("total "+data['valorImpuesto']);
        //console.log("totalVenta "+TotalVenta);
        
        TotalVenta = parseFloat(TotalVenta) + parseFloat(data['total'].replace("$ ", ""));
        totalIVA= parseFloat(totalIVA) + parseFloat(data['valorImpuesto'].replace("$ ", ""));
        cantidad = parseInt(data['cantidad']);

    });

    $("#totalVenta").html("");
    $("#totalVenta").html(TotalVenta.toFixed(2));

    var totalVenta = $("#totalVenta").html();
    //var iva = parseFloat(totalVenta) * 0.18
    var iva = totalIVA*cantidad;
    //console.log(iva);
    var subtotal = parseFloat(totalVenta) - parseFloat(iva);

    $("#totalVentaRegistrar").html(totalVenta);

    $("#boleta_subtotal").html(parseFloat(subtotal).toFixed(2));
    $("#boleta_igv").html(parseFloat(iva).toFixed(2));
    $("#boleta_total").html(parseFloat(totalVenta).toFixed(2));

    //limpiamos el input de efectivo exacto; desmarcamos el check de efectivo exacto
    //borramos los datos de efectivo entregado y vuelto
    $("#iptEfectivoRecibido").val("");
    $("#chkEfectivoExacto").prop('checked', false);
    $("#EfectivoEntregado").html("0.00");
    $("#Vuelto").html("0.00");

    $("#iptCodigoVenta").val("");
    $("#iptCodigoVenta").focus();
}

/*===================================================================*/
    //FUNCION PARA CARGAR PRODUCTOS EN EL DATATABLE
/*===================================================================*/
function CargarProductos(producto = "") {
    if (producto != "") {
        var codigo_producto = producto;
        
    } else {
        var codigo_producto = $("#iptCodigoVenta").val();
    }

    var producto_repetido = 0;

    /*===================================================================*/
    // AUMENTAMOS LA CANTIDAD SI EL PRODUCTO YA EXISTE EN EL LISTADO
    /*===================================================================*/

    table.rows().eq(0).each(function(index) {
        var row = table.row(index);
        var data = row.data();

        if (parseInt(codigo_producto) == data['codigo_producto']) {
            
            producto_repetido = 1;

            $.ajax({
                    async: false,
                    url: "funciones/paginaFuncionesCaja.php",
                    method: "POST",
                    data: {
                        'funcion': 8,
                        'codigo_producto': data['codigo_producto'],
                        'cantidad_a_comprar': data['cantidad']
                    },
                    dataType: 'json',
                    success: function(respuesta) {

                        if (parseInt(respuesta['existe']) == 0) {

                            return Swal.fire(" El producto " + data['descripcion_producto'] + " ya no tiene stock","error");

                            $("#iptCodigoVenta").val("");
                            $("#iptCodigoVenta").focus();

                        } else {

                            // AUMENTAR EN 1 EL VALOR DE LA CANTIDAD
                            table.cell(index, 5).data(parseFloat(data['cantidad']) + 1 + ' Und(s)').draw();

                            // ACTUALIZAR EL NUEVO PRECIO DEL ITEM DEL LISTADO DE VENTA
                            NuevoPrecio = (parseInt(data['cantidad']) * data['precio_venta_producto'].replace("$ ", "")).toFixed(2);
                            NuevoPrecio = "$ " + NuevoPrecio;
                            table.cell(index, 7).data(NuevoPrecio).draw();

                            // RECALCULAMOS TOTALES
                            recalcularTotales();
                        }
                    }
                });
        }
    });

    if(producto_repetido == 1){
        return;   
    } 

    $.ajax({
        url: "funciones/paginaFuncionesCaja.php",
        method: "POST",
        data: {
            'funcion': 7, //BUSCAR PRODUCTOS POR SU CODIGO DE BARRAS
            'codigo_producto': codigo_producto
        },
        dataType: 'json',
        success: function(respuesta) {
            //console.log(respuesta);
            /*===================================================================*/
            //SI LA RESPUESTA ES VERDADERO, TRAE ALGUN DATO
            /*===================================================================*/
            if (respuesta) {

                var TotalVenta = 0.00;
                //console.log(respuesta['aplica_peso']);

                if (respuesta['aplica_peso'] == 1) {
                
                    table.row.add({
                        //'id': itemProducto,
                        'id': respuesta['id'],
                        'codigo_producto': respuesta['codigo_producto'],
                        'id_categoria': respuesta['id_categoria'],
                        'nombre_categoria': respuesta['nombre_categoria'],
                        'descripcion_producto': respuesta['descripcion_producto'],
                        'cantidad': respuesta['cantidad'] + ' Kg(s)',
                        'precio_venta_producto': respuesta['precio_venta_producto'],
                        'total' : respuesta['total'],
                        'acciones': "<center>" +
                                        "<span class='btnIngresarPeso text-success px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Aumentar Stock'> " +
                                        "<i class='fas fa-balance-scale fs-5'></i> " +
                                        "</span> " +
                                        "<span class='btnEliminarproducto text-danger px-1'style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Eliminar producto'> " +
                                        "<i class='fas fa-trash fs-5'> </i> " +
                                        "</span>" +
                                        "<div class='btn-group'>" +
                                            "<button type='button' class=' p-0 btn btn-primary transparentbar dropdown-toggle btn-sm' data-toggle='dropdown'>" +
                                            "<i class='fas fa-cog text-primary fs-5'></i> <i class='fas fa-chevron-down text-primary'></i>" +
                                            "</button>" +
                                            "<ul class='dropdown-menu' role='menu'>" +
                                                "<li><a class='dropdown-item' codigo = '" + respuesta['codigo_producto'] + "' precio=' " + respuesta['precio_venta_producto'] + "' style='cursor:pointer; font-size:12px;'>Normal (" + respuesta['precio_venta_producto'] + ")</a></li>" +
                                                "<li><a class='dropdown-item' codigo = '" + respuesta['codigo_producto'] + "' precio=' " + respuesta['precio_mayor_producto'] + "' style='cursor:pointer; font-size:12px;'>Por Mayor ($ " + parseFloat(respuesta['precio_mayor_producto']).toFixed(2) + ")</a></li>" +
                                                "<li><a class='dropdown-item' codigo = '" + respuesta['codigo_producto'] + "' precio=' " + respuesta['precio_oferta_producto'] + "' style='cursor:pointer; font-size:12px;'>Oferta ($ " + parseFloat(respuesta['precio_oferta_producto']).toFixed(2) + ")</a></li>" +
                                            "</ul>" +
                                        "</div>" +
                                    "</center>",
                        'aplica_peso': respuesta['aplica_peso'],
                        'precio_mayor_producto': respuesta['precio_mayor_producto'],
                        'precio_oferta_producto': respuesta['precio_oferta_producto'],
                        'valorImpuesto':respuesta['valorImpuesto']
                    }).draw();

                    itemProducto = itemProducto + 1;

                } else {

                    table.row.add({
                        //'id': itemProducto,
                        'id': respuesta['id'],
                        'codigo_producto': respuesta['codigo_producto'],
                        'id_categoria': respuesta['id_categoria'],
                        'nombre_categoria': respuesta['nombre_categoria'],
                        'descripcion_producto': respuesta['descripcion_producto'],
                        'cantidad': respuesta['cantidad'] + ' Und(s)',
                        'precio_venta_producto': respuesta['precio_venta_producto'],
                        'total' : respuesta['total'],
                        'acciones': "<center>" +
                                        "<span class='btnAumentarCantidad text-success px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Aumentar Stock'> " +
                                        "<i class='fas fa-cart-plus fs-5'></i> " +
                                        "</span> " +
                                        "<span class='btnDisminuirCantidad text-warning px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Disminuir Stock'> " +
                                        "<i class='fas fa-cart-arrow-down fs-5'></i> " +
                                        "</span> " +
                                        "<span class='btnEliminarproducto text-danger px-1'style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Eliminar producto'> " +
                                        "<i class='fas fa-trash fs-5'> </i> " +
                                        "</span>"+
                                        "<div class='btn-group'>" +
                                            "<button type='button' class=' p-0 btn btn-primary transparentbar dropdown-toggle btn-sm' data-toggle='dropdown' aria-expanded='false'>" +
                                                "<i class='fas fa-cog text-primary fs-5'></i> <i class='fas fa-chevron-down text-primary'></i>" +
                                            "</button>" +
                                            "<ul class='dropdown-menu' role='menu'>" +
                                                "<li><a class='dropdown-item' codigo = '" + respuesta['codigo_producto'] + "' precio=' " + respuesta['precio_venta_producto'] + "' style='cursor:pointer; font-size:12px;'>Normal (" + respuesta['precio_venta_producto'] + ")</a></li>" +
                                                "<li><a class='dropdown-item' codigo = '" + respuesta['codigo_producto'] + "' precio=' " + respuesta['precio_mayor_producto'] + "' style='cursor:pointer; font-size:12px;'>Por Mayor ($ " + parseFloat(respuesta['precio_mayor_producto']).toFixed(2) + ")</a></li>" +
                                                "<li><a class='dropdown-item' codigo = '" + respuesta['codigo_producto'] + "' precio=' " + respuesta['precio_oferta_producto'] + "' style='cursor:pointer; font-size:12px;'>Oferta ($ " + parseFloat(respuesta['precio_oferta_producto']).toFixed(2) + ")</a></li>" +
                                            "</ul>" +
                                        "</div>" +
                                    "</center>",
                        'aplica_peso': respuesta['aplica_peso'],
                        'precio_mayor_producto': respuesta['precio_mayor_producto'],
                        'precio_oferta_producto': respuesta['precio_oferta_producto'],
                        'valorImpuesto':respuesta['valorImpuesto']
                    }).draw();

                    itemProducto = itemProducto + 1;

                }

                //  Recalculamos el total de la venta
                recalcularTotales();

            /*===================================================================*/
            //SI LA RESPUESTA ES FALSO, NO TRAE ALGUN DATO
            /*===================================================================*/
            } else {
                
                return Swal.fire(" El producto no existe o no tiene stock","error");

                $("#iptCodigoVenta").val("");
                $("#iptCodigoVenta").focus();
            }

        }
    }); 

}

/*===================================================================*/
    //FUNCION PARA CARGAR EL NRO DE BOLETA
/*===================================================================*/
function CargarNroBoleta() {
    
    $.ajax({
        async: false,
        url: "funciones/paginaFuncionesCaja.php",
        method: "POST",
        data: {
            'funcion': 1
        },
        dataType: 'json',
        success: function(respuesta) {
        
            serie_boleta = respuesta["serie_boleta"];
            nro_boleta = respuesta["nro_venta"];

            $("#iptNroSerie").val(serie_boleta);
            $("#iptNroVenta").val(nro_boleta);
        }
    });
}

/*===================================================================*/
    //FUNCION PARA LIMPIAR TOTALMENTE EL CARRITO DE VENTAS
/*===================================================================*/
function vaciarListado() {
    table.clear().draw();
    LimpiarInputs();
}

/*===================================================================*/
    //FUNCION PARA LIMPIAR LOS INPUTS DE LA BOLETA Y LABELS QUE TIENEN DATOS
/*===================================================================*/
function LimpiarInputs() {
    $("#totalVenta").html("0.00");
    $("#totalVentaRegistrar").html("0.00");
    $("#boleta_total").html("0.00");
    $("#iptEfectivoRecibido").val("");
    $("#EfectivoEntregado").html("0.00");
    $("#Vuelto").html("0.00");
    $("#chkEfectivoExacto").prop('checked', false);
    $("#boleta_subtotal").html("0.00");
    $("#boleta_igv").html("0.00")
}/* FIN LimpiarInputs */

/*===================================================================*/
    //FUNCION PARA ACTUALIZAR EL VUELTO
/*===================================================================*/
function actualizarVuelto(){
        
    var totalVenta = $("#totalVenta").html();        

    $("#chkEfectivoExacto").prop('checked', false);

    var efectivoRecibido = $("#iptEfectivoRecibido").val();
    
    if (efectivoRecibido > 0) {

        $("#EfectivoEntregado").html(parseFloat(efectivoRecibido).toFixed(2));

        vuelto = parseFloat(efectivoRecibido) - parseFloat(totalVenta);

        $("#Vuelto").html(vuelto.toFixed(2));
      
    } else {

        $("#EfectivoEntregado").html("0.00");
        $("#Vuelto").html("0.00");
    }
}

/*===================================================================*/
    //REALIZAR LA VENTA
/*===================================================================*/
function realizarVenta(){
    
    var count = 0;
    var totalVenta = $("#totalVenta").html();
    var nro_boleta = $("#iptNroVenta").val();
    var subTotal = $("#boleta_igv").html();
    var ivaTotal = $("#boleta_igv").html();
    //var iva = $("#boleta_igv").html(parseFloat(iva).toFixed(2));

    //$("#boleta_subtotal").html(parseFloat(subtotal).toFixed(2));
    //$("#boleta_igv").html(parseFloat(iva).toFixed(2));
    //$("#boleta_total").html(parseFloat(totalVenta).toFixed(2));

    table.rows().eq(0).each(function(index) {
        count = count + 1;
    });

    if (count > 0) {
        
        if ($("#iptEfectivoRecibido").val() > 0 && $("#iptEfectivoRecibido").val() != "") {

            if ($("#iptEfectivoRecibido").val() < parseFloat(totalVenta)) {

                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'El efectivo es menor al costo total de la venta.',
                  });
            }

            var formData = new FormData();
            var arr = [];
            var aux='';
            var arrProductos='';

            table.rows().eq(0).each(function(index) {
        
                var row = table.row(index);

                var data = row.data();

                aux='{"codigo_producto":"'+data['codigo_producto']+'","cantidad":"'+data['cantidad']+'","total":"'+data['total'].replace("$ ", "")+'","valorImpuesto":"'+data['valorImpuesto'].replace("$ ", "")+'","precio_venta_producto":"'+data['precio_venta_producto'].replace("$ ", "")+'","idProducto":"'+data['id']+'"}';
                
                if(arrProductos=='')
                {
                    arrProductos=aux;
                }
                else
                {
                    arrProductos+=','+aux
                }

            });

            var cadObj='{"nro_boleta":"'+nro_boleta+'","total_venta":"'+parseFloat(totalVenta)+'","subtotal":"'+parseFloat(subTotal)+'","ivaTotal":"'+parseFloat(ivaTotal)+'","arrProductos":['+arrProductos+']}';

            function funcAjax()
            {
                var resp=peticion_http.responseText;
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
                    table.clear().draw();
                        
                    LimpiarInputs();

                    CargarNroBoleta();
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('funciones/paginaFuncionesCaja.php',funcAjax, 'POST','funcion=2&cadObj='+cadObj,true);
        }
        else{
            Swal.fire('Debe Ingresar el importe en efectivo');
            $("#iptEfectivoRecibido").focus();
        }
    }
    else{
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'No hay productos en el listado.',
            showConfirmButton: false,
            timer: 1500
          });
    }

    $("#iptCodigoVenta").focus();

}/* FIN realizarVenta */
    



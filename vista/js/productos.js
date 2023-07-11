var table;
function listarProductos() {
    table = $("#tbl_productos").DataTable({
        dom: 'Bfrtip', //Muestra los botones para imprimir en Buttons
        buttons: [
            {
                text: 'Agregar Producto',
                className: 'addNewRecord',
                action: function ( e, dt, node, config ){
                    abrirModuloRegistro();
                }
            },
            'excel','pdf','print','pageLength'
        ],
        ordering: false,
        bLengthChange: true,
        searching: { regex: true },
        lengthMenu: [
          [10, 25, 50, 100, -1],
          [10, 25, 50, 100, "All"],
        ],
        pageLength: 10,
        destroy: true,
        async: false,
        processing: true,
        ajax: {
          url: "funciones/paginaFunciones.php",
          type: "POST",
          data:{
              funcion: "5"
          }
        },
        columns: [
            { data: "" },
            { data: "id" },
            { data: "codigo" },
            { data: "categoria" },
            { data: "producto" },   
            { data: "precioVenta" },
            { data: "utilidad" },
            { data: "stockMax" },
            { data: "stockMin" },
            { data: "stock_producto" },
            { data: "situacion", 
                render: function (data, type, row) {
                    if (data == "1") {
                    return "<span class='badge bg-success'>ACTIVO</span>";
                    } else {
                    return "<span class='badge bg-danger'>INACTIVO</span>";
                    }
                },
            },
            { data: "" }
        ],
        responsive: {
                detalls:{
                    type: 'column'
                }
        },
        columnDefs:[
                {
                    targets:0,
                    orderable: false,
                    className:'control'
                },
                {
                    targets:11,
                    orderable: false,
                    render: function(data,type,meta){
                        return "<center>"+
                                "<span class='btEditarProducto text-primary px-1' style='cursor:pointer;'>" +
                                    "<i class='fas fa-pencil-alt fs-5'></i>"+
                                "</span>"+
                        "</center>"
                    }
                }
        ],
    
        language: idioma_espanol,
        select: true,
        
    });

}

$("#tbl_productos").on("click", ".btEditarProducto", function () {
    var data = table.row($(this).parents("tr")).data();
  
    if (table.row(this).child.isShown()) {
      var data = table.row(this).data();
    }

    $("#modal_modificar_productos").modal({ backdrop: "static", keyboard: false });
    $("#modal_modificar_productos").modal("show");
    
     $("#txtIdProducto").val(data.id);
     $("#txt_codigoBarra_modifi").val(data.codigo);
     $("#txt_categoria_modifi").val(data.idCategoria);
     $("#txt_impuesto_modifi").val(data.idImpuesto);
     $("#txt_producto_modifi").val(data.producto);
     $("#txt_precioCompra_modifi").val(data.precioCompra);
     $("#txt_precioVenta_modifi").val(data.precioVenta);
     $("#txt_utilidad_modifi").val(data.utilidad);
     $("#txt_stockMaximo_modifi").val(data.stockMax);
     $("#txt_stockMinimo_modifi").val(data.stockMin);
     $("#txt_existencia_modifi").val(data.stock_producto);
     $("#txt_Situacion").val(data.situacion);
    
});

/*FUNCION PARA CAMBIAR EL ESTADO DE ALMACEN DESACTIVAR*/
$("#tbl_productos").on("click", ".btEliminarProducto", function () {
    var data = table.row($(this).parents("tr")).data();
  
    if (table.row(this).child.isShown()) {
      var data = table.row(this).data();
    }
  
    Swal.fire({
      title: "¿Esta seguro de querer Eliminar el Producto?",
      text: "Una vez hecho esto el usuario no podrá visualizarlo",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si",
    }).then((result) => {
      if (result.value) {
        modificarEstatusProducto(data.id, "0");
      }
    });
});

function abrirModuloRegistro()
{
    $("#modal_registro").modal({ backdrop: "static", keyboard: false });
    $("#modal_registro").modal("show");
}

function registrar_producto()
{
    var codBar=$("#txt_codigoBarra").val();
    var idCategoria=$("#txt_categoria").val();
    var idImpuesto=$("#txt_impuesto").val();
    var producto=$("#txt_producto").val();
    var precioCompra=$("#txt_precioCompra").val();
    var precioVenta=$("#txt_precioVenta").val();
    var utilidad=$("#txt_utilidad").val();
    var stockMaximo=$("#txt_stockMaximo").val();
    var stockMinimo=$("#txt_stockMinimo").val();

    if(codBar.length==0 || idCategoria==-1 || idImpuesto==-1 || producto.length==0 || precioCompra.length==0 || precioVenta.length==0 || stockMaximo.length==0 || stockMinimo.length==0)
    {
        return Swal.fire("Mensaje De Advertencia","Los campos marcados con * son obligatorios","warning");
    }

    var cadObj='{"codBar":"'+codBar+'","idCategoria":"'+idCategoria+'","idImpuesto":"'+idImpuesto+'","producto":"'+producto+'","precioCompra":"'+precioCompra+'","precioVenta":"'+precioVenta+'","utilidad":"'+utilidad+'","stockMaximo":"'+stockMaximo+'","stockMinimo":"'+stockMinimo+'"}';

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_registro").modal('hide');
            Swal.fire("Mensaje De Confirmacion","Datos correctos, Nuevo Producto Registrado","success") 
            listarProductos();  
            limpiarCamposModalRegistro();         
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFunciones.php',funcAjax, 'POST','funcion=6&cadObj='+cadObj,true) 
    
}

function limpiarCamposModalRegistro()
{
    $("#txt_codigoBarra").val('');
    $("#txt_categoria").val(-1);
    $("#txt_impuesto").val(-1);
    $("#txt_producto").val('');
    $("#txt_precioCompra").val('');
    $("#txt_precioVenta").val('');
    $("#txt_utilidad").val('');
    $("#txt_stockMaximo").val('');
    $("#txt_stockMinimo").val('');
}

function calcularUtilidadProducto(tipo)
{
    if(tipo==1)
    {
        var iptPrecioCompraReg = $("#txt_precioCompra").val();
        var iptPrecioVentaReg = $("#txt_precioVenta").val();
    
        if(iptPrecioCompraReg>iptPrecioVentaReg)
        {
            return Swal.fire("Mensaje De Advertencia","El precio de compra no puede ser mayor al Precio de Venta","warning");
        }
        var Utilidad = iptPrecioVentaReg - iptPrecioCompraReg;
    
        $("#txt_utilidad").val(Utilidad.toFixed(2));
    }
    else{
        var iptPrecioCompraReg = $("#txt_precioCompra_modifi").val();
        var iptPrecioVentaReg = $("#txt_precioVenta_modifi").val();
    
        if(iptPrecioCompraReg>iptPrecioVentaReg)
        {
            return Swal.fire("Mensaje De Advertencia","El precio de compra no puede ser mayor al Precio de Venta","warning");
        }
        var Utilidad = iptPrecioVentaReg - iptPrecioCompraReg;
    
        $("#txt_utilidad_modifi").val(Utilidad.toFixed(2));
    }
    
}

function Modificar_producto()
{
    var idProducto=$("#txtIdProducto").val();
    var codBar=$("#txt_codigoBarra_modifi").val();
    var idCategoria=$("#txt_categoria_modifi").val();
    var idImpuesto=$("#txt_impuesto_modifi").val();
    var producto=$("#txt_producto_modifi").val();
    var precioCompra=$("#txt_precioCompra_modifi").val();
    var precioVenta=$("#txt_precioVenta_modifi").val();
    var utilidad=$("#txt_utilidad_modifi").val();
    var stockMaximo=$("#txt_stockMaximo_modifi").val();
    var stockMinimo=$("#txt_stockMinimo_modifi").val();
    var stockMinimo=$("#txt_stockMinimo_modifi").val();
    var situacion=$("#txt_Situacion").val();
    

    if(codBar.length==0 || idCategoria==-1 || idImpuesto==-1 || producto.length==0 || precioCompra.length==0 || precioVenta.length==0 || stockMaximo.length==0 || stockMinimo.length==0 || situacion==-1)
    {
        return Swal.fire("Mensaje De Advertencia","Los campos marcados con * son obligatorios","warning");
    }

    var cadObj='{"codBar":"'+codBar+'","idCategoria":"'+idCategoria+'","idImpuesto":"'+idImpuesto+'","producto":"'+producto+'","precioCompra":"'+precioCompra+'","precioVenta":"'+precioVenta+'","utilidad":"'+utilidad+'","stockMaximo":"'+stockMaximo+'","stockMinimo":"'+stockMinimo+'","idProducto":"'+idProducto+'","situacion":"'+situacion+'"}';

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_modificar_productos").modal('hide');
            Swal.fire("Mensaje De Confirmacion","Datos correctos, Producto Modificado","success") 
            listarProductos();  
     
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFunciones.php',funcAjax, 'POST','funcion=7&cadObj='+cadObj,true) 
}

function  modificarEstatusProducto(id,estado)
{
    var mensaje = "";
  var idProducto = id;

  if (estado == "0") {
    mensaje = "Inactivo";
  } else {
    mensaje = "Activo";
  }

  var cadObj = '{"idProducto":"' + idProducto + '","estado":"' + estado + '"}';

  function funcAjax() {
    var resp = peticion_http.responseText;
    arrResp = resp.split("|");
    if (arrResp[0] == "1") {
        listarProductos();
      Swal.fire("Mensaje De Confirmacion","El Producto se " + mensaje + " con exito","success");
    } else {
      Swal.fire("Mensaje De Error","Lo sentimos, no se pudo modificar el registro","error");
    }
  }
  obtenerDatosWeb(
    "funciones/paginaFunciones.php",funcAjax,"POST","funcion=8&cadObj=" + cadObj,true);
}

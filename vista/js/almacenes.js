var table;
function listarAlmacenes() {
    table = $("#tbl_almacenes").DataTable({
        dom: 'Bfrtip', //Muestra los botones para imprimir en Buttons
        buttons: [
            {
                text: 'Agregar Almacen',
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
          url: "funciones/paginaFuncionesAlmacenes.php",
          type: "POST",
          data:{
              funcion: "1"
          }
        },
        columns: [
            { data: "" },
            { data: "id" },
            { data: "nombreAlmacen" },
            { data: "situacion", 
                render: function (data, type, row) {
                    if (data == "1") {
                    return "<span class='badge bg-success'>ACTIVO</span>";
                    } else {
                    return "<span class='badge bg-danger'>INACTIVO</span>";
                    }
                }
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
                    targets:4,
                    orderable: false,
                    render: function(data,type,meta){
                        return "<center>"+
                                    "<span class='btEditar text-primary px-1' style='cursor:pointer;'>" +
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

$("#tbl_almacenes").on("click", ".btEditar", function () {
    var data = table.row($(this).parents("tr")).data();
  
    if (table.row(this).child.isShown()) {
      var data = table.row(this).data();
    }

    $("#modal_registro_modificar").modal({ backdrop: "static", keyboard: false });
    $("#modal_registro_modificar").modal("show");
    
    $("#txtIdAlmacen").val(data.id);
    $("#txt_nomAlmacen_modifi").val(data.nombreAlmacen);
    $("#txt_descripcion_modifi").val(data.descripcion);
    $("#txt_Situacion").val(data.situacion);
    
});

/*FUNCION PARA CAMBIAR EL ESTADO DE ALMACEN DESACTIVAR*/
$("#tbl_almacenes").on("click", ".btEliminar", function () {
    var data = table.row($(this).parents("tr")).data();
  
    if (table.row(this).child.isShown()) {
      var data = table.row(this).data();
    }
  
    Swal.fire({
      title: "¿Esta seguro de querer Eliminar el Almacen?",
      text: "Una vez hecho esto el usuario no podrá visualizarlo",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si",
    }).then((result) => {
      if (result.value) {
        modificarEstatusAlmacen(data.id, "0");
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
    var nomAlmacen=$("#txt_nomAlmacen").val();
    var descripcion=$("#txt_descripcion").val();

    if(nomAlmacen.length==0)
    {
        return Swal.fire("Mensaje De Advertencia","Los campos marcados con * son obligatorios","warning");
    }

    var cadObj='{"nomAlmacen":"'+nomAlmacen+'","descripcion":"'+descripcion+'"}';

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_registro").modal('hide');
            Swal.fire("Mensaje De Confirmacion","Datos correctos, Nuevo Almacen Registrado","success") 
            listarAlmacenes();  
            limpiarCamposModalRegistro();         
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFuncionesAlmacenes.php',funcAjax, 'POST','funcion=2&cadObj='+cadObj,true) 
    
}

function limpiarCamposModalRegistro()
{
    $("#txt_nomAlmacen").val('');
    $("#txt_descripcion").val('');
}

function modificar_producto()
{
    var txtIdAlmacen=$("#txtIdAlmacen").val();
    var nomAlmacen=$("#txt_nomAlmacen_modifi").val();
    var descripcion=$("#txt_descripcion_modifi").val();
    var situacion=$("#txt_Situacion").val();

    if(nomAlmacen.length==0 || situacion==-1)
    {
        return Swal.fire("Mensaje De Advertencia","Los campos marcados con * son obligatorios","warning");
    }

    var cadObj='{"nomAlmacen":"'+nomAlmacen+'","descripcion":"'+descripcion+'","txtIdAlmacen":"'+txtIdAlmacen+'","situacion":"'+situacion+'"}';

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_registro_modificar").modal('hide');
            Swal.fire("Mensaje De Confirmacion","Datos correctos, Almacen modificado","success") 
            listarAlmacenes();  
            limpiarCamposModalRegistro();         
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFuncionesAlmacenes.php',funcAjax, 'POST','funcion=3&cadObj='+cadObj,true) 
}

function modificarEstatusAlmacen(id, estado)
{
    var mensaje = "";
    var idAlmacen = id;

    if (estado == "0") {
        mensaje = "Inactivo";
    } else {
        mensaje = "Activo";
    }

    var cadObj = '{"idAlmacen":"' + idAlmacen + '","estado":"' + estado + '"}';

    function funcAjax() {
        var resp = peticion_http.responseText;
        arrResp = resp.split("|");
        if (arrResp[0] == "1") {
            listarProductos();
        Swal.fire("Mensaje De Confirmacion","El Almacen se " + mensaje + " con exito","success");
        } else {
        Swal.fire("Mensaje De Error","Lo sentimos, no se pudo modificar el registro","error");
        }
    }
    obtenerDatosWeb(
        "funciones/paginaFunciones.php",funcAjax,"POST","funcion=4&cadObj=" + cadObj,true);
}
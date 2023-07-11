var table;
function listarServicios() {
    table = $("#tbl_servicios").DataTable({
        dom: 'Bfrtip', //Muestra los botones para imprimir en Buttons
        buttons: [
            {
                text: 'Agregar Servicio',
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
          url: "funciones/paginaFuncionesServicios.php",
          type: "POST",
          data:{
              funcion: "1"
          }
        },
        columns: [
            { data: "" },
            { data: "id" },
            { data: "nombreServicio" },
            { data: "textIVA" }, 
            { data: "costoServicioRender" }, 
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
                    targets:6,
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

function abrirModuloRegistro()
{
    $("#modal_registro_servicio").modal({ backdrop: "static", keyboard: false });
    $("#modal_registro_servicio").modal("show");
}

function registrar_servicio()
{
    var nombreServicio=$("#txt_nomServicio").val();
    var impuesto=$("#cmb_impuesto").val();
    var precio=$("#txt_precio").val();
    var descripcion=$("#txt_descripcion").val();

    if(nombreServicio.length==0 || impuesto==-1 || precio.length==0)
    {
        return Swal.fire("Mensaje De Advertencia","Los campos marcados con * son obligatorios","warning");
    }


    var cadObj='{"nombreServicio":"'+nombreServicio+'","impuesto":"'+impuesto+'","precio":"'+precio+'","descripcion":"'+descripcion+'"}';

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_registro_servicio").modal('hide');
            Swal.fire("Mensaje De Confirmacion","Datos correctos, Nuevo Servicio Registrado","success") 
            listarServicios();  
            limpiarCamposModalRegistro();         
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFuncionesServicios.php',funcAjax, 'POST','funcion=2&cadObj='+cadObj,true) 
}

$("#tbl_servicios").on("click", ".btEditar", function () {
    var data = table.row($(this).parents("tr")).data();
  
    if (table.row(this).child.isShown()) {
      var data = table.row(this).data();
    }

    $("#modal_modificacion_servicio").modal({ backdrop: "static", keyboard: false });
    $("#modal_modificacion_servicio").modal("show");
    
    $("#txtServicio").val(data.id);
    $("#txt_nomServicio_modificar").val(data.nombreServicio);
    $("#cmb_impuesto_modificar").val(data.valorIVA);
    $("#txt_precio_modificar").val(data.costoServicio);
    $("#txt_descripcion_modificar").val(data.descripcion);
    $("#txt_Situacion").val(data.situacion);
    
});

function modificar_servicio()
{
    var nombreServicio=$("#txt_nomServicio_modificar").val();
    var impuesto=$("#cmb_impuesto_modificar").val();
    var precio=$("#txt_precio_modificar").val();
    var descripcion=$("#txt_descripcion_modificar").val();
    var situacion=$("#txt_Situacion").val();
    var idServicio=$("#txtServicio").val();

    if(nombreServicio.length==0 || impuesto==-1 || precio.length==0 || situacion==-1)
    {
        return Swal.fire("Mensaje De Advertencia","Los campos marcados con * son obligatorios","warning");
    }

    var cadObj='{"nombreServicio":"'+nombreServicio+'","impuesto":"'+impuesto+'","precio":"'+precio+'","descripcion":"'+descripcion+'","situacion":"'+situacion+'","idServicio":"'+idServicio+'"}';

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_modificacion_servicio").modal('hide');
            Swal.fire("Mensaje De Confirmacion","Datos correctos, Servicio Modificado","success") 
            listarServicios();  
                
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFuncionesServicios.php',funcAjax, 'POST','funcion=3&cadObj='+cadObj,true) 

}

function limpiarCamposModalRegistro()
{
    $("#txt_nomServicio").val('');
    $("#cmb_impuesto").val('-1');
    $("#txt_precio").val('');
    $("#txt_descripcion").val('');
}
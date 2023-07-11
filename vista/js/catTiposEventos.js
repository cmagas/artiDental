var table;
function listarTipoEventos() {
    table = $("#tbl_tipo_eventos").DataTable({
        dom: 'Bfrtip', //Muestra los botones para imprimir en Buttons
        buttons: [
            {
                text: 'Agregar Tipo',
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
          url: "funciones/paginaFuncionesTipoEvento.php",
          type: "POST",
          data:{
              funcion: "1"
          }
        },
        columns: [
            { data: "" },
            { data: "id" },
            { data: "nombreTipoEvento" },
            { data: "claseColor" },
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
                    targets:5,
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

$("#tbl_tipo_eventos").on("click", ".btEditar", function () {
    var data = table.row($(this).parents("tr")).data();
  
    if (table.row(this).child.isShown()) {
      var data = table.row(this).data();
    }

    $("#modal_registro_modificar").modal({ backdrop: "static", keyboard: false });
    $("#modal_registro_modificar").modal("show");
    
    $("#txtIdRegistro").val(data.id);
    $("#txt_nombre_modificar").val(data.nombreTipoEvento);
    $("#txt_descripcion_modificar").val(data.descripcion);
    $("#txt_color_modificar").val(data.claseColor);
    $("#txt_Situacion").val(data.situacion);
    
});


function abrirModuloRegistro()
{
    $("#modal_registro").modal({ backdrop: "static", keyboard: false });
    $("#modal_registro").modal("show");
}

function registrar_tipoEvento()
{
    var nombre=$("#txt_nombre").val();
    var descripcion=$("#txt_descripcion").val();
    var color=$("#txt_color").val();



    if(nombre.length==0 || color.length==0)
    {
        return Swal.fire("Mensaje De Advertencia","Los campos marcados con * son obligatorios","warning");
    }

    var cadObj='{"nombre":"'+nombre+'","descripcion":"'+descripcion+'","color":"'+color+'"}';

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_registro").modal('hide');
            Swal.fire("Mensaje De Confirmacion","Datos correctos, Nuevo Almacen Registrado","success") 
            listarTipoEventos();  
            limpiarCamposModalRegistro();         
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFuncionesTipoEvento.php',funcAjax, 'POST','funcion=2&cadObj='+cadObj,true) 
    
}

function modificar_tipoEvento()
{
    var idRegistro=$("#txtIdRegistro").val();
    var nombreTipo=$("#txt_nombre_modificar").val();
    var descripcion=$("#txt_descripcion_modificar").val();
    var color=$("#txt_color_modificar").val();
    var situacion=$("#txt_Situacion").val();
    

    if(nombreTipo.length==0 || color.length==0 || situacion==-1)
    {
        return Swal.fire("Mensaje De Advertencia","Los campos marcados con * son obligatorios","warning");
    }

    var cadObj='{"nombreTipo":"'+nombreTipo+'","descripcion":"'+descripcion+'","color":"'+color+'","idRegistro":"'+idRegistro+'","situacion":"'+situacion+'"}';

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_registro_modificar").modal('hide');
            Swal.fire("Mensaje De Confirmacion","Datos correctos, Tipo Evento fue modificado","success") 
            listarTipoEventos();  
                    
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFuncionesTipoEvento.php',funcAjax, 'POST','funcion=3&cadObj='+cadObj,true) 
}

function impiarCamposModalRegistro()
{
    $("#txt_nombre").val('');
    $("#txt_descripcion").val('');
}
var table;
function listarTipoConsulta() {
    table = $("#tbl_tipo_consulta").DataTable({
        dom: 'Bfrtip', //Muestra los botones para imprimir en Buttons
        buttons: [
            {
                text: 'Agregar Nuevo Tipo',
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
          url: "funciones/paginaFuncionesTipoConsulta.php",
          type: "POST",
          data:{
              funcion: "1"
          }
        },
        columns: [
            { data: "" },
            { data: "id" },
            { data: "nombreTipo" },
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

function abrirModuloRegistro()
{
    $("#modal_registro").modal({ backdrop: "static", keyboard: false });
    $("#modal_registro").modal("show");
}

$("#tbl_tipo_consulta").on("click", ".btEditar", function () {
    var data = table.row($(this).parents("tr")).data();
  
    if (table.row(this).child.isShown()) {
      var data = table.row(this).data();
    }

    $("#modal_registro_modificar").modal({ backdrop: "static", keyboard: false });
    $("#modal_registro_modificar").modal("show");
    
    $("#txtIdTipo").val(data.id);
    $("#txt_nomTipo_modificar").val(data.nombreTipo);
    $("#txt_descripcion_modificar").val(data.descripcion);
    $("#txt_Situacion").val(data.situacion);
    
});

function registrar_nuevoTipo()
{
    var nombre=$("#txt_nomTipo").val();
    var descripcion=$("#txt_descripcion").val();

    if(nombre.length==0)
    {
        return Swal.fire("Mensaje De Advertencia","Los campos marcados con * son obligatorios","warning");
    }

    var cadObj='{"nombre":"'+nombre+'","descripcion":"'+descripcion+'"}';

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_registro").modal('hide');
            Swal.fire("Mensaje De Confirmacion","Datos correctos, Nuevo Tipo Registrado","success") 
            listarTipoConsulta();  
            limpiarCamposModalRegistro();         
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFuncionesTipoConsulta.php',funcAjax, 'POST','funcion=2&cadObj='+cadObj,true)
}

function modificar_nuevoTipo()
{
    var idTipoConsulta=$("#txtIdTipo").val();
    var nombreTipo=$("#txt_nomTipo_modificar").val();
    var descripcion=$("#txt_descripcion_modificar").val();
    var situacion=$("#txt_Situacion").val();

    if(nombreTipo.length==0 || situacion==-1)
    {
        return Swal.fire("Mensaje De Advertencia","Los campos marcados con * son obligatorios","warning");
    }

    var cadObj='{"nombreTipo":"'+nombreTipo+'","descripcion":"'+descripcion+'","idTipoConsulta":"'+idTipoConsulta+'","situacion":"'+situacion+'"}';

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_registro_modificar").modal('hide');
            Swal.fire("Mensaje De Confirmacion","Datos correctos, Tipo de Consulta modificado","success") 
            listarTipoConsulta();  
            limpiarCamposModalRegistro();         
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFuncionesTipoConsulta.php',funcAjax, 'POST','funcion=3&cadObj='+cadObj,true) 
}

function limpiarCamposModalRegistro()
{
    $("#txt_nomTipo").val('');
    $("#txt_descripcion").val('');
    
}
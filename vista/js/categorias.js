var table;
function listarCategorias() {
    table = $("#tbl_categorias").DataTable({
        dom: 'Bfrtip', //Muestra los botones para imprimir en Buttons
        buttons: [
            {
                text: 'Agregar Categoría',
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
          url: "funciones/paginaFuncionesCategoria.php",
          type: "POST",
          data:{
              funcion: "1"
          }
        },
        columns: [
            { data: "" },
            { data: "id" },
            { data: "nombreCategoria" },
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
                    targets:4,
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

$("#tbl_categorias").on("click", ".btEditarProducto", function () {
    var data = table.row($(this).parents("tr")).data();
  
    if (table.row(this).child.isShown()) {
      var data = table.row(this).data();
    }

    $("#modal_registro_modificar").modal({ backdrop: "static", keyboard: false });
    $("#modal_registro_modificar").modal("show");
    
    $("#txtIdCategoria").val(data.id);
    $("#txt_nomCategoria_modifi").val(data.nombreCategoria);
    $("#txt_descripcion_modifi").val(data.descripcion);
    $("#txt_aplicaPeso_modifi").val(data.aplicaPeso);
    $("#txt_Situacion").val(data.situacion);
    
});

function abrirModuloRegistro()
{
    $("#modal_registro").modal({ backdrop: "static", keyboard: false });
    $("#modal_registro").modal("show");
}

function registrar_Categoria()
{
    var nomCategoria=$("#txt_nomCategoria").val();
    var descripcion=$("#txt_descripcion").val();
    var aplicaPeso=$("#txt_aplicaPeso").val();

    if(nomCategoria.length==0 || aplicaPeso==-1)
    {
        return Swal.fire("Mensaje De Advertencia","Los campos marcados con * son obligatorios","warning");
    }

    var cadObj='{"nomCategoria":"'+nomCategoria+'","descripcion":"'+descripcion+'","aplicaPeso":"'+aplicaPeso+'"}';

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_registro").modal('hide');
            Swal.fire("Mensaje De Confirmacion","Datos correctos, Nueva Categoria Registrada","success") 
            listarCategorias();  
            limpiarCamposModalRegistro();         
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFuncionesCategoria.php',funcAjax, 'POST','funcion=2&cadObj='+cadObj,true) 
    
}

function limpiarCamposModalRegistro()
{
    $("#txt_nomCategoria").val('');
    $("#txt_descripcion").val('');
    $("#txt_aplicaPeso").val(-1);
}

function modificar_Categoria()
{
    var idCategoria=$("#txtIdCategoria").val();
    var nomCategoria=$("#txt_nomCategoria_modifi").val();
    var descripcion=$("#txt_descripcion_modifi").val();
    var aplicaPeso=$("#txt_aplicaPeso_modifi").val();
    var situacion=$("#txt_Situacion").val();

    if(nomCategoria.length==0 || aplicaPeso==-1 || situacion==-1)
    {
        return Swal.fire("Mensaje De Advertencia","Los campos marcados con * son obligatorios","warning");
    }

    var cadObj='{"idCategoria":"'+idCategoria+'","nomCategoria":"'+nomCategoria+'","descripcion":"'+descripcion+'","aplicaPeso":"'+aplicaPeso+'","situacion":"'+situacion+'"}';

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_registro_modificar").modal('hide');
            Swal.fire("Mensaje De Confirmacion","Datos correctos, Categoria modificada","success") 
            listarCategorias();  
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFuncionesCategoria.php',funcAjax, 'POST','funcion=3&cadObj='+cadObj,true) 
}

var table;
function listarModulos() {
    table = $("#tbl_modulos").DataTable({
        dom: 'Bfrtip', //Muestra los botones para imprimir en Buttons
        buttons: [
            {
                text: 'Agregar Modulo',
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
          url: "funciones/paginaFuncionesModulos.php",
          type: "POST",
          data:{
              funcion: "1"
          }
        },
        columns: [
            { data: "" },
            { data: "id" },
            { data: "modulo" },
            { data: "nomModuloPadre" },
            { data: "vista" },   
            { data: "iconoMenu" },
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
                    targets:7,
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

$("#tbl_modulos").on("click", ".btEditar", function () {
    var data = table.row($(this).parents("tr")).data();
  
    if (table.row(this).child.isShown()) {
      var data = table.row(this).data();
    }

    $("#modal_modificar_modulos").modal({ backdrop: "static", keyboard: false });
    $("#modal_modificar_modulos").modal("show");
    
    $("#txtIdModulo").val(data.id);
    $("#txt_nombre_modifi").val(data.modulo);
    $("#cmb_moduloPadre_modifi").val(data.moduloPadre);
    $("#txt_icono_modifi").val(data.iconoMenu);
    $("#txt_formulario_modifi").val(data.vista);
    $("#txt_Situacion").val(data.situacion);
    
});

$("#tbl_modulos").on("click", ".btEliminar", function () {
    var data = table.row($(this).parents("tr")).data();
  
    if (table.row(this).child.isShown()) {
      var data = table.row(this).data();
    }
  
    Swal.fire({
      title: "¿Esta seguro de Eliminar este Registro?",
      text: "Una vez hecho esto el usuario no podrá visualizarlo",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si",
    }).then((result) => {
      if (result.value) {
        modificarEstatusModulo(data.id, "0");
      }
    });
});

function abrirModuloRegistro()
{
    $("#modal_registro_modulos").modal({ backdrop: "static", keyboard: false });
    $("#modal_registro_modulos").modal("show");
}

function registrar_modulo()
{
    var nombreModulo=$("#txt_nombre").val();
    var moduloPadre=$("#cmb_moduloPadre").val();
    var nomIcono=$("#txt_icono").val();
    var nomFormulario=$("#txt_formulario").val();

    if(nombreModulo.length==0)
    {
        return Swal.fire("Mensaje De Advertencia","Todos los campos marcados son obligatorios","warning");
    }

    var cadObj='{"nombreModulo":"'+nombreModulo+'","moduloPadre":"'+moduloPadre+'","nomIcono":"'+nomIcono+'","nomFormulario":"'+nomFormulario+'"}';

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_registro_modulos").modal('hide');
            Swal.fire("Mensaje De Confirmacion","Datos correctamente Registrado","success") 
            listarModulos();
            limpiarCamposModalRegistro();           
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFuncionesModulos.php',funcAjax, 'POST','funcion=2&cadObj='+cadObj,true) 
}

function modificar_modulo()
{
    var nombreModulo=$("#txt_nombre_modifi").val();
    var moduloPadre=$("#cmb_moduloPadre_modifi").val();
    var nomIcono=$("#txt_icono_modifi").val();
    var nomFormulario=$("#txt_formulario_modifi").val();
    var idModulo=$("#txtIdModulo").val();
    var situacion=$("#txt_Situacion").val();

    if(nombreModulo.length==0 || situacion==-1)
    {
        return Swal.fire("Mensaje De Advertencia","Todos los campos marcados son obligatorios","warning");
    }

    var cadObj='{"nombreModulo":"'+nombreModulo+'","moduloPadre":"'+moduloPadre+'","nomIcono":"'+nomIcono+'","nomFormulario":"'+nomFormulario+'","idModulo":"'+idModulo+'","situacion":"'+situacion+'"}';

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_modificar_modulos").modal('hide');
            Swal.fire("Mensaje De Confirmacion","Datos correctamente Modificados","success") 
            listarModulos();
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFuncionesModulos.php',funcAjax, 'POST','funcion=3&cadObj='+cadObj,true) 

}

function modificarEstatusModulo(id, estado)
{
    var mensaje = "";
    var idModulo = id;

    if (estado == "0") {
        mensaje = "Inactivo";
    } else {
        mensaje = "Activo";
    }

    var cadObj = '{"idModulo":"' + idModulo + '","estado":"' + estado + '"}';

    function funcAjax() {
        var resp = peticion_http.responseText;
        arrResp = resp.split("|");
        if (arrResp[0] == "1") {
            listarModulos();
        Swal.fire("Mensaje De Confirmacion","El Mpodulo se " + mensaje + " con exito","success");
        } else {
        Swal.fire("Mensaje De Error","Lo sentimos, no se pudo modificar el registro","error");
        }
    }
    obtenerDatosWeb("funciones/paginaFuncionesModulos.php",funcAjax,"POST","funcion=4&cadObj=" + cadObj,true);
}



function limpiarCamposModalRegistro()
{
    $("#txt_nombre").val('');
    $("#cmb_moduloPadre").val('-1');
    $("#txt_icono").val('');
    $("#txt_formulario").val('');
}
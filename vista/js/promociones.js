var table;
function listar_promociones() {
    table = $("#tbl_promociones").DataTable({
        dom: 'Bfrtip', //Muestra los botones para imprimir en Buttons
        buttons: [
            {
                text: 'Agregar Promoción',
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
          url: "funciones/paginaFuncionesPromocion.php",
          type: "POST",
          data:{
              funcion: "1"
          }
        },
        columns: [
            { data: "" },
            { data: "id" },
            { data: "tituloPromocion" },
            { data: "fechaInicial" },
            { data: "fechaFinal" },
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
                                "<span title='Modificar' class='btEditar text-primary px-1' style='cursor:pointer;'>" +
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
    $("#modal_registro_promocion").modal({ backdrop: "static", keyboard: false });
    $("#modal_registro_promocion").modal("show");
}

function registrar_promocion()
{
    var frm=document.getElementById('form_subir');
    var data = new FormData(frm);
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if(this.readyState==4){
            var msg = xhttp.responseText;
                
                switch(msg){
                    case '0':
                        Swal.fire("Mensaje De Error","Los campos marcados con * son obligatorios","error");
                    break;
                    case '1':
                        $('#modal_registro_promocion').modal('hide');
                        limpiarCamposModalRegistro();
                        Swal.fire("Los datos se guardaron correctamente","success") 
                        //$('#modal_registro_promocion').trigger('reset');
                        listar_promociones();
                    break;
                    case '2':
                        $('#modal_registro_promocion').modal('hide');
                        limpiarCamposModalRegistro();
                        Swal.fire("Los datos no fueron guardados","error")
                    break;
                    case '3':
                        Swal.fire("El archivo de ser una imagen","error")
                    break;
                }
        }
    };
    xhttp.open("POST","funciones/funcionesGuardarPromociones.php", true);
    xhttp.send(data);
}

/*VER ARCHIVO MODAL */
$("#tbl_promociones").on("click", ".btEditar", function () {
    var data = table.row($(this).parents("tr")).data();
  
    if (table.row(this).child.isShown()) {
      var data = table.row(this).data();
    }
  
    $("#modal_modificar_promocion").modal({ backdrop: "static", keyboard: false });
    $("#modal_modificar_promocion").modal("show");

    $("#txtIdPromocion").val(data.id);
    $("#txt_titulo_modificar").val(data.tituloPromocion);
    $("#txt_descripcion_modificar").val(data.descripcion);
    $("#txt_fecha_inicio_modificar").val(data.fechaIni);
    $("#txt_fecha_fin_modificar").val(data.fechaFin);
    $("#txt_Situacion").val(data.situacion);

    
  });

function modificar_promocion()
{
    var idPromocion=$("#txtIdPromocion").val();
    var titulo=$("#txt_titulo_modificar").val();
    var descripcion=$("#txt_descripcion_modificar").val();
    var fechaInicio=$("#txt_fecha_inicio_modificar").val();
    var fechaFin=$("#txt_fecha_fin_modificar").val();
    var situacion=$("#txt_Situacion").val();

    if(titulo.length==0 || fechaInicio.length==0 || fechaFin.length==0 || situacion==-1)
    {
        return Swal.fire("Mensaje De Advertencia","Todos los campos marcados son obligatorios","warning");
    }

    var cadObj='{"titulo":"'+titulo+'","descripcion":"'+descripcion+'","fechaInicio":"'+fechaInicio+'","fechaFin":"'+fechaFin+'","situacion":"'+situacion+'","idPromocion":"'+idPromocion+'"}';

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_modificar_promocion").modal('hide');
            Swal.fire("Mensaje De Confirmacion","Datos correctamente Registrado","success") 
            listar_promociones();           
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFuncionesPromocion.php',funcAjax, 'POST','funcion=2&cadObj='+cadObj,true) 

}

/*FUNCION QUE PERMITE PREVISUALIZAR LA IMAGEN */

function previewFile(input){
    var file = $("input[type=file]").get(0).files[0];

    if(file){
        var reader = new FileReader();

        reader.onload = function(){
            $("#previewImg").attr("src", reader.result);
        }
        reader.readAsDataURL(file);
    }
}

function limpiarCamposModalRegistro()
{
    $("#txt_titulo").val('');
    $("#txt_descripcion").val();
    $("#txt_fecha_inicio").val();
    $("#txt_fecha_fin").val('');
    $("#iptImagen").val('');
    $("#previewImg").val('');
}


    

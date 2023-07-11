var table;
var items = []; // SE USA PARA EL INPUT DE AUTOCOMPLETE

function listarEventoCita() {
    table = $("#tbl_registroAgenda").DataTable({
        dom: 'Bfrtip', //Muestra los botones para imprimir en Buttons
        buttons: [
            {
                text: 'Agregar Cita',
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
          url: "funciones/paginaFuncionesEventoCita.php",
          type: "POST",
          data:{
              funcion: "1"
          }
        },
        columns: [
            { data: "" },
            { data: "id" },
            { data: "nombrePaciente" },
            { data: "fechaCita" }, 
            { data: "horaCita" }, 
             
            { data: "situacion", 
                render: function (data, type, row) {
                    if (data == "1") {
                        return "<span class='badge bg-success'>POR ATENDER</span>";
                    } else {
                        if(data == "2")
                        {
                            return "<span class='badge bg-primary'>ATENDIDA</span>";
                        }else{
                            return "<span class='badge bg-danger'>CANCELADA</span>";
                        }
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

/* ======================================================================================
    TRAER LISTADO DE PRODUCTOS PARA INPUT DE AUTOCOMPLETADO
======================================================================================*/

function listadoPaciente()
{
    $.ajax({
        async: false,
        url:"funciones/paginaFuncionesEventoCita.php",
        method:"POST",
        data:{
                'funcion': 2
        },
       // dataType:"json",
        success: function(respuesta){
            var valor=JSON.parse(respuesta)
            
            valor.forEach(element => {
                items.push(element.nombre);
            });

           // console.log(items);

            $("#iptCodigoVenta").autocomplete({
                source: items,
                select: function(event, ui) {
                    almacenarPaciente(ui.item.value);                                                            
                    $("#iptCodigoVenta").val("");
                    $("#iptCodigoVenta").focus();

                    return false;
                } 
                
            });
        }
    });
}

/* ======================================================================================
    EVENTO QUE REGISTRA EL PRODUCTO EN EL LISTADO CUANDO SE INGRESA EL CODIGO DE BARRAS
======================================================================================*/
$("#iptCodigoVenta").change(function() {
    almacenarPaciente();        
});

$("#tbl_registroAgenda").on("click", ".btEditar", function () {
    var data = table.row($(this).parents("tr")).data();
  
    if (table.row(this).child.isShown()) {
      var data = table.row(this).data();
    }

    $("#modal_modificar_cita").modal({ backdrop: "static", keyboard: false });
    $("#modal_modificar_cita").modal("show");

    $("#txtIdRegistro").val(data.id);
    $("#txt_nombrePaciente_modificar").val(data.nombrePaciente);
    $("#txt_fechaCita_modificar").val(data.fechaCitaSistema);
    $("#txt_horaCita_modificar").val(data.horaCita);
    $("#txt_comentario_modificar").val(data.comentarios);
    $("#txt_Situacion").val(data.situacion);

    obtenerHorarioCitaAsignada(data.horaCita);
    
});

function abrirModuloRegistro()
{
    $("#modal_registro_cita").modal({ backdrop: "static", keyboard: false });
    $("#modal_registro_cita").modal("show");

    limpiarCamposModalRegistro();
}

function almacenarPaciente(paciente="")
{
    if(paciente!=""){
        var cod_paciente=paciente;
    }else{
        var cod_paciente=$("#iptCodigoVenta").val();
    }

    $("#txtIdPaciente").val(cod_paciente);
    $("#txt_nombrePaciente").val(cod_paciente);
    //console.log(cod_paciente);
}

function registrar_cita()
{
    var paciente=$("#txtIdPaciente").val();

    var fechaCita=$("#txt_fechaCita").val();
    var horaCita=$("#txt_horario").val();
    var comentarios=$("#txt_comentario").val();

    //console.log("horaCita "+horaCita);

    if(paciente.length=="" || fechaCita.length=="" || horaCita=="-1")
    {
        return Swal.fire("Mensaje De Advertencia","Los campos marcados con * son obligatorios","warning");
    }

    var cadObj='{"paciente":"'+paciente+'","fechaCita":"'+fechaCita+'","horaCita":"'+horaCita+'","comentarios":"'+comentarios+'"}';

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_registro_cita").modal('hide');
            Swal.fire("Mensaje De Confirmacion","Datos correctos, Cita Registrada","success") 
            listarEventoCita();  
            limpiarCamposModalRegistro();         
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFuncionesEventoCita.php',funcAjax, 'POST','funcion=3&cadObj='+cadObj,true) 
   
}

function modificar_Cita()
{
    var idRegistro=$("#txtIdRegistro").val();

    var fechaCita=$("#txt_fechaCita_modificar").val();
    var horaCita=$("#txt_horaCita_modificar").val();
    var comentarios=$("#txt_comentario_modificar").val();
    var situacion=$("#txt_Situacion").val();

    if(fechaCita.length=="" || horaCita=="-1" || situacion==-1)
    {
        return Swal.fire("Mensaje De Advertencia","Los campos marcados con * son obligatorios","warning");
    }

    var cadObj='{"fechaCita":"'+fechaCita+'","horaCita":"'+horaCita+'","comentarios":"'+comentarios+'","idRegistro":"'+idRegistro+'","situacion":"'+situacion+'"}';

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_modificar_cita").modal('hide');
            Swal.fire("Mensaje De Confirmacion","Datos correctos, Cita Modificada","success") 
            listarEventoCita();  
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFuncionesEventoCita.php',funcAjax, 'POST','funcion=4&cadObj='+cadObj,true) 

}

function obtenerHorarioDisponible(value,id)
{
    var fechaCita=value;
    var idElemento=id;

   // console.log("fechaCita "+fechaCita+" idElemento "+idElemento);

    var params={fechaCita: fechaCita, idElemento: idElemento, funcion:5};

    $.post("funciones/paginaFuncionesEventoCita.php", params, function(data){
        $("#"+idElemento).html(data);
      });            

}

function obtenerHorarioCitaAsignada(hCita)
{
    horario = hCita;
    var params={horario:horario,funcion:6};
    $.post("funciones/paginaFuncionesEventoCita.php", params, function(data){
      $("#txt_horaCita_modificar").html(data);
    }); 
}

function limpiarCamposModalRegistro()
{
    $("#txtIdPaciente").val('');
    $("#txt_nombrePaciente").val('');
    $("#txt_fechaCita").val('');
    $("#txt_horario").val('-1');
    $("#txt_comentario").val('');
}





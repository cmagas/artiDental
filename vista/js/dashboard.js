var items = []; // SE USA PARA EL INPUT DE AUTOCOMPLETE

// Inicializamos la fecha actual en la fecha de hoy
var fechaActual = new Date();

// Función para retroceder una semana en la agenda
function retrocederSemana() {
    fechaActual.setDate(fechaActual.getDate() - 7);
    cargarAgenda();
}

// Función para avanzar una semana en la agenda
function avanzarSemana() {
    fechaActual.setDate(fechaActual.getDate() + 7);
    cargarAgenda();
}

function obtenerDatos() {
    $.ajax({
      url: "funciones/paginaFuncionesDashboard.php",
      method: "POST",
      dataType: "json",
      data: {
        funcion: "1",
      },
      success: function (respuesta) {
        //console.log("Respuesta ",respuesta);
        $("#totalCitaMes").html(respuesta["citaMes"]);
        $("#totalCitaDia").html(respuesta["citaDia"]);
        $("#ventasMes").html(respuesta["ventaMes"]);
        $("#ventaDia").html(respuesta["ventaDia"]);
      },
    });
}

function obtenerCitasPendientes() {
    $.ajax({
      url: "funciones/paginaFuncionesDashboard.php",
      type: "POST",
      data: {
        funcion: "2",
      },
      //dataType: "json",
      success: function (respuesta) {
        var valor = JSON.parse(respuesta);
        for (let i = 0; i < valor.length; i++) {
          filas =
            "<tr>" +
            "<td>" +
            valor[i]["nombrePaciente"] +
            "</td>" +
            "<td>" +
            valor[i]["fechaCita"] +
            "</td>" +
            "<td>" +
            valor[i]["horaCita"] +
            "</td>" +
            "</tr>";
          $("#tbl_pacientes_mes_pendientes tbody").append(filas);
        }
      },
    });
}
  
function obtenerCitasAtendidas() {
$.ajax({
    url: "funciones/paginaFuncionesDashboard.php",
    type: "POST",
    data: {
    funcion: "3",
    },
    //dataType: "json",
    success: function (respuesta) {
    var valor = JSON.parse(respuesta);
    for (let i = 0; i < valor.length; i++) {
        filas =
        "<tr>" +
        "<td>" +
        valor[i]["nombrePaciente"] +
        "</td>" +
        "<td>" +
        valor[i]["fechaCita"] +
        "</td>" +
        "<td>" +
        valor[i]["horaCita"] +
        "</td>" +
        "</tr>";
        $("#tbl_pacientes_atendidos tbody").append(filas);
    }
    },
});
}

/* ======================================================================================
    TRAER LISTADO DE PRODUCTOS PARA INPUT DE AUTOCOMPLETADO
======================================================================================*/

function listadoPaciente(datos) {
  $.ajax({
    async: false,
    url: "funciones/paginaFuncionesEventoCita.php",
    method: "POST",
    data: {
      'funcion': 2
    },
    // dataType:"json",
    success: function (respuesta) {
      var valor = JSON.parse(respuesta)

      valor.forEach(element => {
        items.push(element.nombre);
      });

      // console.log(items);

      $("#iptCodigoVenta").autocomplete({
        source: items,
        select: function (event, ui) {
          almacenarPaciente(ui.item.value);
          $("#iptCodigoVenta").val("");
          $("#iptCodigoVenta").focus();

          return false;
        }

      });
    }
  });
}

function almacenarPaciente(paciente = "") {
  if (paciente != "") {
    var cod_paciente = paciente;
  } else {
    var cod_paciente = $("#iptCodigoVenta").val();
  }

  $("#txtIdPaciente").val(cod_paciente);
  $("#txt_nombrePaciente").val(cod_paciente);
  //console.log('cod paciente ',cod_paciente);
}

function cargarAgenda() {

  
  var horarios = [
                    {
                      inicio: "12:00",
                      fin: "12:30"
                    },
                    {
                      inicio: "12:30",
                      fin: "13:00"
                    },
                    {
                      inicio: "13:00",
                      fin: "13:30"
                    },
                    {
                      inicio: "13:30",
                      fin: "14:00"
                    },
                    {
                      inicio: "14:00",
                      fin: "14:30"
                    },
                    {
                      inicio: "14:30",
                      fin: "15:00"
                    },
                    {
                      inicio: "15:00",
                      fin: "15:30"
                    },
                    {
                      inicio: "18:00",
                      fin: "18:30"
                    },
                    {
                      inicio: "18:30",
                      fin: "19:00"
                    },
                    {
                      inicio: "19:00",
                      fin: "19:30"
                    },
                    {
                      inicio: "19:30",
                      fin: "20:00"
                    },
                    {
                      inicio: "20:00",
                      fin: "20:30"
                    },
                    {
                      inicio: "20:30",
                      fin: "21:00"
                    }
                  ];

  //Funcion para mostrar la agenda de Citas
  function mostrarAgenda() {
    

  // Obtenemos el primer día de la semana (lunes)
  var primerDiaSemana = new Date(fechaActual.getFullYear(), fechaActual.getMonth(), fechaActual.getDate() -
  fechaActual.getDay() + 1);
    
   

  // Creamos la tabla de la agenda de citas
  var tabla = '<table style="width:100% " >' +
    '<tr>' +
    '<th style="width:100px">Hora</th>' +
    '<th>Lunes<br>' + primerDiaSemana.getDate() + '/' + (primerDiaSemana.getMonth() + 1) + '/' + primerDiaSemana
      .getFullYear() + '</th>' +
    '<th>Martes<br>' + (primerDiaSemana.getDate() + 1) + '/' + (primerDiaSemana.getMonth() + 1) + '/' +
    primerDiaSemana.getFullYear() + '</th>' +
    '<th>Miércoles<br>' + (primerDiaSemana.getDate() + 2) + '/' + (primerDiaSemana.getMonth() + 1) + '/' +
    primerDiaSemana.getFullYear() + '</th>' +
    '<th>Jueves<br>' + (primerDiaSemana.getDate() + 3) + '/' + (primerDiaSemana.getMonth() + 1) + '/' +
    primerDiaSemana.getFullYear() + '</th>' +
    '<th>Viernes<br>' + (primerDiaSemana.getDate() + 4) + '/' + (primerDiaSemana.getMonth() + 1) + '/' +
    primerDiaSemana.getFullYear() + '</th>' +
    '<th>Sabado<br>' + (primerDiaSemana.getDate() + 5) + '/' + (primerDiaSemana.getMonth() + 1) + '/' +
    primerDiaSemana.getFullYear() + '</th>' +
    '</tr>';
  // Recorremos los horarios disponibles para las citas
  for (var i = 0; i < horarios.length; i++) {
    // Obtenemos la hora de inicio y fin del horario
    var horaInicio = horarios[i].inicio;
    var horaFin = horarios[i].fin;
    // Creamos una fila para el horario
    tabla += '<tr>' +
      '<td>' + horaInicio + ' - ' + horaFin + '</td>';
    // Recorremos los días de la semana
    for (var j = 0; j < 6; j++) {
      // Obtenemos la fecha de la celda
      var fechaCelda = new Date(primerDiaSemana.getFullYear(), primerDiaSemana.getMonth(), primerDiaSemana
        .getDate() + j);
      // Obtenemos las citas para la fecha y hora actual
      
      var citas = getCitas(fechaCelda, horaInicio);
      // Creamos la celda para la cita

      //console.log("estamos aqui");
      var celda = '';
     //console.log("Citas - linea 234 atrapa", citas);

      if (citas.length > 0) {
        //console.log("entra");
        for (var k = 0; k < citas.length; k++) {
          celda += '<div class="cita">' + citas[k].nombre +'<br>'+
            '  <a href="javascript:void(0);" class="btn-eliminar" onclick="eliminarCita(' +
            citas[k].indice + ');">Cancelar</a></div>';
        }
      } else {
        celda = '<div class="cita vacio"><a href="javascript:void(0);" onclick="agregarCitas(\'' + fechaCelda
          .getFullYear() + '-' + (fechaCelda.getMonth() + 1) + '-' + fechaCelda.getDate() + ' ' +
          horaInicio + '\');">Disponible</a></div>';
      }
      // Agregamos la celda a la fila
      tabla += '<td>' + celda + '</td>';
    }
    // Cerramos la fila del horario
    tabla += '</tr>';
  }
  // Cerramos la tabla de la agenda de citas
  tabla += '</table>';
  // Mostramos la tabla en la página
  document.getElementById('agenda-citas').innerHTML = tabla;

}

// Función para obtener las citas para una fecha y hora determinada

  function getCitas(fecha, hora)
  {
    var citas=[];
    var fechaCita = new Date(fecha);
    var anio = fechaCita.getFullYear();
    var mes = fechaCita.getMonth() + 1;

    if (mes < 10) {
      mes = "0" + mes;
    }

    var dia = fechaCita.getDate();
    var fechaMysl = anio + '-' + mes + '-' + dia;

  // console.log("fecha linea 293 ",fechaMysl," otra fecha ",fecha);
    var horaCita=hora;

    var cadObj='{"fechaMysl":"'+fechaMysl+'","horaCita":"'+horaCita+'"}';

    $.ajax({
        async: false,
        url: "funciones/paginaFuncionesDashboard.php",
        method: "POST",
        data: {
            'funcion': 5,
            'fechaMysl': fechaMysl,
            'horaCita': horaCita
        },
        dataType: 'json',
        success: function(respuesta) {
        
            citas.push({
              nombre: respuesta["nombre"],
              indice: respuesta["indice"]
            });
            
        }
    });
    return citas;
    //console.log("retorna cita 2", citas);
  }



  mostrarAgenda();

}

function agregarCitas(fechaHora) {
  //console.log('fechaHora '+fechaHora);

  var fechaCita = new Date(fechaHora);
  var anio = fechaCita.getFullYear();
  var mes = fechaCita.getMonth() + 1;
  if (mes < 10) {
    mes = "0" + mes;
  }
  var dia = fechaCita.getDate();

  if(dia < 10)
  {
    dia = "0" + dia;
  }

  var fechaNueva = dia + ' / ' + mes + ' / ' + anio;
  var fechaMysl = anio + '-' + mes + '-' + dia

  //console.log('fechaMysql '+dia);

  var horaCita = fechaHora.substr(9);

  //console.log('fechaHora '+fechaHora);
  //console.log('horaCita '+horaCita);

  $("#modal_registro_nuevo").modal({ backdrop: "static", keyboard: false });
  $("#modal_registro_nuevo").modal("show");

  $("#txt_fechaCitada").val(fechaMysl);

  //$("#txt_HoraCitadaDash").val(horaCita);

  obtenerHorarioCitaTablero(fechaMysl, horaCita);
  


  listadoPaciente(fechaHora);
}

// Función para modificar una cita
function eliminarCita(indice) {
  
  Swal.fire({
    title: "¿Esta seguro de querer Cancelar la Cita?",
    text: "Una vez hecho esto el usuario no podrá visualizarlo",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si",
  }).then((result) => {
    if (result.value) {
      modificarEstatusCita(indice, "0");
    }
  });
}

function registrar_cita_paciente()
{
  var idPaciente=$("#txtIdPaciente").val();
  var fechaCita=$("#txt_fechaCitada").val();
  var horaCita=$("#txt_HoraCitadaDash").val(); 
  var comentarios=$("#txt_comentario").val();

  //console.log('fecha cita & linea 389 '+horaCita);
  
  if(idPaciente.length==0 || fechaCita.length==0 || horaCita=='-1')
  {
    return Swal.fire("Mensaje De Advertencia","Los campos marcados con * son obligatorios","warning");
  }

  var cadObj='{"idPaciente":"'+idPaciente+'","fechaCita":"'+fechaCita+'","horaCita":"'+horaCita+'","comentarios":"'+comentarios+'"}';

  function funcAjax()
  {
      var resp=peticion_http.responseText;
      arrResp=resp.split('|');
      if(arrResp[0]=='1')
      {
          $("#modal_registro_nuevo").modal('hide');
          Swal.fire("Mensaje De Confirmacion","Datos correctos, Cita registrada","success")
          cargarAgenda(); 
          limpiarCamposModalRegistro();        
      }
      else
      {
          Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
      }
  }
  obtenerDatosWeb('funciones/paginaFuncionesDashboard.php',funcAjax, 'POST','funcion=4&cadObj='+cadObj,true) 
}

function eliminarCita(id)
{
  Swal.fire({
    title: "¿Esta seguro de querer Cancelar esta Cita?",
    text: "Una vez hecho esto no podrá visualizarlo",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si",
  }).then((result) => {
    if (result.value) {
      eliminarCitaBase(id);
    }
  });
}

function eliminarCitaBase(id)
{
  var idCita=id;

  var cadObj='{"idCita":"'+idCita+'"}';

  function funcAjax() {
    var resp = peticion_http.responseText;
    arrResp = resp.split("|");
    if (arrResp[0] == "1") {
      cargarAgenda();
      Swal.fire("Mensaje De Confirmacion","La Cita se cancelo con exito","success");
    } else {
      Swal.fire("Mensaje De Error","Lo sentimos, no se pudo cancelar la Cita","error");
    }
  }
  obtenerDatosWeb("funciones/paginaFuncionesDashboard.php",funcAjax,"POST","funcion=6&cadObj=" + cadObj,true);
}

function obtenerHorarioCitaTablero(fecha, hora)
{
  var fechaCita=fecha;
  var horaCita=hora;

    var params={fechaCita:fechaCita, horaCita:horaCita,funcion:7};
    $.post("funciones/paginaFuncionesDashboard.php", params, function(data){

      $("#txt_HoraCitadaDash").html(data);
      
    }); 
}

function limpiarCamposModalRegistro()
{
  $("#txtIdPaciente").val('');
  $("#txt_fechaCita").val('');
  $("#txt_HoraCita").val(''); 
  $("#txt_comentario").val('');
  $("#txt_nombrePaciente").val('');
}
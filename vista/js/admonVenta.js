var table, ventas_desde, ventas_hasta;
var groupColumn = 1; //Columna por el cual se va a grupar
var importeTotalVenta=0.00;

var Toast=Swal.mixin({
    toast: true,
    position:'top',
    showConfirmButton: false,
    timer: 3000
});

function  inicializarTablaVentas()
{
    $('#ventas_desde, #ventas_hasta').inputmask('dd/mm/yyyy', {
        'placeholder': 'dd/mm/yyyy'
    })

    //Pone la fecha inicial principio de mes actual
    $("#ventas_desde").val(moment().startOf('month').format('DD/MM/YYYY'));
    //Pone la fecha actual
    $("#ventas_hasta").val(moment().format('DD/MM/YYYY'));

    ventas_desde = $("#ventas_desde").val();
    ventas_hasta = $("#ventas_hasta").val();

    ventas_desde = ventas_desde.substr(6,4) + '-' + ventas_desde.substr(3,2) + '-' + ventas_desde.substr(0,2) ; 
    ventas_hasta = ventas_hasta.substr(6,4) + '-' + ventas_hasta.substr(3,2) + '-' + ventas_hasta.substr(0,2) ;       

    //console.log('venta_desde '+ventas_desde);
    //console.log('ventas_hasta '+ventas_hasta);


    table = $('#lstVentas').DataTable({

        "columnDefs": [
            { visible: false, targets: [groupColumn,0] },
            {
                targets: [2,3,4,5,6,7],
                orderable: false
            }
        ],
        "order": [[ groupColumn, 'asc' ]],
        dom: 'Bfrtip',
        buttons: [
            'excel', 'print', 'pageLength',
        ],
        ordering: true,
        orderCellsTop: true,
        fixedHeader: true,
        scrollX: false,
        lengthMenu: [0, 5, 10, 15, 20, 50],
        "pageLength": 15,
        ajax: {
            async: false,
            url: 'funciones/paginaFuncionesCaja.php',
            type: 'POST',
            dataType: 'json',
            data: {
                'funcion': 9,
                'fechaDesde': ventas_desde,
                'fechaHasta' : ventas_hasta
            }
        },
        columns: [
            { data: "id"},
            { data: "nro_boleta"},
            { data: "codigo_producto"},
            { data: "nombre_categoria"},
            { data: "descripcion_producto"},
            { data: "cantidad"},
            { data: "total_venta"},
            { data: "fecha_venta"}
        ],
        drawCallback: function (settings) {
                
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;

           

            api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {                
                 //console.log("🚀 ~ file: administrar_ventas.php ~ line 61 ~ group : ", group)               
                if ( last !== group ) {

                    const data = group.split("-");
                    var nroBoleta = data[0];
                    nroBoleta = nroBoleta.split(":")[1].trim();   
                    
                    var monto=data[1];
                    monto=monto.split(":")[1].trim();
                    var algo=parseFloat(monto.replace('$',''));

                    importeTotalVenta= parseFloat(importeTotalVenta)+ parseFloat(algo);

                    $(rows).eq(i).before(
                        '<tr class="group">'+
                            '<td colspan="7" class="fs-6 fw-bold fst-italic bg-success text-white"> ' +
                                '<i nroBoleta = ' + nroBoleta + ' class="fas fa-trash fs-6 text-danger mx-2 btnEliminarVenta" style="cursor:pointer;"></i><i nroBoleta = ' + nroBoleta + ' class="far fa-edit fs-6 text-warning mx-2 btnEditarVenta fw-bold"  style="cursor:pointer;"></i> '+
                                    group +  
                            '</td>'+
                        '</tr>'
                    );

                    last = group;
                }
            } );

            $("#totalVenta").html(importeTotalVenta.toFixed(2))
        },
        language: idioma_espanol
    });

        
    
}

/*========================================================
    EVENTO PARA FILTRAR VENTAS SEGUN RANGO DE FECHAS
========================================================*/
$("#btnFiltrar").on('click',function(){
    
    table.destroy();
    
    if($("#ventas_desde").val()==''){
        ventas_desde='01/01/1970';
    }else{
        ventas_desde= $("#ventas_desde").val();
    }

    if($("#ventas_hasta").val()==''){
        ventas_hasta='01/01/1970';
    }else{
        ventas_hasta= $("#ventas_hasta").val();
    }

    ventas_desde = ventas_desde.substr(6,4) + '-' + ventas_desde.substr(3,2) + '-' + ventas_desde.substr(0,2);
    ventas_hasta = ventas_hasta.substr(6,4) + '-' + ventas_hasta.substr(3,2) + '-' + ventas_hasta.substr(0,2);

    var groupColumn=1;

    table = $('#lstVentas').DataTable({

        "columnDefs": [
            { visible: false, targets: [groupColumn,0] },
            {
                targets: [2,3,4,5,6,7],
                orderable: false
            }
        ],
        "order": [[ groupColumn, 'asc' ]],
        dom: 'Bfrtip',
        buttons: [
            'excel', 'print', 'pageLength',

        ],
        lengthMenu: [0, 5, 10, 15, 20, 50],
        "pageLength": 15,
        ajax: {
            url: 'funciones/paginaFuncionesCaja.php',
            type: 'POST',
            dataType: 'json',
            data: {
                'funcion': 9,
                'fechaDesde': ventas_desde,
                'fechaHasta' : ventas_hasta
            }
        },
        columns: [
            { data: "id"},
            { data: "nro_boleta"},
            { data: "codigo_producto"},
            { data: "nombre_categoria"},
            { data: "descripcion_producto"},
            { data: "cantidad"},
            { data: "total_venta"},
            { data: "fecha_venta"}
        ],
        drawCallback: function (settings) {
                
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;

            api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {                
                 //console.log("🚀 ~ file: administrar_ventas.php ~ line 61 ~ group : ", group)               
                if ( last !== group ) {

                    const data = group.split("-");
                    var nroBoleta = data[0];
                    nroBoleta = nroBoleta.split(":")[1].trim();   
                    
                    var monto=data[1];
                    monto=monto.split(":")[1].trim();
                    var algo=parseFloat(monto.replace('$',''));

                    importeTotalVenta= parseFloat(importeTotalVenta)+ parseFloat(algo);

                    $(rows).eq(i).before(
                        '<tr class="group">'+
                            '<td colspan="7" class="fs-6 fw-bold fst-italic bg-success text-white"> ' +
                                '<i nroBoleta = ' + nroBoleta + ' class="fas fa-trash fs-6 text-danger mx-2 btnEliminarVenta" style="cursor:pointer;"></i><i nroBoleta = ' + nroBoleta + ' class="far fa-edit fs-6 text-warning mx-2 btnEditarVenta fw-bold"  style="cursor:pointer;"></i> '+
                                    group +  
                            '</td>'+
                        '</tr>'
                    );

                    last = group;
                }
            } );

            $("#totalVenta").html(importeTotalVenta.toFixed(2))
        },
        language: idioma_espanol
    });

})

/*========================================================
    EVENTO PARA ELIMINAR UNA VENTA
========================================================*/
$('#lstVentas tbody').on('click','.btnEliminarVenta', function(){
    //alert();
    var data = table.row($(this).parents("tr")).data();
    if (table.row(this).child.isShown()) {
        var data = table.row(this).data();
      }
    var nroBoleta = $(this).attr("nroBoleta");

    var cadObj='{"nroBoleta":"'+nroBoleta+'"}';

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Venta Eliminada',
                showConfirmButton: false,
                timer:1500
            })      
            table.ajax.reload();  
        }
        else
        {
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'No se pudo realizar la operación',
                showConfirmButton: false,
                timer:1500
            }) 
            
        }
    }
    obtenerDatosWeb('funciones/paginaFuncionesCaja.php',funcAjax, 'POST','funcion=10&cadObj='+cadObj,true) 
    
});

/*========================================================
==========================================================
    EVENTO PARA EDITAR UNA VENTA
=========================================================
========================================================*/

$('#lstVentas tbody').on('click','.btnEditarVenta', function(){
    //alert();
    nroBoleta = $(this).attr("nroBoleta");

    if($.fn.DataTable.isDataTable('#tblDetalleVenta')){
        $("#tblDetalleVenta").DataTable().destroy();
    }

    $('#tblDetalleVenta tbody').empty();

    $("#tblDetalleVenta").DataTable({
        columns: [
            { data: "id"},
            { data: "nro_boleta"},
            { data: "codigo_producto"},
            { data: "nombre_categoria"},
            { data: "descripcion_producto"},
            { data: "cantidad"},
            { data: "total_venta"}
        ],
        processing: true,
        serverSide: true,
        paging: false,
        ajax: {
            url: 'funciones/paginaFuncionesCaja.php',
            type: 'POST',
            dataType: 'json',
            data: {
                'funcion': 11,
                'nro_boleta': nroBoleta,
             }
        },
        language: idioma_espanol

    });

    $("#modalEditarVenta").modal({ backdrop: "static", keyboard: false });
    $("#modalEditarVenta").modal("show");

    
    
});

/*EVENTO PARA CERRAR LA VENTANA MODAL */

$('#tblDetalleVenta').on('draw.dt', function(){

    $('#tblDetalleVenta').Tabledit({
        url: 'funciones/acciones_datatable.php',
        dataType: 'json',
        columns: {
            identifier: [0, 'id'],
            editable: [[2,'codigo_producto'],[5,'cantidad']]
        },
        buttons:{
            edit:{
                class: 'btn btn-sm btn-default',
                html: '<span class="glyphicon glyphicon-pencil"></span>',
                html: '<i class="fas fa-edit text-primary fs-6"></i>',
                action: 'edit'
            },
            delete:{
                class: 'btn btn-sm btn-default',
                html: '<span class="glyphicon glyphicon-trash"></span>',
                html: '<i class="far fa-trash-alt text-danger fs-6"></i>',
                action: 'delete'
            },
        },
        onSuccess: function(data, textStatus, jqXHR)
        {
            if(data.action=='delete')
            {
                $('#' + data.nro_boleta).remove();
                $('#tblDetalleVenta').DataTable().ajax.reload();
                table.ajax.reload();
                Toast.fire({
                    icon: 'success',
                    title: 'Se eliminó correctamente'
                });
            }

            if(data.action=='edit'){
                Toast.fire({
                    icon: 'success',
                    title: 'Se actualizó correctamente'
                });

                $('#tblDetalleVenta').DataTable().ajax.reload();
                table.ajax.reload();
            }
        }
    })
    
});

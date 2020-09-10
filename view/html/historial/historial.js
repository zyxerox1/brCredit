$(document).ready(function() {
  cargar_cliente();
  $('#buscar').on('click', function () {
    cargar_cliente();
  });
});


function cargar_cliente(){
  if ( $.fn.dataTable.isDataTable( '#datahistoria' ) ) {
   $("#datahistoria").dataTable().fnDestroy();
  }
    var MY_AJAX_ACTION_URL = "index.php?c=historial&a=ver";
    table = $('#datahistoria').DataTable({
        "autoWidth": true,
        "ajax": {
          "data": {
            'Cedula':$('#Cedula').val(),
            'Nombre':$('#Nombre').val()
          },
          "url": MY_AJAX_ACTION_URL
        },
        "type": "get",
        "paging": true,
        "searching": false,
        "ordering": false,
        "language": {
          "zeroRecords": "Pagina no encontrada",
          "processing": 'Cargando...'
        },
        //"stateSave": true,
        "bLengthChange" : true,
        "info": false,
        "search": true,
        "sort": true,
        "stripeClasses": [ "odd nutzer_tr", "even nutzer_tr"],
        "columns": [
          { data: 'nombre' },
          { data: 'couta'},
          { data: 'tVenta' },
          { data: 'diasV' },
      ],
      "columnDefs": [{
          "targets": 0,
          "data": "nombre",
          "render": function ( data, type, row, meta ) {
            if(row.cumplimiento==0){
              return "<div class='nombreTableR'><h5>Nombre: "+data+"</h5><h5 class='valTable'>Sin validar</h5></div>";
            }else{
              return "<div class='nombreTableV'><h5>Nombre: "+data+"</h5><h5 class='valTable'>Validado</h5></div>";
            }
          }
        },
        {
          "targets": 1,
          "data": "couta",
          "render": function ( data, type, row, meta ) {
            var html="";
            if(row.pago==null){
              row.pago=0;
            }
            html="<div class='coutaTable'><h5>Couta: $R "+data+" - Pago: $R "+row.pago+"</h5></div>";
            return html;
          }
        },{
          "targets": 2,
          "data": "tVenta",
          "render": function ( data, type, row, meta ) {
            var html="";
            html="<div class='coutaTable'><h5>Total ventas: $R "+data+" - Debe: $R "+row.debe+"</h5></div>";
            return html;
          }
        },{
          "targets": 3,
          "data": "tVenta",
          "render": function ( data, type, row, meta ) {
            var html="";
            html="<div class='coutaTable'><h5>Dias vencido: "+data+"</h5></div>";
            return html;
          }
        }],
        "processing": true,
        "serverSide": true,
        "pageLength" : 10,
        drawCallback: function () {
        }
    });
  }

function registrar_abono(action,datos) {
  if(ip==0){
    ohSnap('Error desconocido.',{color: 'red'});
    return false;
  }
  var formData = new FormData();
  formData=crearObjetoFormData(datos);
  formData.append('idPres',ip);
  formData.append('tipo',tipo);
  $.ajax({
      data: formData,
      url: action,
      type: "post",
      contentType: false,
      processData: false,
      success:function(e){
          var obj = JSON.parse(e);
          if(obj["error"]!=0){
            if(obj["error"]==1){
              ohSnap(obj["mensaje"],{color: 'red'});
            }
            check_todo_input_verificado();
            validate_errores_peticion_ajax(obj);
          }else if(obj["error"]==0){
            cargar_cliente();
            $('#modalAbono').modal("hide");
            ohSnap('Se guardo correctamente',{color: 'green'});
          }else{
            ohSnap('Error desconocido.',{color: 'red'});
          }
      },
      error:function(){
          ohSnap('Error desconocido.',{color: 'red'});
      }
  });
}
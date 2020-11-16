var table;
var latitudRetiro=0;
var longitudRetiro=0;
$(document).ready(function() {
	$('.datetimepicker').datetimepicker({ 
	format: 'YYYY-MM-DD',
	icons: {
	    time: "fa fa-clock-o",
	    date: "fa fa-calendar",
	    up: "fa fa-chevron-up",
	    down: "fa fa-chevron-down",
	    previous: 'fa fa-chevron-left',
	    next: 'fa fa-chevron-right',
	    today: 'fa fa-screenshot',
	    clear: 'fa fa-trash',
	    close: 'fa fa-remove'
	  }
	});
  $('#buscar').on('click', function () {

    cargar_reporte();
  });

  $('#btnModalRetiro').on('click', function () {
    gelocalizacionRetiro();
    $('#modalRetiro').modal("show");
  });

  $("#guardarRetiroConfirm").on('click', function () {
    registrar_retiro($("#formulario-registrar-retiro").attr('action'),$("#formulario-registrar-retiro").serializeArray());
  });
  
  cargar_reporte();
});

function cargar_reporte(){
  if ( $.fn.dataTable.isDataTable( '#dataretiro' ) ) {
   $("#dataretiro").dataTable().fnDestroy();
  }
    var MY_AJAX_ACTION_URL = "index.php?c=retiro&a=cargar_reporte";
    table = $('#dataretiro').DataTable({
        "autoWidth": true,
        "ajax": {
          "data": {
            'Nombre':$('#Nombre').val(),
            'codigo':$('#codigo').val(),
            'Fecha_ini':$('#Fecha_ini').val(),
            'Fecha_fin':$('#Fecha_fin').val()
          },
          "url": MY_AJAX_ACTION_URL
        },
        "type": "get",
        "paging": true,
        "searching": false,
        "ordering": true,
        "language": {
          "zeroRecords": "Pagina no encontrada",
          "processing": 'Cargando...'
        },
        "bLengthChange" : true,
        "info": true,
        "search": true,
        "sort": true,
        "stripeClasses": [ "odd nutzer_tr", "even nutzer_tr"],
        "columns": [
          { data: 'Retiro' },
          { data: 'fecha'},
          { data: 'Descripcion'},
          { data: 'Valor' },
          { data: 'Autor' }
      ],
      "columnDefs": [
        { className: "nowrap-column", "targets": [ 1 ] }
      ],
        "processing": true,
        "serverSide": true,
        "pageLength" : 10,
        drawCallback: function () {
       
        }
    });
   
  }

function geo_successRetiro(position) {
  latitudRetiro=position.coords.latitude;
  longitudRetiro=position.coords.longitude;
  $(".location").html('<input hidden value="'+latitudRetiro+'" name="latitud"><input hidden value="'+longitudRetiro+'" name="longitud">');
}

function geo_errorRetiro() {
  alert("Si no conocemos tu ubicacion puede generar errores a la hora de registrar el retiro");
}


function gelocalizacionRetiro(){
  var geo_optionsRetiro = {
    enableHighAccuracy: true, 
    maximumAge        : 30000, 
    timeout           : 27000
  };

  var wpid = navigator.geolocation.getCurrentPosition(geo_successRetiro, geo_errorRetiro, geo_optionsRetiro);
}


function registrar_retiro(action,datos) {
  var formData = new FormData();
  formData=crearObjetoFormData(datos);
  formData.append('latitud',latitudRetiro);
  formData.append('longitud',longitudRetiro);
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
            cargar_reporte();
            $('#modalRetiro').modal("hide");
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
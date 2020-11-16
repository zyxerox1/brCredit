var table;
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
  $('#Eliminar').on('click', function () {
    eliminar_cursos();
  });
  cargar_reporte();
});

function cargar_reporte(){
  if ( $.fn.dataTable.isDataTable( '#dataerrores' ) ) {
   $("#dataerrores").dataTable().fnDestroy();
  }
    var MY_AJAX_ACTION_URL = "index.php?c=reporte_errores&a=cargar_reporte";
    table = $('#dataerrores').DataTable({
        "autoWidth": true,
        "ajax": {
          "data": {
            'Cedula':$('#Cedula').val(),
            'Nombre':$('#Nombre').val(),
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
          { data: 'fecha' },
          { data: 'documento_suario'},
          { data: 'usuario'},
          { data: 'accion' },
          { data: 'descripcion' },
          { data: 'controller' },
          { data: 'function' }
      ],
      "columnDefs": [
      { className: "nowrap-column", "targets": [ 0 ] }
      ],
        "processing": true,
        "serverSide": true,
        "pageLength" : 10,
        drawCallback: function () {
       
        }
    });
   
  }

function eliminar_cursos(){
  $.ajax({
    data: {
      'Fecha_ini':$('#Fecha_ini').val(),
      'Fecha_fin':$('#Fecha_fin').val()
    },
    url: "index.php?c=reporte_errores&a=eliminar_reporte",
    type: "post",
    success:function(e){
      var data = JSON.parse(e);
      if(data["error"]!=0){
        check_todo_input_verificado();
        validate_errores_peticion_ajax(data);
      }else if(data["error"]==0){
        
        cargar_reporte();
        ohSnap('Se elimino correctamente',{color: 'green'});
      }else{
        error_501();
      }
    },
    error:function(){
        ohSnap('Error desconocido',{color: 'red'});
    }
  });
}

function csv(){
  window.open("index.php?c=reporte_errores&a=csv&Cedula="+$('#Cedula').val()+"&Nombre="+$('#Nombre').val()+"&Fecha_ini="+$('#Fecha_ini').val()+"&Fecha_fin="+$('#Fecha_fin').val());
}
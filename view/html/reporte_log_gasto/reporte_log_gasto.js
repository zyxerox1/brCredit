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

  cargar_reporte();
});

function cargar_reporte(){
  if ( $.fn.dataTable.isDataTable( '#datausuarios' ) ) {
   $("#datausuarios").dataTable().fnDestroy();
  }
    var MY_AJAX_ACTION_URL = "index.php?c=reporte_log_gasto&a=cargar_reporte";
    table = $('#datausuarios').DataTable({
        "autoWidth": true,
        "ajax": {
          "data": {
            'Cedula':$('#Cedula').val(),
            'Nombre':$('#Nombre').val(),
            'Fecha_ini':$('#Fecha_ini').val(),
            'Fecha_fin':$('#Fecha_fin').val(),
            'Movimiento': $('#Movimiento').val()
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
          { data: 'movimiento' },
          { data: 'fecha'},
          { data: 'usuario'},
          { data: 'documento_suario' },
          { data: 'neto' },
          { data: 'valor' },
          { data: 'pagado' },
          { data: 'tipo' },
          { data: 'nota' },
          { data: 'mapa' }
      ],
      "columnDefs": [{ 
        className: "nowrap-column", "targets": [ 1 ] 
      },{
           "targets": 4,
           "data": "neto",
           "render": function ( data, type, row, meta ) {
              return "$"+formaterNumeroDecimales(data);
           }
         
      },{
           "targets": 5,
           "data": "valor",
           "render": function ( data, type, row, meta ) {
              return "$"+formaterNumeroDecimales(data);
           }
         
      },{
           "targets": 6,
           "data": "pagado",
           "render": function ( data, type, row, meta ) {
              return "$"+formaterNumeroDecimales(data);
           }
         
      },{
          "className": "nowrap-column",
           "targets": 9,
           "data": "mapa",
           "render": function ( data, type, row, meta ) {
              if(row.coor==0){
                 return '<a class="btn btn-primary" href="'+data+'" target="_blank">Ver posiciòn</a>';
              }else{
                return 'No tiene posiciòn';
              }
             
           }
      }
      ],
        "processing": true,
        "serverSide": true,
        "pageLength" : 10,
        drawCallback: function () {
       
        }
    });
   
  }

  function csv(){
    window.open("index.php?c=reporte_log_gasto&a=csv&Cedula="+$('#Cedula').val()+"&Nombre="+$('#Nombre').val()+"&Fecha_ini="+$('#Fecha_ini').val()+"&Fecha_fin="+$('#Fecha_fin').val()+"&Movimiento="+$('#Movimiento').val());
  }
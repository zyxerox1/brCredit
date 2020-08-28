$(document).ready(function() {
  $('.cambiar-vista-list').on('click', function () {cambiar_vista_tabla(1,"datausuarios")});
  $('.cambiar-vista-cuad').on('click', function () {cambiar_vista_tabla(2,"datausuarios")}); 
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
    cargar_gasto();
  });
  cargar_gasto();
});

function cargar_gasto(){
  if ( $.fn.dataTable.isDataTable( '#datausuarios' ) ) {
   $("#datausuarios").dataTable().fnDestroy();
  }
    var MY_AJAX_ACTION_URL = "index.php?c=gasto&a=cargar_gasto";
    table = $('#datausuarios').DataTable({
        "autoWidth": true,
        "ajax": {
          "data": {
            'Cedula':$('#Cedula').val(),
            'Nombre':$('#Nombre').val(),
            'Fecha_ini':$('#Fecha_ini').val(),
            'Fecha_fin':$('#Fecha_fin').val(),
            'Valor_max':$('#Valor_max').val(),
            'Valor_mini':$('#Valor_mini').val()
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
        "stateSave": true,
        "bLengthChange" : true,
        "info": false,
        "search": true,
        "sort": true,
        "stripeClasses": [ "odd nutzer_tr", "even nutzer_tr"],
        "columns": [
          { data: 'cc' },
          { data: 'nombre'},
          { data: 'telefono'},
          { data: 'correo' },
          { data: 'valor' },
          { data: 'tipo' },
          { data: 'detalle' },
          { data: 'fecha'},
          { data: 'evidencia'},
          { data: 'id' },
      ],
      "columnDefs": [ {
           "targets": 4,
           "data": "valor",
           "render": function ( data, type, row, meta ) {
             return "$"+formatValor(data)+".00";
           }
         },{
           "targets": 8,
           "data": "evidencia",
           "render": function ( data, type, row, meta ) {
              return '<a class="btn btn-outline-primary" target="_blank" href="./view/assets/evidenciasGastosPropios/'+data+'"><i class="fas fa-file-download"></i></a>';
           }
         },{
           "targets": 9,
           "data": "id",
           "render": function ( data, type, row, meta ) {
           		if(row.estado==0){
           			var html='<a class="btn btn-warning cambiar" data-i='+data+'><i class="fas fa-exclamation"></i> Pendiente</a>';
           		}else{
           			var html='<a class="btn btn-success cambiar" style="color: white" data-i='+data+'><i class="fas fa-thumbs-up"></i></i></a>';
           		}
           		
              return html;
           }
         }],
        "processing": true,
        "serverSide": true,
        "pageLength" : 10,
        drawCallback: function () {
          $('.estado_usu').on('click', function () {
            var id_u=$(this).attr("data-estado");
            var estado=1;
            if( $(this).is(':checked') ){
              estado=0;
            } else {
              estado=1;
            }
            cambiar_estado(id_u,estado);
          });

          $('.cambiar').on('click', function () {
            var i=$(this).attr('data-i');
            modalCambiar(i);
          });
        }
    });
  }

function modalCambiar(i){
	$.ajax({
	  data: {"id":i},
	  url: "index.php?c=gasto&a=obtenerGasto",
	  type: "get",
	  success:function(e){
	      var obj = JSON.parse(e);
	      if(obj["data"].length>0){
		    $("#titleGasto").html("gasto de "+obj["data"][0].nombre_tipog);
		 	$(".detalle").html(obj["data"][0].nota_gas);
		 	$('.fecha_d').html(obj["data"][0].fecha_logg);
		 	if(obj["data"][0].estado_gas==0){
		 		$('.estado').html("Pendiente");
		 	}else if(obj["data"][0].estado_gas==1){
		 		$('.estado').html("Anulado");
		 	}else if(obj["data"][0].estado_gas==2){
		 		$('.estado').html("Cancelado");
		 	}else if(obj["data"][0].estado_gas==3){
		 		$('.estado').html("Abono");
		 	}

			$('.valor').html('$'+formatValor(obj["data"][0].valor_gas)+".00");
		 	$('.nombre').html(obj["data"][0].primer_nombre_usu+" "+obj["data"][0].segundo_nombre_usu);
			$('.apellido').html(obj["data"][0].primer_apellido_usu+" "+obj["data"][0].segundo_apellido_usu);
			$('.telefono1').html(obj["data"][0].telefono_1_usu);
			$('.telefono2').html(obj["data"][0].telefono_2_usu);
			$('.cc').html(obj["data"][0].documento_usu);
			$('.correo').html(obj["data"][0].correo_usu);
			$('.direcion').html(obj["data"][0].direcion_usu);
			$('.fecha').html(obj["data"][0].fecha_nacimineto_usu);

			for (var i = 0; i < obj["suma"].length; i++) {
				if(obj["suma"][i].estado==0){
					$('.pendientes').html('$'+formatValor(obj["suma"][i].total)+".00");
				}if(obj["suma"][i].estado==1){
					$('.cancelador').html('$'+formatValor(obj["suma"][i].total)+".00");
				}if(obj["suma"][i].estado==2){
					$('.anulado').html('$'+formatValor(obj["suma"][i].total)+".00");
				}if(obj["suma"][i].estado==3){
					$('.abonos').html('$'+formatValor(obj["suma"][i].total)+".00");
				}
			}
			$('.cancelar').attr('href','index.php?c=gasto&a=cambiarEstado&id='+obj["data"][0].id_gas);
	      	$("#gastoModal").modal("show");
	   	  }else{
	        ohSnap('Error desconocido, por favor comuniquese con el administrador.',{color: 'green'});
	      }
	  },
	  error:function(){
	      ohSnap('Error ha iniciar session',{color: 'red'});
	  }
	});
}
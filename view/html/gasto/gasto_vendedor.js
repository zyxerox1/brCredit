
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
    cargar_gasto();
  });

  $('.anular').on('click', function () {
    $("#confirmacionModal").modal("show");
  });

  $('#confirmacion').on('click', function () {
    cambiarEstado($(this).attr('data-g'));
  });
  cargar_gasto();
});

function cargar_gasto(){
  if ( $.fn.dataTable.isDataTable( '#dataGasto' ) ) {
   $("#dataGasto").dataTable().fnDestroy();
  }
    var MY_AJAX_ACTION_URL = "index.php?c=gasto&a=cargar_gasto";
    table = $('#dataGasto').DataTable({
        "autoWidth": true,
        "ajax": {
          "data": {
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
          { data: 'valor' },
          { data: 'tipo' },
          { data: 'detalle' },
          { data: 'fecha'},
          { data: 'evidencia'},
          { data: 'id' },
      ],
      "columnDefs": [ {
           "targets": 0,
           "data": "valor",
           "render": function ( data, type, row, meta ) {
             return "$"+formatValor(data)+".00";
           }
         },{
           "targets": 4,
           "data": "evidencia",
           "render": function ( data, type, row, meta ) {
              return '<a class="btn btn-outline-primary" target="_blank" href="./view/assets/evidenciasGastosPropios/'+data+'"><i class="fas fa-file-download"></i></a>';
           }
         },{
           "targets": 5,
           "data": "id",
           "render": function ( data, type, row, meta ) {
           		if(row.estado==0){
           			var html='<a class="btn btn-outline-warning cambiar" data-i='+data+'><i class="fas fa-exclamation"></i> Pendiente</a>';
           		}else if(row.estado==1){
           			var html='<a class="btn btn-outline-success cambiar" style="color: white" data-i='+data+'><i class="fas fa-thumbs-up"></i> Gasto cancelado</a>';
           		}
              else if(row.estado==3){
                var html='<a class="btn btn-outline-secondary cambiar" style="color: white" data-i='+data+'><i class="fas fa-window-close"></i> Gasto anulado</a>';
              }
           		
              return html;
           }
         }],
        "processing": true,
        "serverSide": true,
        "pageLength" : 10,
        drawCallback: function () {
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
          var pendientes='<td> $'+0+'</td>';
          var cancelador='<td> $'+0+'</td>';
          var anulado='<td> $'+0+'</td>';
          var abonos='<td> $'+0+'</td>';
          var tabla="";
  		    $("#titleGasto").html("Gasto de "+obj["data"][0].nombre_tipog);
          if(obj["data"][0].estado_gas!=0){
            $(".anular").hide();
          }else{
            $(".anular").show();
          }
    		 	$(".detalle").html(obj["data"][0].nota_gas);
    		 	$('.fecha_d').html(obj["data"][0].fecha_logg);
    		 	if(obj["data"][0].estado_gas==0){
    		 		$('.estado').html("Pendiente");
    		 	}else if(obj["data"][0].estado_gas==1){
    		 		$('.estado').html("Cancelado");
    		 	}else if(obj["data"][0].estado_gas==2){
    		 		$('.estado').html("Abono");
    		 	}else if(obj["data"][0].estado_gas==3){
    		 		$('.estado').html("Anulado");
    		 	}
  			  $('.valor').html('$'+formatValor(obj["data"][0].valor_gas)+".00");

          tabla+="<tr>";
    			for (var i = 0; i < obj["suma"].length; i++) {
    				if(obj["suma"][i].estado==0){
              pendientes="<td>"+'$'+formatValor(obj["suma"][i].total)+".00"+"</td>";
    				}
            if(obj["suma"][i].estado==1){
    					cancelador="<td>"+'$'+formatValor(obj["suma"][i].total)+".00"+"</td>";
    				}
            if(obj["suma"][i].estado==2){
    					anulado="<td>"+'$'+formatValor(obj["suma"][i].total)+".00"+"</td>";
    				}
            if(obj["suma"][i].estado==3){
    					abonos="<td>"+'$'+formatValor(obj["suma"][i].total)+".00"+"</td>";
    				}
    			}
          tabla+=pendientes+cancelador+anulado+abonos+"</tr>";

          $(".table-total").find('tbody').html(tabla);
	      	$("#gastoModal").modal("show");
          $('#confirmacion').attr("data-g",obj["data"][0].id_gas);
          //$('.anular').attr('href','index.php?c=gasto&a=cambiarEstado&id='+obj["data"][0].id_gas);
	   	  }else{
	        ohSnap('Error desconocido, por favor comuniquese con el administrador.',{color: 'green'});
	      }
	  },
	  error:function(){
	      ohSnap('Error ha iniciar session',{color: 'red'});
	  }
	});
}

function cambiarEstado(i_gas){
  $.ajax({
    data: {"id":i_gas},
    url: "index.php?c=gasto&a=cambiarEstado",
    type: "post",
    success:function(e){
        var obj = JSON.parse(e);
        if(obj["error"]==0){
          $("#confirmacionModal").modal("hide");
          cargar_gasto();
          modalCambiar(i_gas);
          ohSnap('Se cambio el estado correctamente',{color: 'green'});
        }else if(obj["error"]==1){
           ohSnap(obj["control"],{color: 'red'});
        }else{
          ohSnap('Error desconocido.',{color: 'green'});
        }
    },
    error:function(){
        ohSnap('Error ha iniciar session',{color: 'red'});
    }
  });
}
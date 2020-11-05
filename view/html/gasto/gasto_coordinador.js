var ip=0;
var latitud=0;
var longitud=0;

$(document).ready(function() {
  $('.cambiar-vista-list').on('click', function () {cambiar_vista_tabla(1,"dataGasto")});
  $('.cambiar-vista-cuad').on('click', function () {cambiar_vista_tabla(2,"dataGasto")}); 
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

  $("#guardarAbono").on('click', function () {
    registrar_abono($("#formulario-crear-abonar").attr('action'),$("#formulario-crear-abonar").serializeArray());
  });

  gelocalizacion();
  cargar_gasto();
});

function geo_success(position) {
  latitud=position.coords.latitude;
  longitud=position.coords.longitude;
  $(".location").html('<input hidden value="'+latitud+'" name="latitud"><input hidden value="'+longitud+'" name="longitud">');
}

function geo_error() {
  alert("Si no conocemos tu ubicacion puede generar errores a la hora de registrar el pago");
}


function gelocalizacion(){
  var geo_options = {
    enableHighAccuracy: true, 
    maximumAge        : 30000, 
    timeout           : 27000
  };

  var wpid = navigator.geolocation.getCurrentPosition(geo_success, geo_error, geo_options);
}

function cargar_gasto(){
  if ( $.fn.dataTable.isDataTable( '#dataGasto' ) ) {
   $("#dataGasto").dataTable().fnDestroy();
  }
    var MY_AJAX_ACTION_URL = "index.php?c=gasto&a=cargar_gasto";
    table = $('#dataGasto').DataTable({
        "autoWidth": true,
        "ajax": {
          "data": {
            'codigo':$('#codigo').val(),
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
          { data: 'ruta'},
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
           "targets": 5,
           "data": "valor",
           "render": function ( data, type, row, meta ) {
             return "$"+formaterNumeroDecimales(data);
           }
         },{
           "targets": 9,
           "data": "evidencia",
           "render": function ( data, type, row, meta ) {
              return '<a class="btn btn-outline-primary" target="_blank" href="./view/assets/evidenciasGastosPropios/'+data+'"><i class="fas fa-file-download"></i></a>';
           }
         },{
           "targets": 10,
           "data": "id",
           "render": function ( data, type, row, meta ) {
           		if(row.estado==0){
           			var html='<a class="btn btn-warning cambiar" data-i='+data+'><i class="fas fa-exclamation"></i> Pendiente</a>';
           		}else if(row.estado==2){
           			var html='<a class="btn btn-primary cambiar" style="color: white" data-i='+data+'>Abono</a>';
           		}else if(row.estado==1){
                var html='<a class="btn btn-success cambiar" style="color: white" data-i='+data+'><i class="fas fa-thumbs-up"></i></a>';
              }else if(row.estado==3){
                var html='<a class="btn btn-danger cambiar" style="color: white" data-i='+data+'>Anulado</a>';
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
  ip=i;
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
		 		$('.estado').html("Cancelado");
		 	}else if(obj["data"][0].estado_gas==2){
		 		$('.estado').html("Abono");
		 	}else if(obj["data"][0].estado_gas==3){
		 		$('.estado').html("Anulado");
		 	}

			$('.valor').html('$'+formaterNumeroDecimales(obj["data"][0].valor_gas));
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
					$('#Vpendientes').html('$'+formaterNumeroDecimales(obj["suma"][i].total));
				}if(obj["suma"][i].estado==1){
					$('#Vcancelador').html('$'+formaterNumeroDecimales(obj["suma"][i].total));
				}if(obj["suma"][i].estado==2){
					$('#Vabonos').html('$'+formaterNumeroDecimales(obj["suma"][i].total));
				}if(obj["suma"][i].estado==3){
					$('#Vanulado').html('$'+formaterNumeroDecimales(obj["suma"][i].total));
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

function registrar_abono(action,datos) {
  if(ip==0){
    ohSnap('Error desconocido.',{color: 'red'});
    return false;
  }
  gelocalizacion();
  var formData = new FormData();
  formData=crearObjetoFormData(datos);
  formData.append('idGasto',ip);
  formData.append('latitud',latitud);
  formData.append('longitud',longitud);
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
            cargar_gasto();
            $('#modalAbono').modal("hide");
            $('#confirmAbonar').modal("hide");
            $('#gastoModal').modal("hide");
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
var latitudCerrar=0;
var longitudCerrar=0;
$(document).ready(function() {
	gelocalizacioncerrar();
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

	$('#consultar').on('click', function () {
    	cargar_reporte();
  	});

	$('#cerrarTodo').on('click', function () {
       BootstrapDialog.show({
            title: '<h6 style="color:black">Esta seguro que deseà cerrar todo!</h6>',
            message: '<ul><li type="disc">Abstengase de realizar esta funcion si no es un dia no trabajable</li></ul>',
            type: BootstrapDialog.TYPE_WARNING,
			draggable: true,
            buttons: [{
                label: 'Si',
                cssClass: 'btn-success',
                action: function(dialogRef){
                    cerrarTodo();
                    dialogRef.close();
                }
            }]
        });

    	$(".modal-backdrop").removeClass("modal-backdrop");
  	});
  	
});

function geo_successCoorCerrar(position) {
  latitudCerrar=position.coords.latitude;
  longitudCerrar=position.coords.longitude;
  $(".locationCoor").html('<input hidden value="'+latitudCerrar+'" name="latitud"><input hidden value="'+longitudCerrar+'" name="longitud">');
}

function geo_errorCoorCerrar() {
  alert("Si no conocemos tu ubicacion puede generar errores a la de hacer tu cierre");
}

function gelocalizacioncerrar(){
  alert("Por favor permita la localizacion, Si no conocemos tu ubicacion puede generar errores a la de hacer tu cierre");
  var geo_optionscoorCerrar = {
    enableHighAccuracy: true, 
    maximumAge        : 30000, 
    timeout           : 27000
  };

  var wpid = navigator.geolocation.getCurrentPosition(geo_successCoorCerrar, geo_errorCoorCerrar, geo_optionscoorCerrar);
}

function cerrarTodo(success=0){
	
	$.ajax({
      data:{	
		'latitud':latitudCerrar,
		'logitud':longitudCerrar
      },
      url: "index.php?c=cerrar&a=cerrarTodo",
      type: "post",
      success:function(e){
          var obj = JSON.parse(e);
          if(obj["error"]!=0){
            ohSnap('Error desconocido.',{color: 'red'});
          }else if(obj["error"]==0){
          	ohSnap('Se cerro correctamente.',{color: 'green'});
          }else{
            ohSnap('Error desconocido de sistema.',{color: 'red'});
          }
      },
      error:function(){
          ohSnap('Error desconocido de sistema',{color: 'red'});
      }
  });
}

function cargar_reporte(){
	if($('#codigo').val()==0 && $('#Fecha_ini').val()=="" && $('#Fecha_fin').val()=="" && $('#Estado').val()==111){
		ohSnap('Tiene que selecionar un filtro.',{color: 'red'});
		shake($('#codigo'));
		shake($('#Fecha_ini'));
		shake($('#Fecha_fin'));
		return false;
	}
    if ( $.fn.dataTable.isDataTable( '#datahistoria' ) ) {
      $("#datahistoria").dataTable().fnDestroy();
    }
    var MY_AJAX_ACTION_URL = "index.php?c=cerrar&a=cargar_reporte";
    table = $('#datahistoria').DataTable({
        "autoWidth": true,
        "ajax": {
            "data": {
	            'codigo':$('#codigo').val(),
	            'Estado':$('#Estado').val(),
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
        "info": false,
        "search": true,
        "sort": true,
        "stripeClasses": [ "odd nutzer_tr", "even nutzer_tr"],
        "columns": [
          { data: 'nombre' },
          { data: 'fecha' },
          { data: 'id' }
      ],
      "columnDefs": [{
           "targets": 0,
           "data": "nombre",
           "render": function ( data, type, row, meta ) {
              $(".tittle-vendedor").html('<i class="fas fa-route icon-btn"></i> '+row.codigo);
              if(row.validar==0){
              	return '<a class="btn-validar" data-usu="'+row.id+'" data-tipo="'+row.tipo+'" data-fecha="'+row.fecha+'"><i class="fas fa-user-tie"></i> '+data+"<h6 class='InvalTable'>Sin validar <i class='fas fa-thumbs-down'></i></h6></a>";
              }else{
              	return '<i class="fas fa-user-tie"></i> '+data+"<h6 class='valTable'>Validado <i class='fas fa-thumbs-up'></i></h6>";
              }
              
           }
         },{
           "targets": 1,
           "data": "fecha",
           "render": function ( data, type, row, meta ) {
              var fecha = new Date(data);
              var html="";
              var dia  = fecha.getDate();
              var diaSemana  = fecha.getDay();
			  var mes  = fecha.getMonth();
			  var anio = fecha.getFullYear();
			  switch (diaSemana) {
				  case 1:
				  	html+="Lunes, "+dia+" de";
				  break;
				  case 2:
				  	html+="Martes, "+dia+" de";
				  break;
				  case 3:
				  	html+="Miércoles, "+dia+" de";
				  break;
				  case 4:
				  	html+="Jueves, "+dia+" de";
				  break;
				  case 5:
				  	html+="Viernes, "+dia+" de";
				  break;
				  case 6:
				  	html+="Sábado, "+dia+" de";
				  break;
				  case 0:
				  	html+="Domingo, "+dia+" de";
				  break;
				}
				switch (mes) {
				  case 0:
				  	html+=" Enero de "+anio;
				  break;
				  case 1:
				  	html+=" Febrero de "+anio;
				  break;
				  case 2:
				  	html+=" Marzo de "+anio;
				  break;
				  case 3:
				  	html+=" Abril de "+anio;
				  break;
				  case 4:
				  	html+=" Mayo de "+anio;
				  break;
				  case 5:
				  	html+=" Junio de "+anio;
				  break;
				  case 6:
				  	html+=" Julio de "+anio;
				  break;
				  case 7:
				  	html+=" Agosto de "+anio;
				  break;
				  case 8:
				  	html+=" Septiembre de "+anio;
				  break;
				  case 9:
				  	html+=" Octubre de "+anio;
				  break;
				  case 10:
				  	html+=" Noviembre de "+anio;
				  break;
				  case 11:
				  	html+=" Diciembre de "+anio;
				  break;
				}

				if(row.cerrado==0){
	              	html+="<h6 class='InvalTable'>Pediente por cerrar <i class='fas fa-times-circle'></i></h6>";
	            }else{
	              	html+="<h6 class='valTable'>Cerrado</h6>";
	            }
              return html;
           }
         },{
           "targets": 2,
           "data": "id",
           "render": function ( data, type, row, meta ) {
              return '<a class="verDetalle" data-ver="0" data-id="'+data+'" data-usu="'+row.usu+'" data-fecha="'+row.fecha+'" data-tipo="'+row.tipo+'" data-cerrado="'+row.cerrado+'" data-vali="'+row.validar+'"><i class="fas fa-search-plus"></i> Detalle</a><div class="containerDetalle'+data+'" ></div>';
           }
         }],
        "processing": true,
        "serverSide": true,
        "pageLength" : 50,
        drawCallback: function () {
       		$('.verDetalle').on('click', function () {
       			var id = $(this).attr("data-id");
       			var usu = $(this).attr("data-usu");
       			var ver = $(this).attr("data-ver");
       			var fecha = $(this).attr("data-fecha");
            var tipo= $(this).attr("data-tipo");
            var cerrado=$(this).attr("data-cerrado");
            var vali=$(this).attr("data-vali");
       			fecha = new Date(fecha);
       			var mes=parseInt(fecha.getMonth());
       			mes+=1;
       			fecha=fecha.getFullYear()+"-"+mes+"-"+fecha.getDate();
       			if(ver==0){
       				ContenedorDetalle(id,usu,fecha,tipo,cerrado,vali);
       				$(this).attr("data-ver",1);	
       			}else{
       				$(".containerDetalle"+id).html("");
       				$(this).attr("data-ver",0);
       			}
  			  });

          $('.btn-validar').on('click', function () {
              var usu=$(this).attr('data-usu');
              var tipo=$(this).attr('data-tipo');
              var fecha=$(this).attr('data-fecha');
              validarVendedor(usu,tipo,fecha);
          });
        }
    });
}

function validarVendedor(usu,tipo,fecha){
  usu=parseInt(usu);
  $.ajax({
      data: {
        'usu':usu,
        'tipo':tipo,
        'fecha':fecha
      },
      url: "index.php?c=cerrar&a=validarCierre",
      type: "post",
      success:function(e){
        var obj = JSON.parse(e);
        if(obj['error']==1){
            ohSnap(obj['mensaje'],{color: 'red'});
        }else if(obj['error']==0){
            ohSnap('Se valido correctamente',{color: 'green'});
            cargar_reporte();
        }else{
          ohSnap('Error desconocido',{color: 'red'});
        }
      },
      error:function(){
          ohSnap('Error desconocido',{color: 'red'});
      }
  });
}

function ajaxVenta(usu,fecha){
	if ( $.fn.dataTable.isDataTable( '#dataVenta' ) ) {
      $("#dataVenta").dataTable().fnDestroy();
    }
    var MY_AJAX_ACTION_URL = "index.php?c=cerrar&a=ventas";
    table = $('#dataVenta').DataTable({
        "autoWidth": true,
        "ajax": {
        	"data": {
	            'usu':usu,
              'fecha':fecha
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
        "info": false,
        "search": true,
        "sort": true,
        "stripeClasses": [ "odd nutzer_tr", "even nutzer_tr"],
        "columns": [
          { data: 'codigo' },
          { data: 'Cliente' },
          { data: 'ValorSin' },
          { data: 'ValorCon' },
          { data: 'Interese' },
          { data: 'Producto' },
          { data: 'estado' }
      ],
      "columnDefs": [
        {
           "targets": 6,
           "data": "estado",
           "render": function ( data, type, row, meta ) {
              var input="";
              if(data==1){
                input='<input type="checkbox" data-estado="'+row.id+'" checked data-toggle="toggle" data-size="sm" class="estado_venta">';
              }else{
                input='<input type="checkbox" data-estado="'+row.id+'" data-toggle="toggle" data-size="sm" class="estado_venta">';
              }
             return input;
           }
         }
      ],
        "processing": true,
        "serverSide": true,
        "pageLength" : 10,
        drawCallback: function () {
          $('.estado_venta').on('click', function () {
            var id_v=$(this).attr("data-estado");
            var estado=1;
            if( $(this).is(':checked') ){
              estado=0;
            } else {
              estado=1;
            }
            cambiar_estado(id_v,estado);
          });
        }
    });
}

function cambiar_estado(id,estado){
  $.ajax({
    data: {
      'id':id,
      'estado':estado
    },
    url: "index.php?c=cerrar&a=cambioEstadoVentas",
    type: "post",
    success:function(e){
      var data = JSON.parse(e);
      if(data["error"]==0){
        ohSnap('Se cambio el estado corretamente',{color: 'green'});
      }else{
        error_501();
        cargar_usuarios();
      }
    },
    error:function(){
        ohSnap('Error desconocido',{color: 'red'});
    }
  });
}

function ajaxNotaVenta(usu,fecha){
	 if ( $.fn.dataTable.isDataTable( '#dataNotaVenta' ) ) {
      $("#dataNotaVenta").dataTable().fnDestroy();
    }
    var MY_AJAX_ACTION_URL = "index.php?c=cerrar&a=notaVentas";
    table = $('#dataNotaVenta').DataTable({
        "autoWidth": true,
        "ajax": {
        	"data": {
	            'usu':usu,
              'fecha':fecha
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
        "info": false,
        "search": true,
        "sort": true,
        "stripeClasses": [ "odd nutzer_tr", "even nutzer_tr"],
        "columns": [
          { data: 'nota' },
          { data: 'nombre' }
      ],
      "columnDefs": [],
        "processing": true,
        "serverSide": true,
        "pageLength" : 10,
        drawCallback: function () {
        }
    });
}

function ajaxRecuado(usu,fecha){
	 if ( $.fn.dataTable.isDataTable( '#dataRecuado' ) ) {
      $("#dataRecuado").dataTable().fnDestroy();
    }
    var MY_AJAX_ACTION_URL = "index.php?c=cerrar&a=recaudo";
    table = $('#dataRecuado').DataTable({
        "autoWidth": true,
        "ajax": {
        	"data": {
	            'usu':usu,
              'fecha':fecha
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
        "info": false,
        "search": true,
        "sort": true,
        "stripeClasses": [ "odd nutzer_tr", "even nutzer_tr"],
        "columns": [
          	{ data: 'Cliente'},
			{ data: 'Cuota'},
			{ data: 'Pago'},
			{ data: 'faltante'},
			{ data: 'Estado'},
			{ data: 'vencidos'},
			{ data: 'atrasada'},
			{ data: 'Venta'}
      ],
      "columnDefs": [{
           "targets": 2,
           "data": "Pago",
           "render": function ( data, type, row, meta ) {
              return "$"+formaterNumeroDecimales(data);
           }
          }],
        "processing": true,
        "serverSide": true,
        "pageLength" : 10,
        drawCallback: function () {
          
        }
    });
}

function ajaxGasto(usu,fecha){
  
	if ( $.fn.dataTable.isDataTable( '#dataGasto' ) ) {
      $("#dataGasto").dataTable().fnDestroy();
    }
    var MY_AJAX_ACTION_URL = "index.php?c=cerrar&a=gasto";
    table = $('#dataGasto').DataTable({
        "autoWidth": true,
        "ajax": {
        	"data": {
	            'usu':usu,
              'fecha':fecha
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
        "info": false,
        "search": true,
        "sort": true,
        "stripeClasses": [ "odd nutzer_tr", "even nutzer_tr"],
        "columns": [
			{ data: 'id'},
			{ data: 'Descripcion'},
			{ data: 'Valor'},
			{ data: 'Tipo'},
			{ data: 'Autor'},
      { data: 'id' }
      ],
      "columnDefs": [{
           "targets": 5,
           "data": "id",
           "render": function ( data, type, row, meta ) {
              if(row.estado==0){
                var html='<a class="btn btn-warning cambiar" data-i='+data+'><i class="fas fa-exclamation"></i> Gasto generado</a>';
              }else if(row.estado==2){
                var html='Este gasto ha sido abonado.';
              }else if(row.estado==1){
                var html='<a class="btn btn-danger cambiar" style="color: white" data-i='+data+'><i class="fas fa-times-circle"> Cancelado</i></a>';
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
            CambiarGasto(i,usu,fecha);
          });
        }
    });
}

function ajaxRetiro(usu,fecha){
  if ( $.fn.dataTable.isDataTable( '#dataretiro' ) ) {
   $("#dataretiro").dataTable().fnDestroy();
  }
    var MY_AJAX_ACTION_URL = "index.php?c=cerrar&a=retiro";
    table = $('#dataretiro').DataTable({
        "autoWidth": true,
        "ajax": {
          "data": {
            'usu':usu,
            'fecha':fecha
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
        "info": false,
        "search": false,
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


function CambiarGasto(i,usu,fecha){
  $.ajax({
      data: {
        'gas':i
      },
      url: "index.php?c=cerrar&a=cambiar_estado_gasto",
      type: "post",
      success:function(e){
        var obj = JSON.parse(e);
        if(obj['error']==1){
          ohSnap(obj['mensaje'],{color: 'red'});
        }else if(obj['error']==0){
          ohSnap('Se cambio correctamente',{color: 'green'});
          ajaxGasto(usu,fecha);
        }
      },
      error:function(){
          ohSnap('Error desconocido',{color: 'red'});
      }
  });
}


function despleque(e,tab,usu,fecha){
	  if($(e).hasClass('fa-chevron-down')){
	    $(e).parent(".card-header").parent(".card").find(".divDesplegableContainer").show("slow");
	    $(e).removeClass('fa-chevron-down');
	    $(e).addClass('fa-chevron-up');
	    if(tab==1){
	    	ajaxNotaVenta(usu,fecha);
	    }else if(tab==2){
	    	ajaxVenta(usu,fecha);
	    }else if(tab==3){
	    	ajaxRecuado(usu,fecha);
	    }else if(tab==4){
	    	ajaxGasto(usu,fecha);
	    }else if(tab==5){
        ajaxRetiro(usu,fecha);
      }
	  }else if($(e).hasClass('fa-chevron-up')){
	    $(e).parent(".card-header").parent(".card").find(".divDesplegableContainer").hide("slow");
	    $(e).addClass('fa-chevron-down');
	    $(e).removeClass('fa-chevron-up');
	  }
	
}

function Rechazar(usu,fecha){
    $.ajax({
      data: {
        'usu':usu,
        'latitud':latitudCerrar,
        'logitud':longitudCerrar,
        'fecha':fecha
      },
      url: "index.php?c=cerrar&a=rechazar",
      type: "post",
      success:function(e){
        var obj = JSON.parse(e);
        ohSnap('Se cerro correctamente',{color: 'green'});
        cargar_reporte();
      },
      error:function(){
          ohSnap('Error desconocido',{color: 'red'});
      }
  });
}

function ContenedorDetalle(id,usu,fecha,tipo,cerrado,vali){
  	$.ajax({
	    data: {
	      'usu':usu,
	      'fecha':fecha
	    },
	    url: "index.php?c=cerrar&a=detalle",
	    type: "post",
	    success:function(e){
	    	var obj = JSON.parse(e);
	    	if(obj.length==0){
	    		ohSnap('No se encontraron datos.',{color: 'red'});
	    	}else{
	    		$(".containerDetalle"+id).html(dibujarContenedorDetalle(obj,usu,tipo,cerrado,fecha,vali));	
	    	}
	    },
	    error:function(){
	        ohSnap('Error desconocido',{color: 'red'});
	    }
	});
}

function formateNumero(numero){
	var valor = numero.split(".", 2);
	if(valor.length==2){
		numero=formatValor(valor[0])+","+valor[1];
	}
	return numero;
}

function dibujarContenedorDetalle(obj,usu,tipo,cerrado,fecha,vali){

	var pagado=obj[0]['Pagado'];
	var ValorArecuado=obj[0]['ValorArecuado'];
	var tipoDiferecia='style="color: red"';

	obj[0]['Pagado']=formateNumero(obj[0]['Pagado']);
	obj[0]['ValorArecuado']=formateNumero(obj[0]['ValorArecuado']);
	obj[0]['gasto']=formateNumero(obj[0]['gasto']);

	var diferencia= parseFloat(pagado)  - parseFloat(ValorArecuado);
	diferencia=formaterNumeroDecimales(diferencia.toString());

	var sinpaga= parseInt(obj[0]['totalRuta'])  - parseInt(obj[0]['cobros']);

	if(Math.sign(diferencia)==1){
		tipoDiferecia='style="color: green"';
		diferencia="+$"+diferencia;
	}else{
		diferencia="$"+diferencia;
	}

	var html="";
		html+='<div class="container container-data">';
			html+='<hr>';
			html+='<h5 class="tittle-detalle">Cobros</h5>';
			html+='<br>';
			html+='<div class="row">';
				html+='<div class="col-md-6">';
					html+='<label class="datoCobro">Numero de cobros:</label><label class="result">'+formatValor(obj[0]['totalRuta'])+'</label>';
				html+='</div>';
				html+='<div class="col-md-6">';
					html+='<label class="datoCobro" >Meta a recaudar:</label><label class="result">$'+obj[0]['ValorArecuado']+'</label>';
				html+='</div>';
			html+='</div>';

			html+='<div class="row">';
				html+='<div class="col-md-6">';
					html+='<label class="datoCobro" style="color: green">Pagado:</label><label class="result" style="color: green">'+formatValor(obj[0]['cobros'])+'</label>';
				html+='</div>';
				html+='<div class="col-md-6">';
					html+='<label class="datoCobro" style="color: green">Total recaudado:</label><label class="result" style="color: green">$'+obj[0]['Pagado']+'</label>';
				html+='</div>';
			html+='</div>';

			html+='<div class="row">';
				html+='<div class="col-md-6">';
					html+='<label class="datoCobro" style="color: red">Sin pagar:</label><label class="result" style="color: red">'+formatValor(sinpaga.toString())+'</label>';
				html+='</div>';
				html+='<div class="col-md-6">';
					html+='<label class="datoCobro" '+tipoDiferecia+'>Diferencia:</label><label class="result" '+tipoDiferecia+'>'+diferencia+'</label>';
				html+='</div>';
			html+='</div>';
			///////////resumen
			html+='<hr>';
			html+='<h5 class="tittle-detalle">Resumen</h5>';
			html+='<br>';

			html+='<div class="row">';
				html+='<div class="col-md-6">';
					html+='<label class="datoCobro">Saldo de inicio:</label><label class="result">$'+formaterNumeroDecimales(obj[0]["saldoInicial"])+'</label>';
				html+='</div>';
			html+='</div>';

			html+='<div class="row">';
				html+='<div class="col-md-6">';
					html+='<label class="datoCobro">Recuados('+formatValor(obj[0]["numRecaudo"])+'):</label><label class="result">$'+formaterNumeroDecimales(obj[0]["recaudo"])+'</label>';
				html+='</div>';
				html+='<div class="col-md-6">';
					html+='<label class="datoCobro">Total de cartera:</label><label class="result">$'+formaterNumeroDecimales(obj[0]["cartera"])+'</label>';
				html+='</div>';
			html+='</div>';

			html+='<div class="row">';
				html+='<div class="col-md-6">';
          html+='<label class="datoCobro">Nueva ventas('+formatValor(obj[0]["numnuevaVentas"])+'):</label><label class="result">$'+formatValor(obj[0]["nuevaVentas"])+'</label>';
        html+='</div>';
				html+='<div class="col-md-6">';
					html+='<label class="datoCobro">Total de cartera vencidas:</label><label class="result">$'+formaterNumeroDecimales(obj[0]["carteravencidas"])+'</label>';
				html+='</div>';
			html+='</div>';

			html+='<div class="row">';
				html+='<div class="col-md-6">';
          html+='<label class="datoCobro">Retiros('+formatValor(obj[0]["numretiros"])+'):</label><label class="result">$'+formaterNumeroDecimales(obj[0]["Retiros"])+'</label>';
        html+='</div>';
				html+='<div class="col-md-6">';
					html+='<label class="datoCobro">Revisado por:</label><label class="result">'+obj[0]["vali"]+'</label>';
				html+='</div>';
			html+='</div>';

			html+='<div class="row">';
				html+='<div class="col-md-6">';
					html+='<div class="row">';
						
						html+='<div class="col-md-12">';
							html+='<label class="datoCobro">Gastos:</label><label class="result">$'+formaterNumeroDecimales(obj[0]['gasto'])+'</label>';
						html+='</div>';
						html+='<div class="col-md-12">';
							html+='<label class="datoCobro">Saldo final:</label><label class="result">$'+formaterNumeroDecimales(obj[0]['caja'])+'</label>';
						html+='</div>';
						html+='<div class="col-md-12">';
							html+='<p class="span-text">(Saldo final+Recuados)-(gasto+venta+retiro)</p>';
						html+='</div>';

					html+='</div>';
				html+='</div>';
			html+='</div>';

      if(tipo==0 && cerrado!=0 && vali==0){
        html+='<button type="button" class="btn btn-danger offset-md-5" id="Rechazar" onclick="Rechazar('+usu+','+"'"+fecha+"'"+')">Rechazar <i class="fas fa-times-circle"></i></i></button>';
         html+='<hr>';
      }
      
     
			////nota
			html+='<div class="container-tab">';
				html+='<div class="card">';
				    html+='<h5 class="card-header card-header-primary text-center">Nota de ventas <i class="fas fa-chevron-down desplegue-btn" onclick="despleque(this,1,'+usu+','+"'"+fecha+"'"+')"></i></h5>';
				    html+='<div class="divDesplegableContainer" style="display: none;">';
				        html+='<div class="card-body card-body-primary">';
				        	html+='<div class="container-cerrar">';
								html+='<div class="table-responsive padding" >';
						            html+='<table id="dataNotaVenta" class="table table-bordred table-striped table-striped table-hover dt-responsive tablaNormal" style="width: 100%;">';
						                html+='<thead class="heade-table">';
						                  html+='<th class="text-color all campoNombre">Nota</th>';
						                  html+='<th class="text-color all">Cliente</th>';
						                html+='</thead>';
						                html+='<tbody>';
						                html+='</tbody>';
						            html+='</table>';
						        html+='</div>';
							html+='</div>';
				        html+='</div>';
				    html+='</div>';
				html+='</div>';
			html+='</div>';
			html+='<hr>';
			////Ventas
			html+='<div class="container-tab">';
				html+='<div class="card">';
				    html+='<h5 class="card-header card-header-primary text-center">Ventas <i class="fas fa-chevron-down desplegue-btn" onclick="despleque(this,2,'+usu+','+"'"+fecha+"'"+')"></i></h5>';
				    html+='<div class="divDesplegableContainer" style="display: none;">';
				        html+='<div class="card-body card-body-primary">';
				        	html+='<div class="container-cerrar">';
								html+='<div class="table-responsive padding" >';
						            html+='<table id="dataVenta" class="table table-bordred table-striped table-striped table-hover dt-responsive tablaNormal" style="width: 100%;">';
						                html+='<thead class="heade-table">';
						                  html+='<th class="text-color all"># Venta</th>';
						                  html+='<th class="text-color all">Cliente</th>';
						                  html+='<th class="text-color all">Valor (Sin interes)</th>';
						                  html+='<th class="text-color all">Valor (Con interes)</th>';
						                  html+='<th class="text-color all">Interese implicados</th>';
						                  html+='<th class="text-color all">Antiguedad cliente</th>';
                              html+='<th class="text-color all">Estado de la venta</th>';
						                html+='</thead>';
						                html+='<tbody>';
						                html+='</tbody>';
						            html+='</table>';
						        html+='</div>';
							html+='</div>';
				        html+='</div>';
				    html+='</div>';
				html+='</div>';
			html+='</div>';
			html+='<hr>';
			////Recuado
			html+='<div class="container-tab">';
				html+='<div class="card">';
				    html+='<h5 class="card-header card-header-primary text-center">Recuado <i class="fas fa-chevron-down desplegue-btn" onclick="despleque(this,3,'+usu+','+"'"+fecha+"'"+')"></i></h5>';
				    html+='<div class="divDesplegableContainer" style="display: none;">';
				        html+='<div class="card-body card-body-primary">';
				        	html+='<div class="container-cerrar">';
								html+='<div class="table-responsive padding" >';
						            html+='<table id="dataRecuado" class="table table-bordred table-striped table-striped table-hover dt-responsive tablaNormal" style="width: 100%;">';
						                html+='<thead class="heade-table">';
						                  html+='<th class="text-color all">Cliente</th>';
						                  html+='<th class="text-color all">Cuota</th>';
						                  html+='<th class="text-color all">Pago</th>';
						                  html+='<th class="text-color all">Cuota faltante</th>';
						                  html+='<th class="text-color all">Estado</th>';
						                  html+='<th class="text-color all">Dia vencidos</th>';
						                  html+='<th class="text-color all">Cuota atrasada</th>';
						                  html+='<th class="text-color all">Venta</th>';
						                html+='</thead>';
						                html+='<tbody>';
						                html+='</tbody>';
						            html+='</table>';
						        html+='</div>';
							html+='</div>';
				        html+='</div>';
				    html+='</div>';
				html+='</div>';
			html+='</div>';
			html+='<hr>';
			////Gasto
			html+='<div class="container-tab">';
				html+='<div class="card">';
				    html+='<h5 class="card-header card-header-primary text-center">Gasto <i class="fas fa-chevron-down desplegue-btn" onclick="despleque(this,4,'+usu+','+"'"+fecha+"'"+')"></i></h5>';
				    html+='<div class="divDesplegableContainer" style="display: none;">';
				        html+='<div class="card-body card-body-primary">';
				        	html+='<div class="container-cerrar">';
								html+='<div class="table-responsive padding" >';
						            html+='<table id="dataGasto" class="table table-bordred table-striped table-striped table-hover dt-responsive tablaNormal" style="width: 100%;">';
						                html+='<thead class="heade-table">';
						                  html+='<th class="text-color all"># Gasto</th>';
						                  html+='<th class="text-color all">Descripcion</th>';
						                  html+='<th class="text-color all">Valor</th>';
						                  html+='<th class="text-color all">Tipo de gasto</th>';
						                  html+='<th class="text-color all">Autor</th>';
                              html+='<th class="text-color all">Estado</th>';
						                html+='</thead>';
						                html+='<tbody>';
						                html+='</tbody>';
						            html+='</table>';
						        html+='</div>';
							html+='</div>';
				        html+='</div>';
				    html+='</div>';
				html+='</div>';
			html+='</div>';
			html+='<hr>';
			////Retiros
			html+='<div class="container-tab">';
				html+='<div class="card">';
				    html+='<h5 class="card-header card-header-primary text-center">Retiros <i class="fas fa-chevron-down desplegue-btn" onclick="despleque(this,5,'+usu+','+"'"+fecha+"'"+')"></i></h5>';
				    html+='<div class="divDesplegableContainer" style="display: none;">';
				        html+='<div class="card-body card-body-primary">';
				        	html+='<div class="container-cerrar">';
                    html+='<table id="dataretiro" class="table table-bordred table-striped table-striped table-hover tablaNormal" style="width: 100%;">';
                      html+='<thead class="heade-table">';
      							    html+='<th class="text-color">Retiro</th>';
                        html+='<th class="text-color">Fecha</th>';
                        html+='<th class="text-color">Descripcion</th>';
                        html+='<th class="text-color">Valor</th>';
                        html+='<th class="text-color">Autor</th>';
                       html+='</thead>';
                       html+='<tbody>';
                       html+='</tbody>';
                    html+='</table>'
							   html+='</div>';
				        html+='</div>';
				    html+='</div>';
				html+='</div>';
			html+='</div>';
			

		html+='</div>';
		return html;
}	


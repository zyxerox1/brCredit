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

	$('#consultar').on('click', function () {
    	cargar_reporte();
  	});
});

function cargar_reporte(){
	if($('#codigo').val()==0){
		ohSnap('Tiene que selecionar una ruta.',{color: 'red'});
		shake($('#codigo'));
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
              if(row.cerrado==0){
              	return '<i class="fas fa-user-tie"></i> '+data+"<h6 class='InvalTable'>Sin validar <i class='fas fa-thumbs-down'></i></h6>";
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
				  case 7:
				  	html+="Domingo, "+dia+" de";
				  break;
				}
				switch (mes) {
				  case 1:
				  	html+=" Enero de "+anio;
				  break;
				  case 2:
				  	html+=" Febrero de "+anio;
				  break;
				  case 3:
				  	html+=" Marzo de "+anio;
				  break;
				  case 4:
				  	html+=" Abril de "+anio;
				  break;
				  case 5:
				  	html+=" Mayo de "+anio;
				  break;
				  case 6:
				  	html+=" Junio de "+anio;
				  break;
				  case 7:
				  	html+=" Julio de "+anio;
				  break;
				  case 8:
				  	html+=" Agosto de "+anio;
				  break;
				  case 9:
				  	html+=" Septiembre de "+anio;
				  break;
				  case 10:
				  	html+=" Octubre de "+anio;
				  break;
				  case 11:
				  	html+=" Noviembre de "+anio;
				  break;
				  case 12:
				  	html+=" Diciembre de "+anio;
				  break;
				}
				if(row.id==0){
					html+=" (Hoy)"
				}
              return html;
           }
         },{
           "targets": 2,
           "data": "id",
           "render": function ( data, type, row, meta ) {
              return '<a class="verDetalle" data-ver="0" data-id="'+data+'" data-usu="'+row.usu+'"><i class="fas fa-search-plus"></i> Detalle</a><div class="containerDetalle'+data+'" ></div>';
           }
         }],
        "processing": true,
        "serverSide": true,
        "pageLength" : 200,
        drawCallback: function () {
       		$('.verDetalle').on('click', function () {
       			var id = $(this).attr("data-id");
       			var usu = $(this).attr("data-usu");
       			var ver = $(this).attr("data-ver");
       			if(ver==0){
       				ContenedorDetalle(id,usu);
       				$(this).attr("data-ver",1);	
       			}else{
       				$(".containerDetalle"+id).html("");
       				$(this).attr("data-ver",0);
       			}
  			});
        }
    });
}

function ajaxVenta(usu){
	if ( $.fn.dataTable.isDataTable( '#dataVenta' ) ) {
      $("#dataVenta").dataTable().fnDestroy();
    }
    var MY_AJAX_ACTION_URL = "index.php?c=cerrar&a=ventas";
    table = $('#dataVenta').DataTable({
        "autoWidth": true,
        "ajax": {
        	"data": {
	            'usu':usu
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
          { data: 'id' },
          { data: 'Cliente' },
          { data: 'ValorSin' },
          { data: 'ValorCon' },
          { data: 'Interese' },
          { data: 'Producto' }
      ],
      "columnDefs": [],
        "processing": true,
        "serverSide": true,
        "pageLength" : 10,
        drawCallback: function () {
        }
    });
}

function ajaxNotaVenta(usu){
	 if ( $.fn.dataTable.isDataTable( '#dataNotaVenta' ) ) {
      $("#dataNotaVenta").dataTable().fnDestroy();
    }
    var MY_AJAX_ACTION_URL = "index.php?c=cerrar&a=notaVentas";
    table = $('#dataNotaVenta').DataTable({
        "autoWidth": true,
        "ajax": {
        	"data": {
	            'usu':usu
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

function ajaxRecuado(usu){
	 if ( $.fn.dataTable.isDataTable( '#dataRecuado' ) ) {
      $("#dataRecuado").dataTable().fnDestroy();
    }
    var MY_AJAX_ACTION_URL = "index.php?c=cerrar&a=recaudo";
    table = $('#dataRecuado').DataTable({
        "autoWidth": true,
        "ajax": {
        	"data": {
	            'usu':usu
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
      "columnDefs": [],
        "processing": true,
        "serverSide": true,
        "pageLength" : 10,
        drawCallback: function () {
        }
    });
}

function ajaxGasto(usu){
	if ( $.fn.dataTable.isDataTable( '#dataGasto' ) ) {
      $("#dataGasto").dataTable().fnDestroy();
    }
    var MY_AJAX_ACTION_URL = "index.php?c=cerrar&a=gasto";
    table = $('#dataGasto').DataTable({
        "autoWidth": true,
        "ajax": {
        	"data": {
	            'usu':usu
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
			{ data: 'Autor'}
      ],
      "columnDefs": [],
        "processing": true,
        "serverSide": true,
        "pageLength" : 10,
        drawCallback: function () {
        }
    });
}


function despleque(e,tab,usu){
	  console.log("ddd");
	  if($(e).hasClass('fa-chevron-down')){
	    $(e).parent(".card-header").parent(".card").find(".divDesplegableContainer").show("slow");
	    $(e).removeClass('fa-chevron-down');
	    $(e).addClass('fa-chevron-up');
	    if(tab==1){
	    	ajaxNotaVenta(usu);
	    }else if(tab==2){
	    	ajaxVenta(usu);
	    }else if(tab==3){
	    	ajaxRecuado(usu);
	    }else if(tab==4){
	    	ajaxGasto(usu);
	    }
	  }else if($(e).hasClass('fa-chevron-up')){
	    $(e).parent(".card-header").parent(".card").find(".divDesplegableContainer").hide("slow");
	    $(e).addClass('fa-chevron-down');
	    $(e).removeClass('fa-chevron-up');
	  }
	
}

function ContenedorDetalle(id,usu){
  	$.ajax({
	    data: {
	      'usu':usu
	    },
	    url: "index.php?c=cerrar&a=detalle",
	    type: "post",
	    success:function(e){
	    	var obj = JSON.parse(e);
			$(".containerDetalle"+id).html(dibujarContenedorDetalle(obj,usu));
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

function dibujarContenedorDetalle(obj,usu){

	var pagado=obj[0]['Pagado'];
	var ValorArecuado=obj[0]['ValorArecuado'];
	var tipoDiferecia='style="color: red"';

	obj[0]['Pagado']=formateNumero(obj[0]['Pagado']);
	obj[0]['ValorArecuado']=formateNumero(obj[0]['ValorArecuado']);
	obj[0]['gasto']=formateNumero(obj[0]['gasto']);

	var diferencia= parseFloat(pagado)  - parseFloat(ValorArecuado);
	diferencia=formateNumero(diferencia.toString());

	var sinpaga= parseInt(obj[0]['totalRuta'])  - parseInt(obj[0]['cobros']);

	if(Math.sign(diferencia)==1){
		tipoDiferecia='style="color: green"';
		diferencia="+$"+diferencia;
	}else{
		diferencia="-$"+diferencia;
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
					html+='<label class="datoCobro">Saldo de inicio:</label><label class="result">$'+formatValor("0")+'</label>';
				html+='</div>';
			html+='</div>';

			html+='<div class="row">';
				html+='<div class="col-md-6">';
					html+='<label class="datoCobro">Recuados('+formatValor("40")+'):</label><label class="result">+$'+formatValor("0")+'</label>';
				html+='</div>';
				html+='<div class="col-md-6">';
					html+='<label class="datoCobro">Total de cartera:</label><label class="result">$'+formatValor("0")+'</label>';
				html+='</div>';
			html+='</div>';

			html+='<div class="row">';
				html+='<div class="col-md-6">';
					html+='<label class="datoCobro">Inversiones('+formatValor("0")+'):</label><label class="result">'+formatValor("0")+'</label>';
				html+='</div>';
				html+='<div class="col-md-6">';
					html+='<label class="datoCobro">Total de cartera vencidas:</label><label class="result">$'+formatValor("0")+'</label>';
				html+='</div>';
			html+='</div>';

			html+='<div class="row">';
				html+='<div class="col-md-6">';
					html+='<label class="datoCobro">Nueva ventas:</label><label class="result">$'+formatValor("0")+'</label>';
				html+='</div>';
				html+='<div class="col-md-6">';
					html+='<label class="datoCobro">Revisado por:</label><label class="result">'+'Administrador'+'</label>';
				html+='</div>';
			html+='</div>';

			html+='<div class="row">';
				html+='<div class="col-md-6">';
					html+='<div class="row">';
						html+='<div class="col-md-12">';
							html+='<label class="datoCobro">Retiros:</label><label class="result">$'+formatValor("0")+'</label>';
						html+='</div>';
						html+='<div class="col-md-12">';
							html+='<label class="datoCobro">Gastos:</label><label class="result">$'+formatValor(obj[0]['gasto'])+'</label>';
						html+='</div>';
						html+='<div class="col-md-12">';
							html+='<label class="datoCobro">Saldo final:</label><label class="result">$'+formatValor("0")+'</label>';
						html+='</div>';
						html+='<div class="col-md-12">';
							html+='<p class="span-text">(Saldo final+Recuados-inversiones)-(gasto+venta+retiro)</p>';
						html+='</div>';

					html+='</div>';
				html+='</div>';
				html+='<div class="col-md-6">';
					html+='<div class="form-group">'
						html+='<label for="Observaciones">Observaciones</label>';
						html+='<textarea class="form-control" id="Observaciones" disabled="disabled"></textarea>';
					html+='</div>';
				html+='</div>';
			html+='</div>';

			////nota
			html+='<div class="container-tab">';
				html+='<div class="card">';
				    html+='<h5 class="card-header card-header-primary text-center">Nota de ventas <i class="fas fa-chevron-down desplegue-btn" onclick="despleque(this,1,'+usu+')"></i></h5>';
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
				    html+='<h5 class="card-header card-header-primary text-center">Ventas <i class="fas fa-chevron-down desplegue-btn" onclick="despleque(this,2,'+usu+')"></i></h5>';
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
						                  html+='<th class="text-color all">Producto</th>';
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
				    html+='<h5 class="card-header card-header-primary text-center">Recuado <i class="fas fa-chevron-down desplegue-btn" onclick="despleque(this,3,'+usu+')"></i></h5>';
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
				    html+='<h5 class="card-header card-header-primary text-center">Gasto <i class="fas fa-chevron-down desplegue-btn" onclick="despleque(this,4,'+usu+')"></i></h5>';
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
				    html+='<h5 class="card-header card-header-primary text-center">Retiros <i class="fas fa-chevron-down desplegue-btn"></i></h5>';
				    html+='<div class="divDesplegableContainer" style="display: none;">';
				        html+='<div class="card-body card-body-primary">';
				        	html+='<div class="container-cerrar">';
								
							html+='</div>';
				        html+='</div>';
				    html+='</div>';
				html+='</div>';
			html+='</div>';
			

		html+='</div>';
		return html;
}	


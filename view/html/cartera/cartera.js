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
      cliente();
      totales();
    	cargar_reporte();
  	});

  $('#consultar2').on('click', function () {
      cargar_reporte();
    });
});

function cliente(){
  var usu = $("#codigo").val();
  $.ajax({
      data: {'id_usu':usu},
      url: "index.php?c=cartera&a=obtener_filtro_cliente",
      type: "post",
      success:function(e){
        var clientes = JSON.parse(e);
        clientes.forEach(element => $('#Nombre').append("<option value='"+element["id"]+"' >"+element["cliente"]+" - "+element["documento"]+"</option>"));
        $('#Nombre').prop( "disabled", false );
      },
      error:function(){
          ohSnap('Error ha iniciar session',{color: 'red'});
      }
    });
}

function totales(){
  var usu = $("#codigo").val();
  $.ajax({
      data: {'usu':usu},
      url: "index.php?c=cartera&a=obtenerDatosTotalCartera",
      type: "post",
      success:function(e){
        var datos = JSON.parse(e);
        $(".totalNroCar").html("Total cartera("+datos[0]['totalNroCar']+")");
        $(".totalCartera").html("$"+formaterNumeroDecimales(datos[0]['totalCartera']));
        $(".totalCarVen").html("Total cartera ven("+datos[0]['totalCarVenNro']+")");
        $(".totalCarVenNro").html("$"+formaterNumeroDecimales(datos[0]['totalCarVen']));
        $(".totalCarAtra").html("$"+formaterNumeroDecimales(datos[0]['totalCarAtra']));
        $(".totalCarAtraNro").html("Total cartera atras("+datos[0]['totalCarAtraNro']+")");

      },
      error:function(){
          ohSnap('Error ha iniciar session',{color: 'red'});
      }
    });
}

function cargar_reporte(){
  if ( $.fn.dataTable.isDataTable( '#datacartera' ) ) {
   $("#datacartera").dataTable().fnDestroy();
  }
	var usu = $("#codigo").val();
	if($('#codigo').val()==0){
		ohSnap('Tiene que selecionar una ruta.',{color: 'red'});
		shake($('#codigo'));
		return false;
	}
	var MY_AJAX_ACTION_URL = "index.php?c=cartera&a=cargar";
    table = $('#datacartera').DataTable({
        "autoWidth": true,
        "fixedHeader": {
            "header": true,
            "footer": true
        },
        "ajax": {
        	"data": {
	            'usu':usu,
              'Nombre' : $('#Nombre').val(),
              'Estado' : $('#Estado').val(),
              'nrocouta' : $('#nrocouta').val(),
              'Numdia' : $('#Numdia').val(),
              'Fecha_ini' : $('#Fecha_ini').val(),
              'Fecha_fin' : $('#Fecha_fin').val(),
              'Fecha_crea' : $('#Fecha_crea').val()
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
          { data: 'Cod'},
          { data: 'Cliente' },
          { data: 'Estado' },
          { data: 'Apagar' },
          { data: 'Pagado' },
          { data: 'Debe' },
          { data: 'Nrocouta' },
          { data: 'Diasven' },
          { data: 'Coutareg' },
          { data: 'Coutaatra' },
          { data: 'Fechaini' },
          { data: 'Fechafin' },
          { data: 'Fechacreacion' },
          { data: 'Refinanciada' },
      ],
      "columnDefs": [{
           "targets": 2,
           "data": "Estado",
           "render": function ( data, type, row, meta ) {
              $(".tittle-vendedor").html('<i class="fas fa-route icon-btn"></i> '+row.Cliente);
              if(row.Estado=="Pediente"){
                return "<h6 style='color:green'>"+data+"</h6>";
              }else{
                return "<h6 style='color:red'>"+data+"</h6>";;
              }
              
           }
         },{
           "targets": 3,
           "data": "Apagar",
           "render": function ( data, type, row, meta ) {
              return formaterNumeroDecimales(data);
           }
         },{
           "targets": 4,
           "data": "Pagado",
           "render": function ( data, type, row, meta ) {
              return formaterNumeroDecimales(data);
           }
         },{
           "targets": 5,
           "data": "Debe",
           "render": function ( data, type, row, meta ) {
              return formaterNumeroDecimales(data);
           }
         },{
           "targets": 7,
           "data": "Debe",
           "render": function ( data, type, row, meta ) {
             if(data==0){
                return "<h6 style='color:green'>"+data+"</h6>";
              }else{
                return "<h6 style='color:red'>"+data+"</h6>";;
              }
           }
         }],
        "processing": true,
        "serverSide": true,
        "pageLength" : 10,
        drawCallback: function () {

        }
    });
	$(".container-result").show();
}
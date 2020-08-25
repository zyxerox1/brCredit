$(document).ready(function() {
    $("#input-b5").fileinput(
    	{
    		theme: 'fas',
      		language: 'es',
    		showCaption: false, 
    		dropZoneEnabled: false,
    		showUpload: false,
            mainClass: "input-group-lg",
            browseIcon: "<i class='fas fa-camera'></i>&nbsp;",
            allowedFileExtensions: ["jpg", "png", "jpeg","pdf","docx","doc"],
    	}
    );

    $("#add").click(function() {
		abrirModal();    	
    });

    $( "#formulario-crear-tipo" ).submit(function( event ) {
      event.preventDefault();
      crear_tipo($(this).attr('action'),$(this).serializeArray());
  	});

    $( "#formulario-crear-gasto" ).submit(function( event ) {
      event.preventDefault();
      crear_gasto($(this).attr('action'),$(this).serializeArray());
  	});
    
    $(".btn-secondary").addClass("btn-danger");
    $(".btn-danger").addClass("btn-secondary");
});

function format(input)
{
	var num = input.value.replace(/\./g,'');
	if(!isNaN(num)){
		num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
		num = num.split('').reverse().join('').replace(/^[\.]/,'');
		input.value = num;
	}else{ alert('Solo se permiten numeros');
		input.value = input.value.replace(/[^\d\.]*/g,'');
	}
}

function crear_tipo(action,datos) {
  var formData = new FormData();
  formData=crearObjetoFormData(datos);
  $.ajax({
      data: formData,
      url: action,
      type: "post",
      contentType: false,
      processData: false,
      success:function(e){
          var obj = JSON.parse(e);
          if(obj["error"]!=0){
            check_todo_input_verificado();
            validate_errores_peticion_ajax(obj);
          }else if(obj["error"]==0){
            ohSnap('Se guardo correctamente',{color: 'green'});
            $(".modal").modal("hide");
          }else{
            ohSnap('Error desconocido.',{color: 'green'});
          }
      },
      error:function(){
          ohSnap('Error ha iniciar session',{color: 'red'});
      }
  });
}

function crear_gasto(action,datos) {
  var formData = new FormData();
  formData=crearObjetoFormData(datos);
  if($('#input-b5').val() !== undefined){
    var files = $('#input-b5')[0].files[0];
    formData.append('img_name',$('#input-b5').val().split('\\').pop());
    formData.append('img',files);
  }
  
  $.ajax({
      data: formData,
      url: action,
      type: "post",
      contentType: false,
      processData: false,
      success:function(e){
          var obj = JSON.parse(e);
          if(obj["error"]!=0){
            check_todo_input_verificado();
            validate_errores_peticion_ajax(obj);
          }else if(obj["error"]==0){
          	$("input").val('');
          	$("textarea").val('');
          	$("select option[0]").attr("selected",true);
            ohSnap('Se guardo correctamente',{color: 'green'});
          }else{
            ohSnap('Error desconocido.',{color: 'green'});
          }
      },
      error:function(){
          ohSnap('Error ha iniciar session',{color: 'red'});
      }
  });
}

function abrirModal(){
	$("#agragar").modal("show");
}
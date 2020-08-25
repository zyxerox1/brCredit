$(document).ready(function() {
	/*$( "#formulario-login" ).submit(function( event ) {
      event.preventDefault();
      login($(this).attr('action'),$(this).serialize());
  	});*/

  	$("#visualizacion").click(function() {
	    if ($("#visualizacion3").attr("class") == "fas fa-eye") {
	      $('input[name=pas]').attr("type", "text");
	      $("#visualizacion3").removeClass("fa-eye");
	      $("#visualizacion3").addClass("fa-eye-slash");
	    } else {
	      $('input[name=pas]').attr("type", "password");
	      $("#visualizacion3").addClass("fa-eye");
	      $("#visualizacion3").removeClass("fa-eye-slash");
	    }
	});

  	$('#user').on('keyup', function() {
	    var caneda=$(this).val();
	    if(validar_char_especial(caneda)==0){
	      $('#usuario_icon').addClass('fa-id-card');
	      $('#usuario_icon').removeClass('fa-envelope');
	      $(this).prop('type', 'text');
	      $(this).val('');
	      $(this).val(caneda);
	    }else{
	      $('#usuario_icon').removeClass('fa-id-card');
	      $('#usuario_icon').addClass('fa-envelope');
	    }
	});
});

function validar_char_especial(e) {
  var retorno=0;
  for (var i=0; i < e.length; i++) {
    var tecla=e[i].charCodeAt(0);
    // Patron de entrada, en este caso solo acepta numeros y letras
    patron = /[0-9]/;
    tecla_final = String.fromCharCode(tecla);

    if(patron.test(tecla_final)==false){
      retorno+=1;
    }
  }
  return retorno;
}

/*function login(action,datos) {
  $.ajax({
      data: datos,
      url: action,
      type: "post",
      success:function(resp){
        resp=parseInt(resp);
        switch (resp) {
          case 0:
            ohSnap('Inicio de session correctamente.',{color: 'green'});

          break;
          case 1:
            ohSnap('Usuario o contraseña incorrecta.',{color: 'red'});
          break;
          case 2:
            ohSnap('La direccón de correo o nombre de usuario no es válida.',{color: 'red'});
          break;
          default:
            ohSnap('Error desconocido ha iniciar session.',{color: 'red'});
          break;
        }
      },
      error:function(){
          ohSnap('Error ha iniciar session',{color: 'red'});
      }
  });
}*/
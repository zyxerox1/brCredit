$(document).ready(function() {
	

	$( "#consultar" ).on('click', function () {
		console.log("ddd");
		if($("#auditoria" ).val()!=0){
			ajaxAuditoriaCambiar($("#auditoria" ).val(),$("#auditoria" ).find('option:selected').attr("data-tittle"));
		}else{
			$(".container-auditoria").html("");
			$(".tittle-reporte").html("");
		}
	});

	$( "#csv" ).on('click', function () {
		if($("#auditoria" ).val()!=0){
			ajaxAuditoriaCambiar($("#auditoria" ).val(),$("#auditoria" ).find('option:selected').attr("data-tittle"));
		}else{
			ohSnap('Tiene que selecionar un reporte.',{color: 'red'});
			$("#auditoria" ).focus();
			shake($("#auditoria" ));
		}
	});
	
	//ajaxAuditoriaCambiar("reporte_log_usuario","Reporte de usuario");
});

function ajaxAuditoriaCambiar(control,tittle=""){
	var url="index.php?c="+control+"&a=master_index";
	$.ajax({
	    url: url,
	    type: "get",
	    username: "master",
	    success:function(e){
	 		$(".container-auditoria").slideToggle(1000,"swing");
	     	$(".container-auditoria").html(e);
	     	$(".container-auditoria").slideToggle(1000,"swing");
     	    var footer= document.getElementsByTagName('footer')[0];
		    var script= document.createElement('script');
		    script.src= './view/assets/js/script.js';
		    footer.appendChild(script);
		    $(".tittle-reporte").html('<i class="fas fa-clipboard-list"></i> '+tittle);
	    },
	    error:function(){
	        ohSnap('Error desconocido',{color: 'red'});
	    }
  	});
}
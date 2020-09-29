$(document).ready(function() {
	$( "#auditoria" ).change(function() {
		if($(this).val()!=0){
			ajaxAuditoriaCambiar($(this).val(),$(this).find('option:selected').attr("data-tittle"));
		}else{
			$(".container-auditoria").html("");
			$(".tittle-reporte").html("");
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
	    	$(".container-auditoria").animate({
			    height: "toggle"
			  }, 2000);
	     	$(".container-auditoria").html(e);
	     	$(".container-auditoria").animate({
			    height: "toggle"
			  }, 2000);
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
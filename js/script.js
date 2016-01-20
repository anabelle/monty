/* 
	Author: Anabelle Handdoek
*/
// remap jQuery to $
(function($){

$(function(){
	//REVISA SI EXISTE UN HASH Y TRABAJAMOS CON EL
	var jash = window.location.hash; 
	var jasho =  jash;
	if(jash.length > 1){ 
		//alert(jasho);
		$(jasho + " a").addClass('activo').addClass('loading').removeClass('inactivo');
		var $cuale=$(jasho).attr("id");
		var $cual=$cuale.match(/\d/g);
		$cual = $cual.join("");
		//alert($cual);
		// call ajax

		$.ajax({
			url:"/wp-admin/admin-ajax.php",
			type:'POST',
			data:'action=contenido_obra&cual=' + $cual,
			success:function(results){
				//alert(results);
				$("#post-inner-" + $cual).html(results);
				$("#obra-" + $cual + " a ").removeClass('loading');
				$("#post-inner-" + $cual).slideDown(3333);
				window.location.hash = 'obra-' + $cual;
                	}
		});
	}

	// $("h1").hide(); 
	$('.entry-title a.inactivo').live('click' , function(){
		$(this).addClass('activo').addClass('loading').removeClass('inactivo');
		var $cual=$(this).attr("id");
		// call ajax

		$.ajax({
			url:"/wp-admin/admin-ajax.php",
			type:'POST',
			data:'action=contenido_obra&cual=' + $cual,
			success:function(results){
				//alert(results);
				$("#post-inner-" + $cual).html(results);
				$("#obra-" + $cual + " a ").removeClass('loading');
				$("#post-inner-" + $cual).slideDown(3333);
				window.location.hash = 'obra-' + $cual;
                	}
		});

		return false;
	});

	$('a.activo').live('click', function(){
      		$(this).removeClass('activo').addClass('desactivado');
		var $cuales=$(this).attr("id");
		$("#post-inner-" + $cuales).slideUp(1234);
		return false;
	});

	$('a.desactivado').live('click', function(){
      		$(this).removeClass('desactivado').addClass('activo');
		var $cuales=$(this).attr("id");
		$("#post-inner-" + $cuales).slideDown(3333);
		window.location.hash = 'obra-' + $cuales;
		return false;
	});

	//CONTACTO

	$('#montyme.off').live('click', function(){
		$(this).removeClass('off').addClass('on');
		$('#contacto').removeClass('desactivado').addClass('activo').slideDown(333);
	});

	$('#montyme.on').live('click', function(){
		$(this).removeClass('on').addClass('off');
		$('#contacto').removeClass('activo').addClass('desactivado').slideUp(333);
	});
});

})(window.jQuery);

























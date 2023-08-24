<script>
//script que adiciona automaticamente um aviso de carregamento em qualquer chamada ajax onde for inserido
$(document).ready(function () {

	$(document).ajaxStart(function(){
	    $('body').append('<div id="ajax-loader"></div>');
	});

	$(document).ajaxComplete(function(){
	    $('#ajax-loader').remove();
	});

});

</script>